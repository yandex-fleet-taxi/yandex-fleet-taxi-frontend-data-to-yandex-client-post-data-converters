<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver;

use InvalidArgumentException;

class DriverLicenceIssueCountry
{
    private $countries;

    public function __construct(array $countries)
    {
        $this->countries = $countries;
    }

    public function convert($frontCountryName): string
    {
        $key = array_search($frontCountryName, $this->countries);

        if ($key === false) {
            throw new InvalidArgumentException("Invalid fron country name: {$frontCountryName}");
        }

        return $key;
    }
}
