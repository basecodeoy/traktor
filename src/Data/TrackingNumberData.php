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

final class TrackingNumberData extends Data
{
    /**
     * @param array<string>|string                $regex
     * @param null|DataCollection<AdditionalData> $additional
     */
    public function __construct(
        public readonly ?string $tracking_url,
        public readonly string $name,
        public readonly ?string $description,
        public readonly array|string $regex,
        public readonly ValidationData $validation,
        public readonly TestNumbersData $test_numbers,
        #[DataCollectionOf(AdditionalData::class)]
        public readonly ?DataCollection $additional,
    ) {}
}
