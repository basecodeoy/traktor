<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Values;

use Spatie\LaravelData\Data;

final class Carrier extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
    ) {}
}
