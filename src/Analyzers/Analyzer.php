<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Analyzers;

use BaseCodeOy\Traktor\Data\AdditionalData;
use BaseCodeOy\Traktor\Data\CarrierData;
use BaseCodeOy\Traktor\Data\LookupData;
use BaseCodeOy\Traktor\Data\SerialData;
use BaseCodeOy\Traktor\Data\SerialNumberFormatData;
use BaseCodeOy\Traktor\Data\TrackingNumberData;
use BaseCodeOy\Traktor\Support\Carriers;
use BaseCodeOy\Traktor\Values\TrackingNumber;
use Illuminate\Support\Arr;

/**
 * @see https://github.com/jkeen/tracking_number_data
 */
final readonly class Analyzer
{
    public function analyze(string $trackingNumber): ?TrackingNumber
    {
        foreach (Carriers::all() as $carrierData) {
            foreach ($carrierData->tracking_numbers as $trackingNumberData) {
                $serialData = $this->getSerialData($trackingNumber, $trackingNumberData);

                if (!$serialData instanceof SerialData) {
                    continue;
                }

                $validator = $this->validator($trackingNumberData, $serialData);

                if (!$validator) {
                    continue;
                }

                $additional = $this->additional($trackingNumberData, $trackingNumber);

                if ($additional) {
                    return $this->toTrackingNumber($trackingNumberData, $carrierData, $trackingNumber);
                }
            }
        }

        return null;
    }

    private function getSerialData(string $trackingNumber, TrackingNumberData $trackingData): ?SerialData
    {
        $matchedTrackingData = $this->matchTrackingData($trackingNumber, $trackingData->regex);

        if (!$matchedTrackingData instanceof SerialData) {
            return null;
        }

        if (!$trackingData->validation->serial_number_format instanceof SerialNumberFormatData) {
            $serial = $matchedTrackingData->serial;
        } else {
            $serial = $this->formatSerial($matchedTrackingData->serial, $trackingData->validation->serial_number_format);
        }

        return SerialData::from([
            'serial' => $serial,
            'checkDigit' => $matchedTrackingData->checkDigit ?? null,
            'checksum' => $trackingData->validation->checksum,
        ]);
    }

    private function matchTrackingData(string $trackingNumber, array|string $regex): ?SerialData
    {
        $pattern = \is_string($regex) ? $regex : \implode('', $regex);

        \preg_match(
            \sprintf('/\b%s\b/', $pattern),
            (string) \preg_replace('/\s+/', '', $trackingNumber),
            $matches,
        );

        if ($matches === []) {
            return null;
        }

        return SerialData::from([
            'serial' => \preg_replace('/\s/', '', $matches['SerialNumber']),
            'checkDigit' => Arr::get($matches, 'CheckDigit'),
            'groups' => \array_filter($matches, 'is_string', \ARRAY_FILTER_USE_KEY),
        ]);
    }

    private function formatSerial(string $serial, SerialNumberFormatData $numberFormat): string
    {
        if ($numberFormat->prepend_if instanceof \BaseCodeOy\Traktor\Data\PrependIfData && \preg_match('/'.$numberFormat->prepend_if->matches_regex.'/', $serial)) {
            return $numberFormat->prepend_if->content.$serial;
        }

        return $serial;
    }

    private function validator(TrackingNumberData $trackingData, SerialData $serialData): bool
    {
        if ($trackingData->validation->checksum?->name === 'mod10') {
            return $this->mod10($serialData);
        }

        if ($trackingData->validation->checksum?->name === 'sum_product_with_weightings_and_modulo') {
            return $this->sumProductWithWeightingsAndModulo($serialData);
        }

        if ($trackingData->validation->checksum?->name === 'mod7') {
            return $this->mod7($serialData);
        }

        if ($trackingData->validation->checksum?->name === 's10') {
            return $this->validateS10($serialData);
        }

        return true;
    }

    private function additional(TrackingNumberData $tracking, string $t): bool
    {
        if ($tracking->additional instanceof \Spatie\LaravelData\DataCollection) {
            foreach ($tracking->additional as $additionalCheck) {
                $additionalCheck = $this->additionalCheck($additionalCheck);

                if (!$additionalCheck($this->matchTrackingData($t, $tracking->regex))) {
                    return false;
                }
            }

            return true;
        }

        return true;
    }

    private function additionalCheck(AdditionalData $additional): callable
    {
        return function (SerialData $match) use ($additional): bool {
            if ($additional->name === 'ServiceType') {
                /** @var LookupData $x */
                foreach ($additional->lookup as $x) {
                    // @phpstan-ignore-next-line
                    if ($x->matches_regex !== null && \preg_match('/'.$x->matches_regex.'/', $match[$additional->name])) {
                        return true;
                    }
                }

                return true;
            }

            if (\in_array($additional->name, ['CountryCode', 'ShippingContainerType'], true)) {
                /** @var LookupData $x */
                foreach ($additional->lookup as $x) {
                    // @phpstan-ignore-next-line
                    if ($x->matches === $match[$additional->name]) {
                        return true;
                    }
                }

                return false;
            }

            return true;
        };
    }

    private function toTrackingNumber(TrackingNumberData $t, CarrierData $c, string $trackingNumber): TrackingNumber
    {
        return TrackingNumber::from([
            'name' => $t->name,
            'trackingUrl' => $t->tracking_url,
            'description' => $t->description,
            'trackingNumber' => \preg_replace('/[^a-zA-Z\d]/', '', $trackingNumber),
            'carrier' => [
                'name' => $c->name,
                'code' => $c->courier_code,
            ],
        ]);
    }

    private function sumProductWithWeightingsAndModulo(SerialData $serialData): bool
    {
        $serial = $serialData->serial;
        $checkDigit = $serialData->checkDigit;
        $checksum = $serialData->checksum;

        if (!isset($checksum->weightings, $checksum->modulo1, $checksum->modulo2)) {
            // Handle missing data appropriately
            return false;
        }

        $weightSum = $this->addWeight($checksum->weightings, $serial);
        $modResult = $weightSum % $checksum->modulo1 % $checksum->modulo2;

        return $modResult === (int) $checkDigit;
    }

    private function validateS10(SerialData $serialData): bool
    {
        $serial = $serialData->serial;
        $checkDigit = $serialData->checkDigit;

        $remainder = $this->addWeight([8, 6, 4, 2, 3, 5, 9, 7], $serial) % 11;

        if ($remainder === 1) {
            $check = 0;
        } elseif ($remainder === 0) {
            $check = 5;
        } else {
            $check = 11 - $remainder;
        }

        return $check === (int) $checkDigit;
    }

    private function mod10(SerialData $serialData): bool
    {
        $serial = \preg_replace('/[^\da-zA-Z]/', '', $serialData->serial);
        $checkDigit = $serialData->checkDigit;
        $checksum = $serialData->checksum;

        $t = $this->formatList((string) $serial);
        $keySum = \array_sum([
            $this->getSum(fn ($v, $k): bool => $this->evenKeys($k), $t) * ($checksum->evens_multiplier ?? 1),
            $this->getSum(fn ($v, $k): bool => $this->oddKeys($k), $t) * ($checksum->odds_multiplier ?? 1),
        ]);

        return (10 - $keySum % 10) % 10 === (int) $checkDigit;
    }

    private function mod7(SerialData $serialData): bool
    {
        $serial = (int) $serialData->serial;
        $checkDigit = (int) $serialData->checkDigit;

        return $serial % 7 === $checkDigit;
    }

    private function addWeight(array $weightings, string $serial): int
    {
        $serialNumbers = \array_map('intval', \mb_str_split($serial));
        $sum = 0;

        foreach ($serialNumbers as $i => $num) {
            $weight = $weightings[$i] ?? 0;
            $sum += $num * $weight;
        }

        return $sum;
    }

    private function formatList(string $tracking): array
    {
        $trackingArray = \mb_str_split($tracking);

        return \array_map(function ($x): int {
            if (!\is_numeric($x)) {
                return (\ord($x) - 3) % 10;
            }

            return (int) $x;
        }, $trackingArray);
    }

    private function toObj(array $list): array
    {
        return \array_combine(\array_keys($list), $list);
    }

    private function evenKeys(mixed $k): bool
    {
        return $k % 2 === 0;
    }

    private function oddKeys(mixed $k): bool
    {
        return !$this->evenKeys($k);
    }

    private function getSum(callable $parityFn, array $tracking): int
    {
        $obj = $this->toObj($tracking);
        $filteredValues = \array_filter($obj, $parityFn, \ARRAY_FILTER_USE_BOTH);

        return \array_sum($filteredValues);
    }
}
