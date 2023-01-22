<?php

namespace Differ\Formatters\Stylish;

function render($astTree)
{
    return stylish($astTree);
}

function stylish(array $astTree, int $depth = 0)
{
    $indent = buildIndent($depth, 4);

    $result = array_map(function ($node) use ($depth, $indent) {
        $depth += 1;
        switch ($node['type']) {
            case 'nested':
                return $indent . "    " . $node['key'] . ": " . stylish($node['children'], $depth) . PHP_EOL;
            case 'added':
                $valueAdd = stringify($node['value'], $depth);
                return $indent . "  + " . $node['key'] . ": " . $valueAdd . PHP_EOL;
            case 'removed':
                $valueRemoved = stringify($node['value'], $depth);
                return $indent . "  - " . $node['key'] . ": " . $valueRemoved . PHP_EOL;
            case 'changed':
                $valueRemoved = stringify($node['value']['valueRemoved'], $depth);
                $valueAdd = stringify($node['value']['valueAdd'], $depth);
                $nodeRemoved = $node['key'] . ": " . $valueRemoved . PHP_EOL;
                $nodeAdd = $node['key'] . ": " . $valueAdd;
                return $indent . "  - " . $nodeRemoved . $indent . "  + " . $nodeAdd . PHP_EOL;
            case 'unchanged':
                $valueUnchanged = stringify($node['value'], $depth);
                return $indent . "    " . $node['key'] . ": " . $valueUnchanged . PHP_EOL;
            default:
                throw new \Exception("Unknown type: {$node['type']}");
        }
    }, $astTree);
    return '{' . PHP_EOL . implode("", $result) . $indent . '}';
}

function buildIndent($depth, $quantityOfGaps)
{
    $spaceMultiplier = $depth * $quantityOfGaps;
    return str_repeat(" ", $spaceMultiplier);
}

function stringify($value, $depth)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    if (!is_object($value)) {
        return (string) $value;
    }
    $indent = buildIndent($depth, 4);
    $stringOfArray = array_map(function ($key, $item) use ($depth, $indent) {
        $depth += 1;
        $typeOfValueOfNode = (is_object($item)) ? stringify($item, $depth) : $item;
        return $indent . "    " . "{$key}: " . $typeOfValueOfNode . PHP_EOL;
    }, array_keys(get_object_vars($value)), get_object_vars($value));
    return '{' . PHP_EOL . implode("", $stringOfArray) . $indent . '}';
}
