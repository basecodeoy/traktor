<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\DHL;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class ServicePointStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return \mb_strlen($trackingCode) >= 18
            ? \sprintf('https://activetracing.dhl.com/DatPublic/search.do?search=consignmentId&autoSearch=true&l=%s&at=package&a=%s', $this->language, $trackingCode)
            : \sprintf('https://activetracing.dhl.com/DatPublic/search.do?search=consignmentId&autoSearch=true&l=%s&at=consignment&a=%s', $this->language, $trackingCode);
    }
}
