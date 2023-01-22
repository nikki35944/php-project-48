<?php

namespace Differ\Formatters\Plain;

function render($astTree)
{
    return plain($astTree);
}

function plain($astTree, $nestedProperty = '')
{

    $result = array_map(function ($node) use ($nestedProperty) {
        switch ($node['type']) {
            case 'nested':
                $nestedProperty .=  $node['key'] . ".";
                return plain($node['children'], $nestedProperty);
            case 'added':
                $valueAdd = stringify($node['value']);
                return "Property '" . $nestedProperty . $node['key'] . "' was added with value: " . $valueAdd . PHP_EOL;
            case 'removed':
                return "Property '" . $nestedProperty . $node['key'] . "' was removed" . PHP_EOL;
            case 'changed':
                $valueRemoved = stringify($node['value']['valueRemoved']);
                $valueAdd = stringify($node['value']['valueAdd']);
                $nodeRemoved = "From " . $valueRemoved;
                $nodeAdd = " to " . $valueAdd . PHP_EOL;
                return "Property '" . $nestedProperty . $node['key'] . "' was updated. " . $nodeRemoved . $nodeAdd;
            case 'unchanged':
                return '';
            default:
                throw new \Exception("Unknown type: {$node['type']}");
        }
    }, $astTree);

    return implode("", $result);
}

function stringify($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    if (is_object($value)) {
        return '[complex value]';
    }
    return (string) $value;
}
