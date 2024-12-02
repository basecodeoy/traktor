<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Actions;

use BaseCodeOy\Traktor\Links\Factories\StrategyFactory;

final readonly class GenerateTrackingLink
{
    public function execute(
        string $carrier_code,
        string $service_code,
        string $trackingCode,
        string $lang = 'fi',
        string $type = 'parcel',
    ): ?string {
        return StrategyFactory::make(
            carrier_code: $carrier_code,
            service_code: $service_code,
            language: $lang,
            type: $type,
        )->generate($trackingCode);
    }
}
