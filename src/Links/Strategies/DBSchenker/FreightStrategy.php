<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\DBSchenker;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class FreightStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        return \sprintf(
            'https://www.dbschenker.com/app/tracking-public/?refNumber=%s&refType=WaybillNo',
            $trackingCode,
        );
    }
}
