<?php

namespace Likemusic\YandexFleetTaxi\FrontendData\ToYandexClientPostDataConverters\Converter;

class Base
{
    protected function getValuesByRowNamesMapping(array $data, array $mapping)
    {
        $ret = [];

        foreach ($mapping as $key => $columnName){
            if (!array_key_exists($columnName, $data)) {
                continue;
            }

            $ret[$key] = $data[$columnName];
        }

        return $ret;
    }

    protected function getValueByRowName(array $rowNames, array $row, string $columnName)
    {
        $index = array_search($columnName, $rowNames);

        return $row[$index];
    }
}
