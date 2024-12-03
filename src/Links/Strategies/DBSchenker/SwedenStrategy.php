<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies\DBSchenker;

use BaseCodeOy\Traktor\Links\Strategies\AbstractStrategy;

final class SwedenStrategy extends AbstractStrategy
{
    #[\Override()]
    public function generate(string $trackingCode): ?string
    {
        // https://eschenker.dbschenker.com/app/tracking-public/?refNumber=[REF]&refType=PackageId&language_region=sv-SE_SE
        // &language_region=sv-SE_SE
        return \sprintf('https://www.dbschenker.com/se-sv/foretag/kontakta-oss/spara-och-sok?reference_number=%s&language=sv_SE', $trackingCode);
    }
}
