<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver as ToCreateDriverConverter;
use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter\Fixture;

class ToCreateDriverTest extends Base
{
    public function testConvert()
    {
        $testData = $this->getTestData();
        $converter = new ToCreateDriverConverter();
        $driverPostData = $converter->convert($testData);

        $this->assertIsArray($driverPostData);
        $this->assertArrayHasKey('accounts', $driverPostData);
        $this->assertIsArray($driverPostData['accounts']);

        $this->assertArrayHasKey('driver_profile', $driverPostData);
        $this->assertIsArray($driverPostData['driver_profile']);

        $expectedDriverPostData = $this->getExpectedDriverPostData();
        $this->assertEquals($expectedDriverPostData, $driverPostData);
    }

    private function getExpectedDriverPostData()
    {
        $expectedDriverData = Fixture::EXPECTED_CREATE_DRIVER_DATA;
        $expectedDriverData['driver_profile']['hire_date'] = date('Y-m-d');

        return $expectedDriverData;
    }
}
