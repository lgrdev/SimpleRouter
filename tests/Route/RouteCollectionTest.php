<?php

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\Route\Route;
use Lgrdev\SimpleRouter\Route\RouteCollection;

class RouteCollectionTest extends TestCase
{
    public function testAddRoute()
    {
        $route1 = new Route('GET', '/foo', function () {});
        $route2 = new Route('GET','/bar', function () {});

        $collection = new RouteCollection();
        $collection->add($route1);
        $collection->add($route2);

        $this->assertEquals([$route1, $route2], $collection->toArray());
    }

    public function testGetMatchedRoute()
    {
        $route1 = new Route('GET','/foo', function () {});
        $route2 = new Route('GET','/bar', function () {});

        $collection = new RouteCollection();
        $collection->add($route1);
        $collection->add($route2);

        $this->assertEquals($route1, $collection->getMatchedRoute('/foo'));
        $this->assertEquals($route2, $collection->getMatchedRoute('/bar'));
        $this->assertNull($collection->getMatchedRoute('/baz'));
    }

    public function testRunRouteForUri()
    {
        $route1 = new Route('GET','/foo/{id}', function ($id) {
            $this->assertEquals('123', $id);
        });
        $route2 = new Route('GET','/bar', function () {});

        $collection = new RouteCollection();
        $collection->add($route1);
        $collection->add($route2);

        $this->assertTrue($collection->runRouteForUri('/foo/123'));
        $this->expectException(\Exception::class);
        $collection->runRouteForUri('/baz');
    }
}