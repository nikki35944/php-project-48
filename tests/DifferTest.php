<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class DifferTest extends TestCase
{
    public function testJsonFormatDefault(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.json', 'file4.json');

        $dataJson = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($this->getDataDiff('stylish'), $dataJson);
    }

    public function testYamlFormatDefault(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.yml', 'file4.yml');

        $dataYaml = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($this->getDataDiff('stylish'), $dataYaml);
    }

    public function testJsonFormatStylish(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.json', 'file4.json');

        $dataJson = genDiff($pathToFile1, $pathToFile2, 'stylish');

        $this->assertEquals($this->getDataDiff('stylish'), $dataJson);
    }

    public function testYamlFormatStylish(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.yml', 'file4.yml');

        $dataYaml = genDiff($pathToFile1, $pathToFile2, 'stylish');

        $this->assertEquals($this->getDataDiff('stylish'), $dataYaml);
    }

    public function testJsonFormatPlain(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.json', 'file4.json');

        $dataJson = genDiff($pathToFile1, $pathToFile2, 'plain');

        $this->assertEquals($this->getDataDiff('plain'), $dataJson);
    }

    public function testYamlFormatPlain(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.yml', 'file4.yml');

        $dataYaml = genDiff($pathToFile1, $pathToFile2, 'plain');

        $this->assertEquals($this->getDataDiff('plain'), $dataYaml);
    }

    public function testJsonFormatJson(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.json', 'file4.json');

        $dataJson = genDiff($pathToFile1, $pathToFile2, 'json');

        $this->assertEquals($this->getDataDiff('json'), $dataJson);
    }

    public function testYamlFormatJson(): void
    {
        [$pathToFile1, $pathToFile2] = $this->returnPathsFiles('file3.yml', 'file4.yml');

        $dataYaml = genDiff($pathToFile1, $pathToFile2, 'json');

        $this->assertEquals($this->getDataDiff('json'), $dataYaml);
    }

    public function returnPathsFiles(string $nameFile1, string $nameFile2)
    {
        $pathToFile1 = dirname(__DIR__, 1) . '/tests/fixtures/' . $nameFile1;
        $pathToFile2 = dirname(__DIR__, 1) . '/tests/fixtures/' . $nameFile2;

        return [$pathToFile1, $pathToFile2];
    }

    public function getDataDiff(string $typeDiff)
    {
        switch ($typeDiff) {
            case 'stylish':
                return file_get_contents(dirname(__DIR__) . '/' . 'tests/fixtures/diffStylish');
            case 'plain':
                return file_get_contents(dirname(__DIR__) . '/' . 'tests/fixtures/diffPlain');
            case 'json':
                return file_get_contents(dirname(__DIR__) . '/' . 'tests/fixtures/diffJson');
            default:
                throw new \Exception("Unknown type differ: $typeDiff");
        }
    }
}
