<?php

namespace Differ\Formatters\Json;

function jsonFormat(array $tree)
{
    return json_encode($tree);
}
