<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter\Fixture\FrontendDataInterface;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    protected function getTestData()
    {
        return FrontendDataInterface::FRONT_DATA;
    }
}
