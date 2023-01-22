<?php

namespace Differ\Differ;

use function Differ\Parser\parser;
use function Differ\BuildAstTree\buildAstTree;
use function Differ\Formatters\format;
use function Differ\Getdata\getData;

function genDiff(string $pathToFile1, string $pathToFile2, $formatName = 'stylish'): string
{
    [$dataParsing1, $extensionFile1] = getData($pathToFile1);
    [$dataParsing2, $extensionFile2] = getData($pathToFile2);

    $data1 = parser($dataParsing1, $extensionFile1);
    $data2 = parser($dataParsing2, $extensionFile2);

    $astTree = buildAstTree($data1, $data2);

    $resultOfDiff = format($astTree, $formatName);

    return $resultOfDiff;
}
