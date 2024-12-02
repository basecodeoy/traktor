<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Data;

use Spatie\LaravelData\Data;

final class ChecksumData extends Data
{
    /**
     * @param null|array<int> $weightings
     */
    public function __construct(
        public readonly string $name,
        public readonly ?int $evens_multiplier,
        public readonly ?int $odds_multiplier,
        public readonly ?array $weightings,
        public readonly ?int $modulo1,
        public readonly ?int $modulo2,
    ) {}
}
