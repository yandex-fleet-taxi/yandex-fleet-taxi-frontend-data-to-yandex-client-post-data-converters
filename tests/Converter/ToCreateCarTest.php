<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateCar as ToCreateCarConverter;
use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter\Fixture\CarInterface;

class ToCreateCarTest extends Base
{
    public function testConvert()
    {
        $testData = $this->getTestData();
        $testDefaultValues = $this->getTestDefaultValues();

        $converter = new ToCreateCarConverter();
        $parkId = '8d40b7c41af544afa0499b9d0bdf2430';
        $carPostData = $converter->convert($testData, $testDefaultValues);

        $this->assertIsArray($carPostData);
        $expectedCarPostData = $this->getExpectedCartPostData();
        $this->assertEquals($expectedCarPostData, $carPostData);
    }

    /**
     * @return array
     */
    private function getTestDefaultValues()
    {
        return CarInterface::TEST_DEFAULT_CRATE_CAR_DATA;
    }

    private function getExpectedCartPostData()
    {
        return CarInterface::EXPECTED_POST_DATA;
    }
}
