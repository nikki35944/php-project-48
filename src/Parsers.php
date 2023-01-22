<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $pathToFile)
{
    $fileFormat = pathinfo($pathToFile, PATHINFO_EXTENSION);
    if (file_get_contents($pathToFile) === false) {
        throw new \Exception("Error, there is no file");
    }
    if ($fileFormat === "json") {
        return json_decode(file_get_contents($pathToFile), true);
    } elseif ($fileFormat === "yaml" || $fileFormat === "yml") {
        return Yaml::parseFile($pathToFile);
    } else {
        throw new \Exception("Error, unknown extension");
    }
}
