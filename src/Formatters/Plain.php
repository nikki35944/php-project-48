<?php

namespace Differ\Formatters\Plain;

function format(array $tree, string $path = ''): array
{
    $result = array_map(function ($node) use ($path) {
        $property = "{$path}{$node['key']}";
        switch ($node['type']) {
            case 'added':
                $value = realValue($node['value']);
                return "Property '{$property}' was added with value: {$value}";
            case 'removed':
                return "Property '{$property}' was removed";
            case 'unchanged':
                return '';
            case 'changed':
                $firstValue = realValue($node['firstValue']);
                $secondValue = realValue($node['secondValue']);
                return "Property '{$property}' was updated. From {$firstValue} to {$secondValue}";
            case 'array':
                $path2 = "{$path}{$node['key']}.";
                return implode("\n", format($node['children'], $path2));
            default:
                throw new \Exception("error, default case");
        }
    }, $tree);
    return array_filter($result);
}

function plainFormat(array $data): string
{
    $lines = format($data);
    return implode("\n", $lines);
}

function realValue(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_null($value)) {
        return 'null';
    } elseif (is_array($value)) {
        return '[complex value]';
    }
    return var_export($value, true);
}
