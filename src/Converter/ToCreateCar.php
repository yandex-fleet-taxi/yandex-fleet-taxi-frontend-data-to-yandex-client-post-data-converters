<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\CreateCar\CarInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCarInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCar\CargoHoldDimensionsInterface;

class ToCreateCar extends Base
{
    public function convert(array $headers, array $row, string $parkId): array
    {
        $defaultValues = $this->getDefaultValues();
        $mappedValues = $this->getMappedValues($headers, $row);
        $calculatedValues = $this->getCalculatedValues($headers, $row, $parkId);

        return array_replace_recursive($defaultValues, $mappedValues, $calculatedValues);
    }

    private function getCalculatedValues(array $headers, array $row, string $parkId)
    {
        return [
            CreateCarInterface::PARK_ID => $parkId,
        ];//todo
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

    private function getMappedValues(array $headers, array $row)
    {
        $mapping = [
//            CreateCarInterface::AMENITIES => [],
//            CreateCarInterface::BODY_NUMBER => null,
//            CreateCarInterface::BOOSTER_COUNT => 0,
            CreateCarInterface::BRAND => CarInterface::BRAND,
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
            CreateCarInterface::MODEL => CarInterface::MODEL,
            CreateCarInterface::NUMBER => CarInterface::NUMBER,
//            CreateCarInterface::PARK_ID => null,
//            CreateCarInterface::PERMIT => null,
//            CreateCarInterface::REGISTRATION_CERT => null,
//            CreateCarInterface::RENTAL => null,
//            CreateCarInterface::STATUS => 'working',//todo
//            CreateCarInterface::TARIFFS => [],
//            CreateCarInterface::TRANSMISSION => 'unknown',
            CreateCarInterface::VIN => CarInterface::VIN,
//            CreateCarInterface::YEAR => 2017,
        ];

        return $this->getValuesByRowNamesMapping($headers, $row, $mapping);
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
