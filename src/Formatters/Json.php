<?php

namespace Differ\Formatters\Json;

function render(array $astTree)
{
    return json_encode($astTree);
}
