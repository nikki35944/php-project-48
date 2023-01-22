<?php

namespace Differ\Formatters;

function format($astTree, $formatName)
{
    switch ($formatName) {
        case 'stylish':
            return Stylish\render($astTree);
        case 'plain':
            return Plain\render($astTree);
        case 'json':
            return Json\render($astTree);
        default:
            throw new \Exception("Unknown formatter: $formatName");
    }
}
