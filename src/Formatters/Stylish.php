<?php

namespace Differ\Formatters\Stylish;

function toString(array $arrayValue, int $depth): string
{
    $keys = array_keys($arrayValue);
    $inDepth = $depth + 1;
    $result = array_map(function ($key) use ($arrayValue, $inDepth): string {
        $val = realValue($arrayValue[$key], $inDepth);
        $spaceBefore = spaceBeforeString($inDepth);
        $result = "\n{$spaceBefore}{$key}: {$val}";
        return $result;
    }, $keys);
    return implode('', $result);
}

function realValue(mixed $value, int $depth): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_null($value)) {
        return 'null';
    } elseif (is_array($value)) {
        $result = toString($value, $depth);
        $spaceBefore = spaceBeforeString($depth);
        $bracketsResult = "{{$result}\n{$spaceBefore}}";
        return $bracketsResult;
    }

    return "{$value}";
}

function spaceBeforeString(int $depth): string
{
    return str_repeat('    ', $depth);
}

function getStylishFormat(array $tree, int $depth = 0): array
{
    $spaceBefore = spaceBeforeString($depth);
    $nextDepth = $depth + 1;

    return $list = array_map(function ($node) use ($spaceBefore, $nextDepth) {
        switch ($node['type']) {
            case 'added':
                $value = realValue($node['value'], $nextDepth);
                return "{$spaceBefore}  + {$node['key']}: {$value}";
            case 'removed':
                $value = realValue($node['value'], $nextDepth);
                return "{$spaceBefore}  - {$node['key']}: {$value}";
            case 'unchanged':
                $value = realValue($node['value'], $nextDepth);
                return "{$spaceBefore}    {$node['key']}: {$value}";
            case 'changed':
                $newValue = realValue($node['secondValue'], $nextDepth);
                $oldValue = realValue($node['firstValue'], $nextDepth);
                return "{$spaceBefore}  - {$node['key']}: {$oldValue}" .
                "\n{$spaceBefore}  + {$node['key']}: {$newValue}";
            case 'array':
                $stringNested = implode("\n", getStylishFormat($node['children'], $nextDepth));
                return "{$spaceBefore}    {$node['key']}: {\n{$stringNested}\n{$spaceBefore}    }";
            default:
                throw new \Exception("error, default case");
        }
    }, $tree);
}

function stylishFormat(array $formatedTree): string
{
    $implodeIndent = implode("\n", getStylishFormat($formatedTree));
    return "{\n{$implodeIndent}\n}";
}
