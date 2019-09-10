<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\CarInterface as FrontCarInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCar\CargoHoldDimensionsInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCarInterface;

class ToCreateCar extends Base
{
    public function convert(array $data, string $parkId): array
    {
        $defaultValues = $this->getDefaultValues();
        $mappedValues = $this->getMappedValues($data);
        $calculatedValues = $this->getCalculatedValues($data, $parkId);

        return array_replace_recursive($defaultValues, $mappedValues, $calculatedValues);
    }

    private function getDefaultValues()
    {
        return [
            CreateCarInterface::AMENITIES => [],
            CreateCarInterface::BODY_NUMBER => null,
            CreateCarInterface::BOOSTER_COUNT => 0,
//            CreateCarInterface::BRAND => null,
            CreateCarInterface::CALLSIGN => 'тест',
//            CreateCarInterface::CARGO_HOLD_DIMENSIONS => $this->getCargoHoldDimensions($row),
            CreateCarInterface::CARGO_LOADERS => 0,
            CreateCarInterface::CARRIER_PERMIT_OWNER_ID => null,
            CreateCarInterface::CARRYING_CAPACITY => null,
            CreateCarInterface::CATEGORIES => [],
            CreateCarInterface::CHAIRS => [],
//            CreateCarInterface::CHASSIS => null,
            CreateCarInterface::COLOR => 'Черный',//todo
            CreateCarInterface::LOG_TIME => 350, //todo: what is it?
//            CreateCarInterface::MODEL => null,
//            CreateCarInterface::NUMBER => null,
//            CreateCarInterface::PARK_ID => null,
            CreateCarInterface::PERMIT => null,
            CreateCarInterface::REGISTRATION_CERT => '1111111',
            CreateCarInterface::RENTAL => null,
            CreateCarInterface::STATUS => 'working',//todo
            CreateCarInterface::TARIFFS => [],
            CreateCarInterface::TRANSMISSION => 'unknown',
//            CreateCarInterface::VIN => null,
            CreateCarInterface::YEAR => 2017,
        ];
    }

    private function getMappedValues(array $data)
    {
        $mapping = [
//            CreateCarInterface::AMENITIES => [],
//            CreateCarInterface::BODY_NUMBER => null,
//            CreateCarInterface::BOOSTER_COUNT => 0,
            CreateCarInterface::BRAND => FrontCarInterface::BRAND,
//            CreateCarInterface::CALLSIGN => 'тест',
//            CreateCarInterface::CARGO_HOLD_DIMENSIONS => $this->getCargoHoldDimensions($row),
//            CreateCarInterface::CARGO_LOADERS => 0,
//            CreateCarInterface::CARRIER_PERMIT_OWNER_ID => null,
//            CreateCarInterface::CARRYING_CAPACITY => null,
//            CreateCarInterface::CATEGORIES => [],
//            CreateCarInterface::CHAIRS => [],
//            CreateCarInterface::CHASSIS => null,
//            CreateCarInterface::COLOR => 'Черный',//todo
//            CreateCarInterface::LOG_TIME => 350, //todo: what is it?
            CreateCarInterface::MODEL => FrontCarInterface::MODEL,
            CreateCarInterface::NUMBER => FrontCarInterface::NUMBER,
//            CreateCarInterface::PARK_ID => null,
//            CreateCarInterface::PERMIT => null,
//            CreateCarInterface::REGISTRATION_CERT => null,
//            CreateCarInterface::RENTAL => null,
//            CreateCarInterface::STATUS => 'working',//todo
//            CreateCarInterface::TARIFFS => [],
//            CreateCarInterface::TRANSMISSION => 'unknown',
            CreateCarInterface::VIN => FrontCarInterface::VIN,
//            CreateCarInterface::YEAR => 2017,
        ];

        return $this->getValuesByRowNamesMapping($data, $mapping);
    }

    private function getCalculatedValues(array $data, string $parkId)
    {
        return [
            CreateCarInterface::PARK_ID => $parkId,
        ];//todo
    }

    private function getTariffs(array $row): array
    {
        return [
            //todo
        ];
    }

    private function getChairs(array $row): array
    {
        return [
            //todo
        ];
    }

    private function getCategories(array $row):array
    {
        return [
          //todo
        ];
    }

    private function getCargoHoldDimensions(array $row)
    {
        return [
            CargoHoldDimensionsInterface::HEIGHT => null,
            CargoHoldDimensionsInterface::LENGTH => null,
            CargoHoldDimensionsInterface::WIDTH => null,
        ];
    }

    private function getAmenitiesByRow($row)
    {
        return [
            //todo
        ];
    }
}
