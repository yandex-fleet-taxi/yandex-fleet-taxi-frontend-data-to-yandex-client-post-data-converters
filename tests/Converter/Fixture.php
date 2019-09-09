<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Tests\Converter;

interface Fixture
{
    const DATA = [
        'Phone' => '+7 (753) 330-12-95',
        'Phone_2' => '+7 (753) 330-12-95',
        'gorod' => 'Borisov',
        'chasy-poias' => '+0 Москва',
        'VU-Strana' => 'Россия',
        'VU-Familia' => 'Иващенко',
        'VU-Imia' => 'Валерий',
        'VU-Otchestvo' => 'Игоревич',
        'prava-seria' => 'OA',
        'prava-nomer' => '32132132',
        'Date' => '01.09.2019',
        'Date_2' => '20.09.2019',
        'Date_3' => '01.02.1985',
        'frs-sts-gosnomer' => 'A001AA78',
        'frs-sts-avto-marka' => 'Alfa Romeo',
        'frs-sts-avto-model'=> '105/115',
        'frs-sts-avto-god' => '2008',
        'frs-sts-avto-cvet' => 'Серый',
        'frs-sts-avto-vin' => '1C3EL46U91N594161',
        'frs-sts-avto-vin_2' => 'AA321354654654',
        'Брендирование_Яндекс_Такси_если_есть' => 'Lightbox; Наклейки',
        'requestid' => '1589609:362937272',
        'sended' => '2019-09-02 18:10:31',
        'referer' => 'http://project1589609.tilda.ws/',
        'status',
        'status message'
    ];


    const ROW = [
        '+7 (753) 330-12-95',
        '+7 (753) 330-12-95',
        'Borisov',
        '+0 Москва',
        'Россия',
        'Иващенко',
        'Валерий',
        'Игоревич',
        'OA',
        '32132132',
        '28.07.2019',
        '07.11.2019',
        '01.02.1985',
        'A001AA78',
        'Alfa Romeo',
        '105/115',
        '2008',
        'Серый',
        '1C3EL46U91N594161',
        'AA321354654654',
        'Lightbox; Наклейки',
        '1589609:362937272',
        '2019-09-02 18:10:31',
        'http://project1589609.tilda.ws/',
    ];
}
