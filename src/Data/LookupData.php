<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Data;

use Spatie\LaravelData\Data;

final class LookupData extends Data
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $matches,
        public readonly ?string $matches_regex,
        public readonly ?string $description,
        public readonly ?string $country,
        public readonly ?string $courier,
        public readonly ?string $courier_url,
        public readonly ?string $upu_reference_url,
    ) {}
}
