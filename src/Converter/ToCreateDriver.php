<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverInterface as FrontDriverInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverLicense\IssueCountryInterface as FrontDriverLicenseIssueCountryInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverLicenseInterface as FrontDriverLicenseInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfile\DriverLicenceInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfileInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriverInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\References\DriverLicenseIssueCountryCodeInterface;

class ToCreateDriver extends Base
{
    public function convert(array $data, $defaultValues): array
    {
        $mappedValues = $this->getMappedValues($data);
        $calculatedValues = $this->getCalculatedValues($data);

        return array_merge_recursive($defaultValues, $mappedValues, $calculatedValues);
    }

    private function getMappedValues($data)
    {
        return [
            CreateDriverInterface::DRIVER_PROFILE => $this->getMappedValuesDriver($data),
        ];
    }

    private function getCalculatedValues($data)
    {
        return [
            CreateDriverInterface::DRIVER_PROFILE => $this->getCalculatedValuesDriver($data),
        ];
    }

    private function getDriverPostDataDriverProfile(array $data)
    {
        $mappedValues = $this->getMappedValuesDriver($data);
        $calculatedValues = $this->getCalculatedValuesDriver($data);

        return array_replace_recursive($mappedValues, $calculatedValues);
    }

    private function getMappedValuesDriver(array $data)
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

    private function getCalculatedValuesDriver(array $data): array
    {
        $ret = [];

        if ($driverLicense = $this->getDriverLicencePostData($data)) {
            $ret[DriverProfileInterface::DRIVER_LICENSE] = $driverLicense;
        }

        if ($phones = $this->getDriverPhones($data)) {
            $ret[DriverProfileInterface::PHONES] = $phones;
        }

        $ret[DriverProfileInterface::HIRE_DATE] = $this->getHireDate();

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

        if ($birthData = $this->getDriverBirthDate($data)) {
            $ret[DriverLicenceInterface::BIRTH_DATE] = $birthData;
        }

        if ($country = $this->getDriverLicenceIssueCountry($data)) {
            $ret[DriverLicenceInterface::COUNTRY] = $country;
        }

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


    private function getDriverLicenceIssueCountry(array $data)
    {
        if (!isset($data[FrontDriverLicenseInterface::ISSUE_COUNTRY])) {
            return null;
        }

        $frontCountry = $data[FrontDriverLicenseInterface::ISSUE_COUNTRY];

        return $this->getYandexClientCountryCodeByFrontCountry($frontCountry);
    }

    private function getYandexClientCountryCodeByFrontCountry($frontCountry)
    {
        $mapping = [
            FrontDriverLicenseIssueCountryInterface::RUSSIA => DriverLicenseIssueCountryCodeInterface::RUSSIA,
            FrontDriverLicenseIssueCountryInterface::BELARUS => DriverLicenseIssueCountryCodeInterface::BELARUS,
            FrontDriverLicenseIssueCountryInterface::KAZAKHSTAN => DriverLicenseIssueCountryCodeInterface::KAZAKHSTAN,
            FrontDriverLicenseIssueCountryInterface::KYRGYZSTAN => DriverLicenseIssueCountryCodeInterface::KYRGYZSTAN,
            //todo
//            'Абхазия',
//            'Южная Осетия'
        //todo: Что со всеми остальными странами?
        ];

        if (!array_key_exists($frontCountry, $mapping)) {
            throw new \InvalidArgumentException('Unknown frontend county name: ' . $frontCountry);
        }

        return $mapping[$frontCountry];
    }

    private function getDriverBirthDate(array $data): ?string
    {
        return $this->getClientDataByKey($data, FrontDriverInterface::BIRTH_DATE);
    }

    private function getClientDataByKey(array $data, string $key)
    {
        if (!isset($data[$key])) {
            return null;
        }

        $sheetValue = $data[$key];

        return $this->getClientDateByTildaDate($sheetValue);
    }

    private function getHireDate()
    {
        return date('Y-m-d');
    }

    private function getExpirationDate(array $data): ?string
    {
        return $this->getClientDataByKey($data, FrontDriverLicenseInterface::EXPIRATION_DATE);
    }

    private function getClientDateByTildaDate(string $sheetDate):string
    {
        $chunks = explode('.', $sheetDate);

        $chunks = array_reverse($chunks);

        return implode('-', $chunks);
    }

    private function getIssueDate(array $data): ?string
    {
        return $this->getClientDataByKey($data, FrontDriverLicenseInterface::ISSUE_DATE);
    }

    public function getDriverLicenceNumber($data): ?string
    {
        //todo: использовать серию из отдельного поля?

        //$series = $data[FrontDriverLicenseInterface::SERIES];
        if (!isset($data[FrontDriverLicenseInterface::NUMBER])) {
            return null;
        }

        $number = $data[FrontDriverLicenseInterface::NUMBER];

        return "{$number}";
    }

    public function getDriverPhones($data): ?array
    {
        if (!$sanitizedPhone = $this->getSanitizedPhoneByKey($data, FrontDriverInterface::WORK_PHONE)) {
            return null;
        };

//TODO: Нужно ли добавлять второй номер к номерам яндекса? Через админку на данный момент можно добавить только один,
//но api позволяет добавить несколько.
        return [
            $sanitizedPhone,
        ];
    }

    private function getSanitizedPhoneByKey($data, $key)
    {
        if (!isset($data[$key])) {
            return null;
        }

        $rawPhone = $data[$key];

        return $this->sanitizePhone($rawPhone);
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
