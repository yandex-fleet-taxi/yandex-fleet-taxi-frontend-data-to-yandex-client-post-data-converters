<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver as ToCreateDriverConverter;
use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter\Fixture\DriverInterface;
use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver\DriverLicenceIssueCountry as IssueCountryConverter;

class ToCreateDriverTest extends Base
{
    public function testConvert()
    {
        $testData = $this->getTestData();
        $defaultValues = $this->getTestDefaultValues();

        $issueCountryConverter = $this->getTestIssueCountryConverter();
        $converter = new ToCreateDriverConverter($issueCountryConverter);
        $driverPostData = $converter->convert($testData, $defaultValues);

        $expectedDriverPostData = $this->getExpectedDriverPostData();
        $this->assertEquals($expectedDriverPostData, $driverPostData);
    }

    private function getTestIssueCountryConverter()
    {
        $countries = [
            'rus' => 'Россия'
        ];

        return new IssueCountryConverter($countries);
    }

    private function getTestDefaultValues()
    {
        return DriverInterface::DEFAULT_VALUES;
    }

    private function getExpectedDriverPostData()
    {
        $expectedDriverData = DriverInterface::EXPECTED_DATA;
        $expectedDriverData['driver_profile']['hire_date'] = date('Y-m-d');

        return $expectedDriverData;
    }
}
