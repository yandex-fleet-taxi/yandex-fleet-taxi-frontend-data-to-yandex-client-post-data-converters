<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver as ToCreateDriverConverter;
use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter\Fixture\DriverInterface;

class ToCreateDriverTest extends Base
{
    public function testConvert()
    {
        $testData = $this->getTestData();
        $defaultValues = $this->getTestDefaultValues();
        $converter = new ToCreateDriverConverter();
        $driverPostData = $converter->convert($testData, $defaultValues);

        $expectedDriverPostData = $this->getExpectedDriverPostData();
        $this->assertEquals($expectedDriverPostData, $driverPostData);
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
