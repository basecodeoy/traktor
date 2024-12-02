<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

final class UpsStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        // UPS Does not support waybill tracking links (edited 08.03.21)
        if ($this->type === 'waybill') {
            return null;
        }

        return $this->buildTrackingUrl(
            'https://wwwapps.ups.com/WebTracking/processInputRequest',
            [
                'TypeOfInquiryNumber' => 'T',
                'loc' => match ($this->language) {
                    'fi' => 'fi_FI',
                    'sv' => 'sv_SE',
                    default => 'en_FI',
                },
                'InquiryNumber1' => $trackingCode, // Supports multiple codes, same GET param
            ],
        );
    }
}
