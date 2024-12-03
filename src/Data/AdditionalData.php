<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

final class AdditionalData extends Data
{
    /**
     * @param DataCollection<LookupData> $lookup
     */
    public function __construct(
        public readonly string $name,
        public readonly string $regex_group_name,
        #[DataCollectionOf(LookupData::class)]
        public readonly DataCollection $lookup,
    ) {}
}
