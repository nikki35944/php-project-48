<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\stylishFormat;
use function Differ\Formatters\Plain\plainFormat;
use function Differ\Formatters\Json\jsonFormat;

function format(array $tree, string $format)
{
    switch ($format) {
        case 'stylish':
            return stylishFormat($tree);
        case 'plain':
            return plainFormat($tree);
        case 'json':
            return jsonFormat($tree);
    }
}
