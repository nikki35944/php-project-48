<?php

namespace Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function addDataProvider()
    {
        $firstJsonFile = __DIR__ . "/fixtures/file1.json";
        $secondJsonFile = __DIR__ . "/fixtures/file2.json";
        $firstYmlFile = __DIR__ . "/fixtures/file1.yml";
        $secondYmlFile = __DIR__ . "/fixtures/file2.yml";
        return [
            [$firstJsonFile, $secondJsonFile],
            [$firstYmlFile, $secondYmlFile],
        ];
    }

    /**
    * @dataProvider addDataProvider
    */

    public function testMainGendiff($firstFile, $secondFile): void
    {
        $result = file_get_contents("tests/fixtures/stylishResult.txt");
        $this->assertEquals($result, genDiff($firstFile, $secondFile));
    }

    /**
    * @dataProvider addDataProvider
    */

    public function testPlainFormat($firstFile, $secondFile): void
    {
        $result = file_get_contents("tests/fixtures/plainResult.txt");
        $this->assertEquals($result, genDiff($firstFile, $secondFile, "plain"));
    }

    /**
    * @dataProvider addDataProvider
    */

    public function testJsonFormat($firstFile, $secondFile): void
    {
        $result = file_get_contents("tests/fixtures/jsonResult.txt");
        $this->assertEquals($result, genDiff($firstFile, $secondFile, "json"));
    }

    /**
    * @dataProvider addDataProvider
    */

    public function testStylishFormat($firstFile, $secondFile): void
    {
        $result = file_get_contents("tests/fixtures/stylishResult.txt");
        $this->assertEquals($result, genDiff($firstFile, $secondFile, "stylish"));
    }
}
