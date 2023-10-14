<?php

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\Route\RouteSegment;

class RouteSegmentTest extends TestCase
{
    public function testGetTypeReturnsType()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $this->assertEquals(RouteSegment::PARAMETER_MANDATORY, $segment->getType());
    }

    public function testGetValueReturnsValue()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $this->assertEquals('id', $segment->getValue());
    }

    public function testGetFormatReturnsFormat()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', 'int');
        $this->assertEquals('int', $segment->getFormat());
    }

    public function testSetTypeSetsType()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $segment->setType(RouteSegment::PARAMETER_OPTIONAL);
        $this->assertEquals(RouteSegment::PARAMETER_OPTIONAL, $segment->getType());
    }

    public function testSetValueSetsValue()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $segment->setValue('name');
        $this->assertEquals('name', $segment->getValue());
    }

    public function testSetFormatSetsFormat()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $segment->setFormat('string');
        $this->assertEquals('string', $segment->getFormat());
    }

    public function testIsParamMandatoryReturnsTrueForMandatoryParam()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $this->assertTrue($segment->isParamMandatory());
    }

    public function testIsParamMandatoryReturnsFalseForOptionalParam()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_OPTIONAL, 'id', '');
        $this->assertFalse($segment->isParamMandatory());
    }

    public function testIsParamOptionalReturnsTrueForOptionalParam()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_OPTIONAL, 'id', '');
        $this->assertTrue($segment->isParamOptional());
    }

    public function testIsParamOptionalReturnsFalseForMandatoryParam()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $this->assertFalse($segment->isParamOptional());
    }

    public function testIsParamReturnsTrueForParam()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $this->assertTrue($segment->isParam());
    }

    public function testIsParamReturnsFalseForStaticSegment()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_NO, 'home', '');
        $this->assertFalse($segment->isParam());
    }

    public function testIsRootReturnsTrueForRootSegment()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_ROOT, '', '');
        $this->assertTrue($segment->isRoot());
    }

    public function testIsRootReturnsFalseForNonRootSegment()
    {
        $segment = new RouteSegment(RouteSegment::PARAMETER_MANDATORY, 'id', '');
        $this->assertFalse($segment->isRoot());
    }
}