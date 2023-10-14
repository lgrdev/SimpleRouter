<?php

use PHPUnit\Framework\TestCase;
use Lgrdev\SimpleRouter\Route;
use Lgrdev\SimpleRouter\RouteCollection;
use Lgrdev\SimpleRouter\SimpleRouter;

class SimpleRouterTest extends TestCase
{
    public function testAddRoute()
    {
        $router = new SimpleRouter();
        $router->addRoute('GET', '/test', function () {
            echo 'Hello, world!';
        });

        $this->expectOutputString('Hello, world!');
        $router->run('GET', '/test');
    }

    public function testAddGet()
    {
        $router = new SimpleRouter();
        $router->addGet('/test', function () {
            echo 'Hello, world!';
        });

        $this->expectOutputString('Hello, world!');
        $router->run('GET', '/test');
    }

    public function testAddPost()
    {
        $router = new SimpleRouter();
        $router->addPost('/test', function () {
            echo 'Hello, world!';
        });

        $this->expectOutputString('Hello, world!');
        $router->run('POST', '/test');
    }

    public function testAddPut()
    {
        $router = new SimpleRouter();
        $router->addPut('/test', function () {
            echo 'Hello, world!';
        });

        $this->expectOutputString('Hello, world!');
        $router->run('PUT', '/test');
    }

    public function testAddDelete()
    {
        $router = new SimpleRouter();
        $router->addDelete('/test', function () {
            echo 'Hello, world!';
        });

        $this->expectOutputString('Hello, world!');
        $router->run('DELETE', '/test');
    }

    public function testInvalidMethod()
    {
        $this->expectException(\InvalidArgumentException::class);

        $router = new SimpleRouter();
        $router->addRoute('INVALID', '/test', function () {
            echo 'Hello, world!';
        });
    }

    public function testInvalidRoute()
    {
        $router = new SimpleRouter();

        $this->expectException(\InvalidArgumentException::class);
        $router->addRoute('GET', null, function () {
            echo 'Hello, world!';
        });
    }

    public function testInvalidCallback()
    {
        $router = new SimpleRouter();

        $this->expectException(\InvalidArgumentException::class);
        $router->addRoute('GET', '/test', 'invalid_callback');
    }

    public function testRouteNotFound()
    {
        $router = new SimpleRouter();

        $this->expectOutputString('Route not found');
        $router->run('GET', '/test');
    }
}