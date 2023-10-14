<?php

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\Route\RouteSegment;
use Lgrdev\SimpleRouter\Route\RouteSegmentCollection;

class RouteSegmentCollectionTest extends TestCase
{
    public function testAddAndGetSegments(): void
    {
        $collection = new RouteSegmentCollection();
        $segment1 = new RouteSegment(1,'/foo', 'handler1');
        $segment2 = new RouteSegment(2,'/bar',  'handler2');
        $collection->add($segment1);
        $collection->add($segment2);
        $this->assertEquals([$segment1, $segment2], $collection->getSegments());
    }

    public function testIteration(): void
    {
        $collection = new RouteSegmentCollection();
        $segment1 = new RouteSegment(1,'/foo',  'handler1');
        $segment2 = new RouteSegment(1,'/bar',  'handler2');
        $collection->add($segment1);
        $collection->add($segment2);
        $expected = [$segment1, $segment2];
        $actual = [];
        foreach ($collection as $segment) {
            $actual[] = $segment;
        }
        $this->assertEquals($expected, $actual);
    }

    public function testCount(): void
    {
        $collection = new RouteSegmentCollection();
        $segment1 = new RouteSegment(1,'/foo',  'handler1');
        $segment2 = new RouteSegment(2,'/bar',  'handler2');
        $collection->add($segment1);
        $collection->add($segment2);
        $this->assertEquals(2, count($collection));
    }
}