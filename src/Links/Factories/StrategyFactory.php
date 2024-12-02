<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Traktor\Links\Factories;

use BaseCodeOy\Traktor\Links\Strategies;
use BaseCodeOy\Traktor\Links\Strategies\StrategyInterface;
use Illuminate\Support\Facades\App;

final readonly class StrategyFactory
{
    public static function make(
        string $carrier_code,
        string $service_code,
        string $language,
        string $type,
    ): StrategyInterface {
        return App::make(
            match ($carrier_code) {
                'asendia' => Strategies\AsendiaStrategy::class,
                'bcmse' => Strategies\CityMailStrategy::class,
                'budbee' => Strategies\BudbeeStrategy::class,
                'cg' => Strategies\BussgodsStrategy::class,
                'dhlfreightfi' => Strategies\DHL\FreightStrategy::class,
                'dhlroad' => Strategies\DHL\RoadStrategy::class,
                'dpd' => Strategies\DpdStrategy::class,
                'fedex' => Strategies\FedExStrategy::class,
                'glsfi' => Strategies\GlsStrategy::class,
                'itellalog' => Strategies\PostiStrategy::class,
                'jakeluyhtio_suomi' => Strategies\JakeluyhtioSuomiStrategy::class,
                'kl' => Strategies\DBSchenker\ParcelStrategy::class,
                'kaukokiito' => Strategies\KaukokiitoStrategy::class,
                'mh' => Strategies\MatkahuoltoStrategy::class,
                'netlux' => Strategies\NetluxStrategy::class,
                'omni' => Strategies\OmnivaStrategy::class,
                'pbrev' => Strategies\PostNord\VarubrevStrategy::class,
                'plab' => Strategies\PostNord\SwedenStrategy::class,
                'plscm' => Strategies\PostNord\FinlandStrategy::class,
                'pnl' => Strategies\BringStrategy::class,
                'posti' => Strategies\PostiStrategy::class,
                'postnord' => Strategies\PostNord\FinlandStrategy::class,
                'sbtl' => Strategies\DBSchenker\SwedenStrategy::class,
                'sbtlfi' => Strategies\DBSchenker\FreightStrategy::class,
                'sbtlfiexp' => Strategies\DBSchenker\ParcelStrategy::class,
                'sbtlfirrex' => Strategies\DBSchenker\PickupStrategy::class,
                'ups' => Strategies\UpsStrategy::class,
                'wolt' => Strategies\WoltStrategy::class,
            },
            [
                'carrier_code' => $carrier_code,
                'service_code' => $service_code,
                'language' => $language,
                'type' => $type,
            ],
        );
    }
}
