<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class BringStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return $this->buildTrackingUrl(
            match ($this->language) {
                'sv' => 'https://tracking.bring.se/tracking/'.$trackingCode,
                default => 'https://tracking.bring.com/tracking/'.$trackingCode,
            },
            [
                'lang' => $this->language,
            ],
        );
    }
}
