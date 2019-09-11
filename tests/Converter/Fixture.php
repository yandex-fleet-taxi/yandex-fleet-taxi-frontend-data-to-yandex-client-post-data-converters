<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

interface Fixture
{
    const FRONT_DATA = [
        'driver_work_phone' => '+7 (753) 330-12-95',
        'driver_whatsapp_phone' => '+7 (753) 330-12-95',
        'driver_work_city' => 'Borisov',
        'driver_work_timezone' => '+0 Москва',
        'licence_issue_country' => 'Россия',
        'driver_last_name' => 'Иващенко',
        'driver_first_name' => 'Валерий',
        'driver_middle_name' => 'Игоревич',
        'licence_series' => 'OA',
        'licence_number' => '32132132',
        'licence_issue_date' => '01.09.2019',
        'licence_expiration_date' => '20.09.2019',
        'driver_birth_date' => '01.02.1985',
        'car_number' => 'A001AA78',
        'car_brand' => 'Alfa Romeo',
        'car_model'=> '105/115',
        'car_issue_year' => '2008',
        'car_color' => 'Серый',
        'car_vin' => '1C3EL46U91N594161',
        'car_registration' => 'AA321354654654',
        'car_branding' => 'Lightbox; Наклейки',
        'requestid' => '1589609:362937272',
        'sended' => '2019-09-02 18:10:31',
        'referer' => 'http://project1589609.tilda.ws/',
    ];

    const EXPECTED_CREATE_DRIVER_DATA = [
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
                        'birth_date' => '1985-02-01',
                    ],
                'first_name' => 'Валерий',
                'last_name' => 'Иващенко',
                'middle_name' => 'Игоревич',
                'phones' =>
                    [
                        '+77533301295',
//                            '+7 (753) 330-12-95',
                    ],
                'providers' =>
                    [
                        0 => 'yandex',
                    ],
                'work_rule_id' => 'a6cb3fbe61a54ba28f8f8b5e35b286db',
                'balance_deny_onlycard' => false,
//                    'hire_date' => '2019-09-01',
//                    'deaf' => NULL,
//                    'email' => NULL,
//                    'address' => NULL,
//                    'comment' => NULL,
//                    'check_message' => NULL,
//                    'car_id' => NULL,
//                    'fire_date' => NULL,
//                    'bank_accounts' => [],
//                    'emergency_person_contacts' => [],
//                    'identifications' => [],
//                    'primary_state_registration_number' => null,
//                    'tax_identification_number' => null,
            ],
    ];
}
