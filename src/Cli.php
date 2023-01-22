<?php

namespace GenerateDiff\Cli;

function start()
{
    $doc = <<<DOC
Generate diff

Usage:
    gendiff (-h|--help)
    gendiff (-v|--version)
    
Options:
    -h --help                     Show this screen
    -v --version                  Show version
    --format <fmt>                Report format [default: stylish]

DOC;

    $args = \Docopt::handle($doc, array('version' => '1.0'));

    $fileName1 = $args['<firstFile>'];
    $fileName2 = $args['<secondFile>'];
    $format = $args['--format'];

    return ["fileName1" => $fileName1, "fileName2" => $fileName2, "format" => $format];
}
