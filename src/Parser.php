<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parser($data, $dataType)
{
    switch ($dataType) {
        case 'json':
            return json_decode($data);
        case 'yml':
        case 'yaml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new \Exception("Unknown data type: $dataType");
    }
}
