<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\DBSchenker;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class ParcelStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        $type = match (true) {
            \mb_strlen($trackingCode) >= 18 => 'PackageId',
            \mb_strlen($trackingCode) === 13 && \str_contains($trackingCode, '-') => 'BookingId',
            default => 'WaybillNo',
        };

        return \sprintf(
            'https://eschenker.dbschenker.com/app/tracking-public/?refNumber=%s&refType=%s&language_region=%s',
            $type === 'PackageId' ? '00'.$trackingCode : $trackingCode,
            $type,
            match ($this->language) {
                'sv' => 'sv-SE_SE',
                'en' => 'en-US_US',
                default => 'fi-FI_FI',
            },
        );
    }
}
