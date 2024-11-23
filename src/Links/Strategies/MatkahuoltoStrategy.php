<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class MatkahuoltoStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return $this->buildTrackingUrl(
            match ($this->language) {
                'fi' => 'https://www.matkahuolto.fi/seuranta',
                'sv' => 'https://www.matkahuolto.fi/uppfoljning',
                default => 'https://www.matkahuolto.fi/tracking',
            },
            [
                'parcelNumber' => $trackingCode,
            ],
        );
    }
}
