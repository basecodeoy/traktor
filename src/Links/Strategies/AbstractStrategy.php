<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Strategies;

abstract class AbstractStrategy implements StrategyInterface
{
    public function __construct(
        protected readonly string $carrier_code,
        protected readonly string $service_code,
        protected readonly string $language,
        protected readonly string $type,
    ) {}

    protected function buildTrackingUrl(string $base_url, array $parameters): string
    {
        $query = \http_build_query($parameters);

        if (empty($query)) {
            return $base_url;
        }

        return \sprintf('%s?%s', $base_url, $query);
    }
}
