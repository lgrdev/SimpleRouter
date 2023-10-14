<?php 

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\Parser\PathParser;

class PathParserTest extends TestCase
{
    public function testGetUriPartsReturnsArray(): void
    {
        $pathParser = new PathParser();
        $uriParts = $pathParser->getUriParts('/users/{id}');
        $this->assertIsArray($uriParts);
    }

    public function testGetUriPartsReturnsCorrectArray(): void
    {
        $pathParser = new PathParser();
        $uriParts = $pathParser->getUriParts('/users/{id}');
        $expected = [
            ['type' => PathParser::PARAMETER_NO, 'name' => 'users', 'format' => ''],
            ['type' => PathParser::PARAMETER_MANDATORY, 'name' => 'id', 'format' => '\w+']
        ];
        $this->assertEquals($expected, $uriParts);
    }

    public function testGetUriPartsThrowsExceptionForInvalidPath(): void
    {
        $pathParser = new PathParser();
        $this->expectException(\InvalidArgumentException::class);
        $pathParser->getUriParts(null);
    }

    public function testIsParamReturnsTrueForParameter(): void
    {
        $pathParser = new PathParser();
        $isParam = $pathParser->isParam('{id}');
        $this->assertTrue($isParam);
    }

    public function testIsParamReturnsFalseForNonParameter(): void
    {
        $pathParser = new PathParser();
        $isParam = $pathParser->isParam('users');
        $this->assertFalse($isParam);
    }

    public function testIsOptionalParamReturnsTrueForOptionalParameter(): void
    {
        $pathParser = new PathParser();
        $isOptionalParam = $pathParser->isOptionalParam('{?id}');
        $this->assertTrue($isOptionalParam);
    }

    public function testIsOptionalParamReturnsFalseForMandatoryParameter(): void
    {
        $pathParser = new PathParser();
        $isOptionalParam = $pathParser->isOptionalParam('{id}');
        $this->assertFalse($isOptionalParam);
    }

    public function testGetParamNameReturnsCorrectName(): void
    {
        $pathParser = new PathParser();
        $paramName = $pathParser->getParamName('{id}');
        $this->assertEquals('id', $paramName);
    }

    public function testGetParamNameReturnsEmptyStringForNonParameter(): void
    {
        $pathParser = new PathParser();
        $paramName = $pathParser->getParamName('users');
        $this->assertEquals('', $paramName);
    }

    public function testGetParamFormatReturnsCorrectFormat(): void
    {
        $pathParser = new PathParser();
        $paramFormat = $pathParser->getParamFormat('{id:\d+}');
        $this->assertEquals('\d+', $paramFormat);
    }

    public function testGetParamFormatReturnsDefaultFormatForNonParameter(): void
    {
        $pathParser = new PathParser();
        $paramFormat = $pathParser->getParamFormat('users');
        $this->assertEquals('\w+', $paramFormat);
    }
}