<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter\Tests\Parser;

use Lgrdev\SimpleRouter\Parser\PathParser;
use PHPUnit\Framework\TestCase;

class PathParserTest extends TestCase
{
    private PathParser $pathParser;

    protected function setUp(): void
    {
        $this->pathParser = new PathParser();
    }

    public function testGetUriPartsReturnsArray(): void
    {
        $uriParts = $this->pathParser->getUriParts('/users/{id}');
        $this->assertIsArray($uriParts);
    }

    public function testGetUriPartsReturnsRootParameter(): void
    {
        $uriParts = $this->pathParser->getUriParts('/');
        $this->assertEquals([['type' => PathParser::PARAMETER_ROOT, 'name' => '/', 'format' => '/']], $uriParts);
    }

    public function testGetUriPartsReturnsNoParameter(): void
    {
        $uriParts = $this->pathParser->getUriParts('/users');
        $this->assertEquals([['type' => PathParser::PARAMETER_NO, 'name' => 'users', 'format' => '']], $uriParts);
    }

    public function testGetUriPartsReturnsMandatoryParameter(): void
    {
        $uriParts = $this->pathParser->getUriParts('/users/{id}');
        $this->assertEquals(['type' => PathParser::PARAMETER_MANDATORY, 'name' => 'id', 'format' => '\w+'], $uriParts[1]);
    }

    public function testGetUriPartsReturnsOptionalParameter(): void
    {
        $uriParts = $this->pathParser->getUriParts('/users/{?id}');
        $this->assertEquals(['type' => PathParser::PARAMETER_OPTIONAL, 'name' => 'id', 'format' => '\w+'], $uriParts[1]);
    }

    public function testGetUriPartsThrowsExceptionForInvalidPath(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->pathParser->getUriParts(null);
    }
}