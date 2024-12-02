<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class FedExStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return $this->buildTrackingUrl(
            'https://www.fedex.com/apps/fedextrack/index.html',
            [
                'tracknumbers' => $trackingCode,
                'locale' => match ($this->language) {
                    'fi' => 'fi_fi',
                    default => 'us_en',
                },
            ],
        );
    }
}
