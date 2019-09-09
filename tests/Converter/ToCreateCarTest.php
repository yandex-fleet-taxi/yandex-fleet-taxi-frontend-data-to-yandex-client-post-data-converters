<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateCar as ToCreateCarConverter;

class ToCreateCarTest extends Base
{
    public function testConvert()
    {
        $testData = $this->getTestData();
        $testRow = $this->getTestRow();
        $converter = new ToCreateCarConverter();
        $parkId = '8d40b7c41af544afa0499b9d0bdf2430';
        $carPostData = $converter->convert($testData, $testRow, $parkId);
        //$expectedDriverPostData = $this->getExpectedDriverPostData();

        $this->assertIsArray($carPostData);
        //$this->assertEquals($expectedDriverPostData, $driverPostData);
    }
}
