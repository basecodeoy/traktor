<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Support;

use BaseCodeOy\Traktor\Data\CarrierData;

final readonly class Carriers
{
    /**
     * @return array<CarrierData>
     */
    public static function all(): array
    {
        return [
            self::fedex(),
            self::amazon(),
            self::canadapost(),
            self::dhl(),
            self::dpd(),
            self::landmark(),
            self::lasership(),
            self::ontrac(),
            self::s10(),
            self::ups(),
            self::usps(),
        ];
    }

    public static function fedex(): CarrierData
    {
        return self::get('fedex');
    }

    public static function amazon(): CarrierData
    {
        return self::get('amazon');
    }

    public static function canadapost(): CarrierData
    {
        return self::get('canadapost');
    }

    public static function dhl(): CarrierData
    {
        return self::get('dhl');
    }

    public static function dpd(): CarrierData
    {
        return self::get('dpd');
    }

    public static function landmark(): CarrierData
    {
        return self::get('landmark');
    }

    public static function lasership(): CarrierData
    {
        return self::get('lasership');
    }

    public static function ontrac(): CarrierData
    {
        return self::get('ontrac');
    }

    public static function s10(): CarrierData
    {
        return self::get('s10');
    }

    public static function ups(): CarrierData
    {
        return self::get('ups');
    }

    public static function usps(): CarrierData
    {
        return self::get('usps');
    }

    private static function get(string $name): CarrierData
    {
        return CarrierData::from(
            \json_decode(
                (string) \file_get_contents(__DIR__.\sprintf('/../../resources/carriers/%s.json', $name)),
                true,
                512,
                \JSON_THROW_ON_ERROR,
            ),
        );
    }
}
