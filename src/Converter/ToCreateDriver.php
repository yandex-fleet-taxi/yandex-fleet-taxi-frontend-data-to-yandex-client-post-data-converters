<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverInterface as FrontDriverInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverLicenseInterface as FrontDriverLicenseInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\AccountsInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfile\DriverLicenceInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfileInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriverInterface;

class ToCreateDriver extends Base
{
    const DEFAULT_BALANCE_LIMIT = 5;

    public function convert(array $data): array
    {
        return [
            CreateDriverInterface::ACCOUNTS => $this->getDriverPostDataAccounts(),
            CreateDriverInterface::DRIVER_PROFILE => $this->getDriverPostDataDriverProfile($data),
        ];
    }

    private function getDriverPostDataAccounts()
    {
        $defaultBalanceLimit = self::DEFAULT_BALANCE_LIMIT;

        return [
            AccountsInterface::BALANCE_LIMIT => "{$defaultBalanceLimit}",
        ];
    }

    private function getDriverPostDataDriverProfile(array $data)
    {
        $defaultValues = $this->getDefaultValues();
        $mappedValues = $this->getMappedValues($data);
        $calculatedValues = $this->getCalculatedValues($data);

        return array_replace_recursive($defaultValues, $mappedValues, $calculatedValues);
    }

    private function getDefaultValues()
    {
        return [
            DriverProfileInterface::ADDRESS => null,
            DriverProfileInterface::CAR_ID => null,
            DriverProfileInterface::CHECK_MESSAGE => null,
            DriverProfileInterface::COMMENT => null,
            DriverProfileInterface::DEAF => null,
            DriverProfileInterface::DRIVER_LICENSE => null,
            DriverProfileInterface::EMAIL => null,
            DriverProfileInterface::FIRE_DATE => null,
            DriverProfileInterface::HIRE_DATE => '2019-09-01',
//            DriverProfileInterface::PHONES => null,
            DriverProfileInterface::PROVIDERS => ['yandex'],
            DriverProfileInterface::WORK_RULE_ID => 'a6cb3fbe61a54ba28f8f8b5e35b286db',//todo
//            DriverProfileInterface::WORK_STATUS => WorkStatusIdInterface::WORKING,

            DriverProfileInterface::BANK_ACCOUNTS => [],
            DriverProfileInterface::EMERGENCY_PERSON_CONTACTS => [],
            DriverProfileInterface::IDENTIFICATIONS => [],
            DriverProfileInterface::PRIMARY_STATE_REGISTRATION_NUMBER => null,
            DriverProfileInterface::TAX_IDENTIFICATION_NUMBER => null,
        ];
    }

    private function getMappedValues(array $data)
    {
        $mapping = [
//            DriverProfileInterface::ADDRESS => null,
//            DriverProfileInterface::CAR_ID => null,
//            DriverProfileInterface::CHECK_MESSAGE => null,
//            DriverProfileInterface::COMMENT => null,
//            DriverProfileInterface::DEAF => null,
//            DriverProfileInterface::DRIVER_LICENSE => $this->getDriverPostDataDriverProfileDriverLicence($row),
//            DriverProfileInterface::EMAIL => null,
//            DriverProfileInterface::FIRE_DATE => null,
            DriverProfileInterface::FIRST_NAME => FrontDriverInterface::FIRST_NAME,
//            DriverProfileInterface::HIRE_DATE => null,
            DriverProfileInterface::LAST_NAME => FrontDriverInterface::LAST_NAME,
            DriverProfileInterface::MIDDLE_NAME => FrontDriverInterface::MIDDLE_NAME,
//            DriverProfileInterface::PHONES => $this->getDriverPostDataDriverProfilePhones($row),
//            DriverProfileInterface::PROVIDERS => $this->getDriverPostDataDriverProfileProviders($row),
//            DriverProfileInterface::WORK_RULE_ID => null,
//            DriverProfileInterface::WORK_STATUS => null,

        ];

        return $this->getValuesByRowNamesMapping($data, $mapping);
    }

    private function getCalculatedValues(array $data): array
    {
        $ret = [];

        if ($driverLicense = $this->getDriverLicencePostData($data)) {
            $ret[DriverProfileInterface::DRIVER_LICENSE] = $driverLicense;
        }

        if ($phones = $this->getDriverPostDataDriverProfilePhones($data)) {
            $ret[DriverProfileInterface::PHONES] = $phones;
        }

        return $ret;

//        return [
//            DriverProfileInterface::ADDRESS => null,
//            DriverProfileInterface::CAR_ID => null,
//            DriverProfileInterface::CHECK_MESSAGE => null,
//            DriverProfileInterface::COMMENT => null,
//            DriverProfileInterface::DEAF => null,
//            DriverProfileInterface::DRIVER_LICENSE => $this->getDriverLicencePostData($data),
//            DriverProfileInterface::EMAIL => null,
//            DriverProfileInterface::FIRE_DATE => null,
//            DriverProfileInterface::FIRST_NAME => null,
//            DriverProfileInterface::HIRE_DATE => null,
//            DriverProfileInterface::LAST_NAME => null,
//            DriverProfileInterface::MIDDLE_NAME => null,
//            DriverProfileInterface::PHONES => $this->getDriverPostDataDriverProfilePhones($data),
//            DriverProfileInterface::PROVIDERS => $this->getDriverPostDataDriverProfileProviders($row),
//            DriverProfileInterface::WORK_RULE_ID => null,
//            DriverProfileInterface::WORK_STATUS => null,
//        ];
    }

    private function getDriverLicencePostData($data)
    {
        $ret = [];

//        if ($birthData = $this->getDriverBirdthDate()) {
//            $ret[DriverLicenceInterface::BIRTH_DATE] = $birthData;
//        }

//        if ($country = $this->getDriverLicenceCountry()) {
//            $ret[DriverLicenceInterface::COUNTRY] = $country;
//        }

        if ($expirationDate = $this->getExpirationDate($data)) {
            $ret[DriverLicenceInterface::EXPIRATION_DATE ] = $expirationDate;
        }

        if ($issueDate = $this->getIssueDate($data)) {
            $ret[DriverLicenceInterface::ISSUE_DATE] = $issueDate;
        }

        if ($number = $this->getDriverLicenceNumber($data)) {
            $ret[DriverLicenceInterface::NUMBER] = $number;
        }

        return $ret;

//        return [
//            DriverLicenceInterface::BIRTH_DATE => null,
//            DriverLicenceInterface::COUNTRY => 'rus',//$this->getDriverLicenceCountry($rowNames, $row),
//            DriverLicenceInterface::EXPIRATION_DATE => $this->getExpirationDate($data),
//            DriverLicenceInterface::ISSUE_DATE => $this->getIssueDate($data),
//            DriverLicenceInterface::NUMBER => $this->getDriverLicenceNumber($data),
//        ];
    }

    private function getExpirationDate(array $data): string
    {
        $sheetValue = $data[FrontDriverLicenseInterface::EXPIRATION_DATE];

        return $this->getClientDateByTildaDate($sheetValue);
    }

    private function getClientDateByTildaDate(string $sheetDate):string
    {
        $chunks = explode('.', $sheetDate);

        $chunks = array_reverse($chunks);

        return implode('-', $chunks);
    }

    private function getIssueDate(array $data): string
    {
        $sheetValue = $data[FrontDriverLicenseInterface::ISSUE_DATE];

        return $this->getClientDateByTildaDate($sheetValue);
    }

    private function getDriverLicenceNumber($data)
    {
        $series = $data[FrontDriverLicenseInterface::SERIES];
        $number = $data[FrontDriverLicenseInterface::NUMBER];

        return "{$number}";
    }

    private function getDriverPostDataDriverProfilePhones($data)
    {
        $rawPhone = $data[FrontDriverInterface::WORK_PHONE];
        $sanitizedPhone = $this->sanitizePhone($rawPhone);

        return [
            $sanitizedPhone,
//TODO: Нужно ли добавлять второй номер к номерам яндекса? Через админку на данный момент можно добавить только один,
//но api позволяет добавить несколько.
        ];
    }

    private function sanitizePhone(string $rawPhone)
    {
        $phone = preg_replace('/[^0-9]/', '', $rawPhone);

        return "+{$phone}";
    }

    private function getDriverLicenceCountry($rowNames, $row)
    {
        //todo
        $countryRu = $this->getValueByRowName($rowNames, $row, FrontDriverLicenseInterface::ISSUE_COUNTRY);

        return $this->getDriverLicenceCountryCodeByCountryRussianName($countryRu);
    }

    private function getDriverPostDataDriverProfileProviders($row)
    {
        return [
            'yandex',//todo
        ];
    }
}
