<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class PostiStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return $this->buildTrackingUrl(
            match ($this->language) {
                'fi' => 'https://www.posti.fi/fi/seuranta/#/lahetys/'.$trackingCode,
                'sv' => 'https://www.posti.fi/sv/uppfoljning/#/lahetys/'.$trackingCode,
                default => 'https://www.posti.fi/en/tracking/#/lahetys/'.$trackingCode,
            },
            ['lang' => $this->language],
        );
    }
}
