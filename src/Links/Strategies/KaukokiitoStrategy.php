<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class KaukokiitoStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return match ($this->language) {
            'fi' => \sprintf('https://www.kaukokiito.fi/fi/kaukoputki/seuranta/?query=%s&type=Parcel', $trackingCode),
            default => \sprintf('https://www.kaukokiito.fi/en/kaukoputki/track-and-trace/?query=%s&type=Parcel', $trackingCode),
        };
    }
}
