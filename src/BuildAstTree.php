<?php

namespace Differ\BuildAstTree;

use function Funct\Collection\union;
use function Funct\Collection\sortBy;

function buildAstTree(object $data1, object $data2): array
{

    $keys = union(array_keys(get_object_vars($data1)), array_keys(get_object_vars($data2)));
    $sortedKeys = array_values(sortBy($keys, fn ($key) => $key));

    $astTree = array_map(function ($key) use ($data1, $data2) {

        if (!property_exists($data1, $key)) {
            return ['key' => $key, 'type' => 'added', 'value' => $data2->$key];
        }

        if (!property_exists($data2, $key)) {
            return ['key' => $key, 'type' => 'removed', 'value' => $data1->$key];
        }

        if (is_object($data1->$key) && is_object($data2->$key)) {
            return ['key' => $key, 'type' => 'nested', 'children' => buildAstTree($data1->$key, $data2->$key)];
        }
        if ($data1->$key !== $data2->$key) {
            $unchangedValues = ['valueRemoved' => $data1->$key, 'valueAdd' => $data2->$key];
            return ['key' => $key, 'type' => 'changed', 'value' => $unchangedValues];
        }
        return ['key' => $key, 'type' => 'unchanged', 'value' => $data1->$key];
    }, $sortedKeys);

    return $astTree;
}
