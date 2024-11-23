<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\DHL;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class RoadStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        if (\in_array($this->service_code, ['dhlroad.aspo', 'dhlroad.aspor'], true)) {
            return (
                new ServicePointStrategy(
                    carrier_code: $this->carrier_code,
                    service_code: $this->service_code,
                    language: $this->language,
                    type: $this->type,
                )
            )->generate($trackingCode);
        }

        return \sprintf('https://activetracing.dhl.com/DatPublic/search.do?consignmentId&lang=%s&at=package&valuePackageField=%s', $this->language, $trackingCode);
    }
}
