<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver as ToCreateDriverConverter;

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
        return [
            'accounts' =>
                [
                    'balance_limit' => '5',
                ],
            'driver_profile' =>
                [
                    'driver_license' =>
                        [
                            'country' => 'rus',
                            'number' => '32132132',
                            'expiration_date' => '2019-09-20',
                            'issue_date' => '2019-09-01',
                            'birth_date' => NULL,
                        ],
                    'first_name' => 'Валерий',
                    'last_name' => 'Иващенко',
                    'middle_name' => 'Игроевич',
                    'phones' =>
                        [
                            '+7 (753) 330-12-95',
                            '+7 (753) 330-12-95',
                        ],
                    'work_status' => 'working',
                    'work_rule_id' => 'a6cb3fbe61a54ba28f8f8b5e35b286db',
                    'providers' =>
                        [
                            0 => 'yandex',
                        ],
                    'hire_date' => '2019-09-01',
                    'deaf' => NULL,
                    'email' => NULL,
                    'address' => NULL,
                    'comment' => NULL,
                    'check_message' => NULL,
                    'car_id' => NULL,
                    'fire_date' => NULL,
                ],
        ];
    }
}
