<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\CreateDriver\DriverProfileInterface as DriverProfileColumnNameInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\AccountsInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfile\DriverLicenceInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfileInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriverInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\CreateDriver\DriverProfile\DriverLicenceInterface as DriverLicenceColumnInterface;

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
//            DriverProfileInterface::FIRST_NAME => null,
            DriverProfileInterface::HIRE_DATE => '2019-09-01',
//            DriverProfileInterface::LAST_NAME => null,
//            DriverProfileInterface::MIDDLE_NAME => null,
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
            DriverProfileInterface::FIRST_NAME => DriverProfileColumnNameInterface::FIRST_NAME,
//            DriverProfileInterface::HIRE_DATE => null,
            DriverProfileInterface::LAST_NAME => DriverProfileColumnNameInterface::LAST_NAME,
            DriverProfileInterface::MIDDLE_NAME => DriverProfileColumnNameInterface::MIDDLE_NAME,
//            DriverProfileInterface::PHONES => $this->getDriverPostDataDriverProfilePhones($row),
//            DriverProfileInterface::PROVIDERS => $this->getDriverPostDataDriverProfileProviders($row),
//            DriverProfileInterface::WORK_RULE_ID => null,
//            DriverProfileInterface::WORK_STATUS => null,

        ];

        return $this->getValuesByRowNamesMapping($data, $mapping);
    }

    private function getCalculatedValues(array $data): array
    {
        return [
//            DriverProfileInterface::ADDRESS => null,
//            DriverProfileInterface::CAR_ID => null,
//            DriverProfileInterface::CHECK_MESSAGE => null,
//            DriverProfileInterface::COMMENT => null,
//            DriverProfileInterface::DEAF => null,
            DriverProfileInterface::DRIVER_LICENSE => $this->getDriverLicencePostData($data),
//            DriverProfileInterface::EMAIL => null,
//            DriverProfileInterface::FIRE_DATE => null,
//            DriverProfileInterface::FIRST_NAME => null,
//            DriverProfileInterface::HIRE_DATE => null,
//            DriverProfileInterface::LAST_NAME => null,
//            DriverProfileInterface::MIDDLE_NAME => null,
            DriverProfileInterface::PHONES => $this->getDriverPostDataDriverProfilePhones($data),
//            DriverProfileInterface::PROVIDERS => $this->getDriverPostDataDriverProfileProviders($row),
//            DriverProfileInterface::WORK_RULE_ID => null,
//            DriverProfileInterface::WORK_STATUS => null,
        ];
    }

    private function getDriverPostDataDriverProfilePhones($data)
    {
        $rawPhone = $data[DriverProfileColumnNameInterface::PHONE];
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

    private function getDriverLicencePostData($data)
    {
        return [
            DriverLicenceInterface::BIRTH_DATE => null,
            DriverLicenceInterface::COUNTRY => 'rus',//$this->getDriverLicenceCountry($rowNames, $row),
            DriverLicenceInterface::EXPIRATION_DATE => $this->getExpirationDate($data),
            DriverLicenceInterface::ISSUE_DATE => $this->getIssueDate($data),
            DriverLicenceInterface::NUMBER => $this->getDriverLicenceNumber($data),
        ];
    }

    private function getExpirationDate(array $data): string
    {
        $sheetValue = $data[DriverLicenceColumnInterface::EXPIRATION_DATE];

        return $this->getClientDateByTildaDate($sheetValue);
    }

    private function getIssueDate(array $data): string
    {
        $sheetValue = $data[DriverLicenceColumnInterface::ISSUE_DATE];

        return $this->getClientDateByTildaDate($sheetValue);
    }

    private function getClientDateByTildaDate(string $sheetDate):string
    {
        $chunks = explode('.', $sheetDate);

        $chunks = array_reverse($chunks);

        return implode('-', $chunks);
    }

    private function getDriverLicenceCountry($rowNames, $row)
    {
        //todo
        $countryRu = $this->getValueByRowName($rowNames, $row, DriverLicenceColumnInterface::COUNTRY);

        return $this->getDriverLicenceCountryCodeByCountryRussianName($countryRu);
    }

    private function getDriverLicenceNumber($data)
    {
        $series = $data[DriverLicenceColumnInterface::SERIES];
        $number = $data[DriverLicenceColumnInterface::NUMBER];

        return "{$number}";
    }

    private function getDriverPostDataDriverProfileProviders($row)
    {
        return [
            'yandex',//todo
        ];
    }
}
