<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\DHL;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class FreightStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return \sprintf('https://www.dhl.com/fi-fi/home/tracking.html?tracking-id=%s&submit=1', $trackingCode);
    }
}
