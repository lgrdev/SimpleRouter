<?php

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\SimpleRouter;

class SimpleRouterTest extends TestCase
{
    public function testAddRoute()
    {
        $router = new SimpleRouter();
        $router->addRoute(SimpleRouter::METHOD_GET, '/', function() {
            echo 'Hello, world!';
        });

        $this->assertNotEmpty($router->getGetRoutes());
    }

    public function testAddInvalidRoute()
    {
        $router = new SimpleRouter();

        $this->expectException(\InvalidArgumentException::class);
        $router->addRoute('INVALID_METHOD', '/', function() {
            echo 'Hello, world!';
        });
    }

    public function testAddInvalidCallback()
    {
        $router = new SimpleRouter();

        $this->expectException(\InvalidArgumentException::class);
        $router->addRoute(SimpleRouter::METHOD_GET, '/', 'omg');
    }
}