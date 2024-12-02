<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Data;

use Spatie\LaravelData\Data;

final class SerialNumberFormatData extends Data
{
    public function __construct(
        public readonly ?PrependIfData $prepend_if,
    ) {}
}
