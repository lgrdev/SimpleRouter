<?php

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\Route\Route;
use Lgrdev\SimpleRouter\Route\RouteSegmentCollection;
use Lgrdev\SimpleRouter\Route\RouteSegment;

class RouteTest extends TestCase
{
    public function testConstructor(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $this->assertInstanceOf(Route::class, $route1);
        $this->assertEquals($method, $route1->getMethod());
        $this->assertEquals($route, $route1->getPath());
        $this->assertEquals($callback, $route1->getCallback());
    }

    public function testGetPattern(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $this->assertEquals('/foo/(\d+)', $route1->getPattern());
    }

    public function testSetPattern(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $route1->setPattern('/bar/(\d+)');
        $this->assertEquals('/bar/(\d+)', $route1->getPattern());
    }

    public function testSetSegments(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $segments = [
            ['type' => 1, 'name' => 'foo', 'format' => 'foo'],
            ['type' => 0, 'name' => 'id', 'format' => '\d+'],
        ];
        $route1->setSegments($segments);
        $expected = new RouteSegmentCollection();
        $expected->add(new RouteSegment(1, 'foo', 'foo'));
        $expected->add(new RouteSegment(0, 'id', '\d+'));
        $this->assertEquals($expected, $route1->getSegments());
    }

    public function testGetWeight(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $this->assertEquals(3, $route1->getWeight());
    }

    public function testIsMatch(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $this->assertTrue($route1->is_match('/foo/123'));
        $this->assertFalse($route1->is_match('/bar/123'));
    }

    public function testExtractParams(): void
    {
        $method = 'GET';
        $route = '/foo/{id:\d+}';
        $callback = function () {
            return 'Hello, world!';
        };
        $route1 = new Route($method, $route, $callback);
        $params = $route1->extractParams('/foo/123');
        $this->assertEquals(['123'], $params);
    }
}