<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateCar as ToCreateCarConverter;

class ToCreateCarTest extends Base
{
    public function testConvert()
    {
        $testData = $this->getTestData();
        $converter = new ToCreateCarConverter();
        $parkId = '8d40b7c41af544afa0499b9d0bdf2430';
        $carPostData = $converter->convert($testData, $parkId);

        $this->assertIsArray($carPostData);
        $expectedCarPostData = $this->getExpectedCartPostData();
        $this->assertEquals($expectedCarPostData, $carPostData);
    }

    private function getExpectedCartPostData()
    {
        return [
            'amenities' =>
                [
                ],
            'body_number' => NULL,
            'booster_count' => 0,
            'callsign' => 'тест',
            'cargo_loaders' => 0,
            'carrier_permit_owner_id' => NULL,
            'carrying_capacity' => NULL,
            'categories' =>
                [
                ],
            'chairs' =>
                [
                ],
            'color' => 'Черный',
            'log_time' => 350,
            'permit' => NULL,
            'registration_cert' => '1111111',
            'rental' => NULL,
            'status' => 'working',
            'tariffs' =>
                [
                ],
            'transmission' => 'unknown',
            'year' => 2017,
            'brand' => 'Alfa Romeo',
            'model' => '105/115',
            'number' => 'A001AA78',
            'vin' => '1C3EL46U91N594161',
            'park_id' => '8d40b7c41af544afa0499b9d0bdf2430',
        ];
    }
}
