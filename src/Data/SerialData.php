<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Data;

use Spatie\LaravelData\Data;

final class SerialData extends Data
{
    /**
     * @param array<string, string> $groups
     */
    public function __construct(
        public readonly string $serial,
        public readonly ?string $checkDigit = null,
        public readonly ?ChecksumData $checksum = null,
        public readonly ?array $groups = null,
    ) {}
}
