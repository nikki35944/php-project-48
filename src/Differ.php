<?php

namespace Differ\Differ;

use function Differ\Formatters\format;
use function Differ\Parsers\parseFile;
use function Functional\sort;

function genDiff(string $firstPath, string $secondPath, string $format = 'stylish')
{
    $firstFile = parseFile($firstPath);
    $secondFile = parseFile($secondPath);
    $diffTree = buildDiff($firstFile, $secondFile);

    return format($diffTree, $format);
}

function buildDiff(array $firstFile, array $secondFile): array
{
    $firstFileKeys = array_keys($firstFile);
    $secondFileKeys = array_keys($secondFile);
    $allKeys = array_unique(array_merge($firstFileKeys, $secondFileKeys));
    $sortedKeys = sort($allKeys, fn ($a, $b) => strcmp($a, $b));

    return $tree = array_map(function ($key) use ($firstFile, $secondFile) {
        if (!array_key_exists($key, $secondFile)) {
            return ['key' => $key, 'value' => $firstFile[$key], 'type' => 'removed'];
        } elseif (!array_key_exists($key, $firstFile)) {
            return ['key' => $key, 'value' => $secondFile[$key], 'type' => 'added'];
        } elseif ($firstFile[$key] === $secondFile[$key]) {
            return ['key' => $key, 'value' => $firstFile[$key], 'type' => 'unchanged'];
        } elseif (is_array($firstFile[$key]) && is_array($secondFile[$key])) {
            return ['key' => $key, 'type' => 'array', 'children' => buildDiff($firstFile[$key], $secondFile[$key])];
        } else {
            return ['key' => $key, 'firstValue' => $firstFile[$key],
                                   'secondValue' => $secondFile[$key], 'type' => 'changed'];
        }
    }, $sortedKeys);
}
