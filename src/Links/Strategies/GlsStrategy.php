<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class GlsStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return $this->buildTrackingUrl(
            match ($this->language) {
                'fi' => 'https://gls-group.eu/FI/fi/laehetysseuranta',
                default => 'https://gls-group.eu/FI/en/parcel-tracking',
            },
            [
                'match' => $trackingCode,
            ],
        );
    }
}
