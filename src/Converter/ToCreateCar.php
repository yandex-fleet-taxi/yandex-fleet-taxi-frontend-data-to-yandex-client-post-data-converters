<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\CarInterface as FrontCarInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCar\CargoHoldDimensionsInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCarInterface;

class ToCreateCar extends Base
{
    public function convert(array $data, $defaultValues = []): array
    {
        $mappedValues = $this->getMappedValues($data);
        $calculatedValues = $this->getCalculatedValues($data);

        return array_replace_recursive($defaultValues, $mappedValues, $calculatedValues);
    }

    private function getMappedValues(array $data)
    {
        $mapping = [
// used

//            CreateCarInterface::BOOSTER_COUNT => 0,
            CreateCarInterface::BRAND => FrontCarInterface::BRAND,
//            CreateCarInterface::CALLSIGN => 'тест',
//            CreateCarInterface::CARGO_LOADERS => 0,
            CreateCarInterface::COLOR => FrontCarInterface::COLOR,
            CreateCarInterface::MODEL => FrontCarInterface::MODEL,
            CreateCarInterface::NUMBER => FrontCarInterface::NUMBER,
//            CreateCarInterface::PARK_ID => null,
            CreateCarInterface::REGISTRATION_CERT => FrontCarInterface::REGISTRATION,
//            CreateCarInterface::STATUS => 'working',
//            CreateCarInterface::TRANSMISSION => 'unknown',
            CreateCarInterface::VIN => FrontCarInterface::VIN,
//            CreateCarInterface::YEAR => FrontCarInterface::ISSUE_YEAR,

// not used
//            CreateCarInterface::AMENITIES => [],
//            CreateCarInterface::BODY_NUMBER => null,
//            CreateCarInterface::CARGO_HOLD_DIMENSIONS => $this->getCargoHoldDimensions($row),
//            CreateCarInterface::CARRIER_PERMIT_OWNER_ID => null,
//            CreateCarInterface::CARRYING_CAPACITY => null,
//            CreateCarInterface::CATEGORIES => [],
//            CreateCarInterface::CHAIRS => [],
//            CreateCarInterface::CHASSIS => null,
//            CreateCarInterface::LOG_TIME => 350, //todo: what is it?
//            CreateCarInterface::PERMIT => null,
//            CreateCarInterface::RENTAL => null,
//            CreateCarInterface::TARIFFS => [],
        ];

        return $this->getValuesByRowNamesMapping($data, $mapping);
    }

    private function getCalculatedValues(array $data)
    {
        return [
            CreateCarInterface::YEAR => (int) $data[FrontCarInterface::ISSUE_YEAR],
        ];
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
