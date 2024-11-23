<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\PostNord;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class SwedenStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return $this->buildTrackingUrl(
            'https://tracking.postnord.com/sv/',
            [
                'id' => $trackingCode,
                'lang' => $this->language,
            ],
        );
    }
}
