<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverInterface as FrontDriverInterface;
use Likemusic\YandexFleetTaxi\FrontendData\Contracts\DriverLicenseInterface as FrontDriverLicenseInterface;
use Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter\ToCreateDriver\DriverLicenceIssueCountry as IssueCountryConverter;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfile\DriverLicenceInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriver\DriverProfileInterface;
use Likemusic\YandexFleetTaxiClient\Contracts\PostDataKey\CreateDriverInterface;

class ToCreateDriver extends Base
{
    /**
     * @var IssueCountryConverter
     */
    private $issueCountryConverter;

    public function __construct(IssueCountryConverter $issueCountryConverter)
    {
        $this->issueCountryConverter = $issueCountryConverter;
    }

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

    private function getMappedValuesDriver(array $data)
    {
        $mapping = [
            DriverProfileInterface::ADDRESS => FrontDriverInterface::WORK_CITY,
            DriverProfileInterface::FIRST_NAME => FrontDriverInterface::FIRST_NAME,
            DriverProfileInterface::LAST_NAME => FrontDriverInterface::LAST_NAME,
            DriverProfileInterface::MIDDLE_NAME => FrontDriverInterface::MIDDLE_NAME,
        ];

        return $this->getValuesByRowNamesMapping($data, $mapping);
    }

    private function getCalculatedValues($data)
    {
        $calculatedValues = [
            CreateDriverInterface::DRIVER_PROFILE => $this->getCalculatedValuesDriver($data),
        ];

        return $calculatedValues;
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

        if ($comment = $this->getDriverComment($data)) {
            $ret[DriverProfileInterface::COMMENT] = $comment;
        }

        $ret[DriverProfileInterface::HIRE_DATE] = $this->getHireDate();

        return $ret;
    }

    private function getDriverLicencePostData($data)
    {
        $ret = [];

        if ($birthData = $this->getDriverBirthDate($data)) {
            $ret[DriverLicenceInterface::BIRTH_DATE] = $birthData;
        }

        if ($expirationDate = $this->getExpirationDate($data)) {
            $ret[DriverLicenceInterface::EXPIRATION_DATE] = $expirationDate;
        }

        if ($issueDate = $this->getIssueDate($data)) {
            $ret[DriverLicenceInterface::ISSUE_DATE] = $issueDate;
        }

        if ($issueCountry = $this->getIssueCountry($data)) {
            $ret[DriverLicenceInterface::COUNTRY] = $issueCountry;
        }

        if ($number = $this->getDriverLicenceNumber($data)) {
            $ret[DriverLicenceInterface::NUMBER] = $number;
        }

        return $ret;
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

    private function getClientDateByTildaDate(string $sheetDate): string
    {
        $chunks = explode('.', $sheetDate);

        $chunks = array_reverse($chunks);

        return implode('-', $chunks);
    }

    private function getExpirationDate(array $data): ?string
    {
        return $this->getClientDataByKey($data, FrontDriverLicenseInterface::EXPIRATION_DATE);
    }

    private function getIssueDate(array $data): ?string
    {
        return $this->getClientDataByKey($data, FrontDriverLicenseInterface::ISSUE_DATE);
    }

    private function getIssueCountry(array $data)
    {
        if (!isset($data[FrontDriverLicenseInterface::ISSUE_COUNTRY])) {
            return null;
        }

        $frontIssueCountry = $data[FrontDriverLicenseInterface::ISSUE_COUNTRY];

        return $this->getYandexDriverLicenceCountryByFrontValue($frontIssueCountry);
    }

    private function getYandexDriverLicenceCountryByFrontValue(string $frontIssueCountry): string
    {
        return $this->issueCountryConverter->convert($frontIssueCountry);
    }

    public function getDriverLicenceNumber($data): ?string
    {
        $licenseNumber = isset($data[FrontDriverLicenseInterface::NUMBER])
            ? $data[FrontDriverLicenseInterface::NUMBER]
            : '';

        $licenseNumber = $this->removeSpaces($licenseNumber);

        return $licenseNumber ? $licenseNumber : null;
    }

    private function removeSpaces($str)
    {
        return preg_replace('/\s+/', '', $str);
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

    private function getDriverComment(array $data)
    {
        if (!$whatsAppPhone = $this->getWhatsAppPhone($data)) {
            return null;
        }

        $sanitizedPhone = $this->sanitizePhone($whatsAppPhone);

        return "[whatsapp:{$sanitizedPhone}]";
    }

    private function getWhatsAppPhone(array $data)
    {
        if (!isset($data[DriverInterface::WHATSAPP_PHONE])) {
            return null;
        }

        return $data[DriverInterface::WHATSAPP_PHONE];
    }

    private function getHireDate()
    {
        return date('Y-m-d');
    }
}
