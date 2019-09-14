<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter\Fixture;

use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCarInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfileInterface;

interface CarInterface
{
    const TEST_DEFAULT_CRATE_CAR_DATA = [
        // used
        'booster_count' => 0,
        'callsign' => 'тест',
        'cargo_loaders' => 0,
        'park_id' => '8d40b7c41af544afa0499b9d0bdf2430',
        'status' => 'working',//todo
        'transmission' => 'unknown',

        // not used
//        CreateCarInterface::AMENITIES => [],

//        CreateCarInterface::BODY_NUMBER => null,
//            CreateCarInterface::CARGO_HOLD_DIMENSIONS => $this->getCargoHoldDimensions($row),
//        CreateCarInterface::CARRIER_PERMIT_OWNER_ID => null,
//        CreateCarInterface::CARRYING_CAPACITY => null,
//        CreateCarInterface::CATEGORIES => [],
//        CreateCarInterface::CHAIRS => [],
//            CreateCarInterface::CHASSIS => null,
//        CreateCarInterface::LOG_TIME => 350, //todo: what is it?
//        CreateCarInterface::PERMIT => null,
//        CreateCarInterface::RENTAL => null,
//        CreateCarInterface::TARIFFS => [],
    ];

    const EXPECTED_POST_DATA = [
        'booster_count' => 0,
        'brand' => 'Alfa Romeo',
        'callsign' => 'тест',
        'cargo_loaders' => 0,
        'color' => 'Серый',
        'model' => '105/115',
        'number' => 'A001AA78',
        'park_id' => '8d40b7c41af544afa0499b9d0bdf2430',
        'registration_cert' => 'AA321354654654',
        'status' => 'working',
        'transmission' => 'unknown',
        'vin' => '1C3EL46U91N594161',
        'year' => 2008,
//        'amenities' =>
//            [
//            ],
//        'body_number' => NULL,
//        'carrier_permit_owner_id' => NULL,
//        'carrying_capacity' => NULL,
//        'categories' =>
//            [
//            ],
//        'chairs' =>
//            [
//            ],
//        'log_time' => 350,
//        'permit' => NULL,
//        'rental' => NULL,
//        'tariffs' =>
//            [
//            ],
    ];
}
