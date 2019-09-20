<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use InvalidArgumentException;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\CarInterface as FrontCarInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCar\CargoHoldDimensionsInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCarInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\Car\BrandingInterface as FrontBrandingInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateCar\AmenityInterface as YandexAmenityInterface;

class ToCreateCar extends Base
{
    const AMENITIES_MAPPING = [
        FrontBrandingInterface::LIGHTBOX => YandexAmenityInterface::STICKER,
        FrontBrandingInterface::STICKER => YandexAmenityInterface::LIGHTBOX,
    ];

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
        $calculatedValues = [
            CreateCarInterface::YEAR => (int) $data[FrontCarInterface::ISSUE_YEAR],
        ];

        if ($amenities = $this->getCalculatedAmenities($data)) {
            $calculatedValues[CreateCarInterface::AMENITIES] = $amenities;
        }

        return $calculatedValues;
    }

    private function getCalculatedAmenities(array $data)
    {
        $carBranding = (isset($data[FrontCarInterface::BRANDING])) ? $data[FrontCarInterface::BRANDING] : null;

        if (!$carBranding) {
            return null;
        }

        return $this->getAmenitiesByCarBrandingString($carBranding);
    }

    private function getAmenitiesByCarBrandingString(string $carBranding)
    {
        $chunks = explode(';', $carBranding);
        $chunks = array_map('trim', $chunks);

        return $this->getAmenitiesByFrontBrandingItems($chunks);
    }

    private function getAmenitiesByFrontBrandingItems(array $items)
    {
        return array_map([$this, 'getAmenityByFrontBrandingItem'], $items);
    }

    private function getAmenityByFrontBrandingItem(string $item)
    {
        $mapping = self::AMENITIES_MAPPING;

        if (!array_key_exists($item, $mapping)) {
            throw new InvalidArgumentException("Invalid branding item value: {$item}");
        }

        return $mapping[$item];
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
