<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter;

use Lgrdev\SimpleRouter\Route\RouteCollection;
use Lgrdev\SimpleRouter\Route\Route;

class SimpleRouter
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';


    private RouteCollection $getroutes;
    private RouteCollection $postroutes;
    private RouteCollection $putroutes;
    private RouteCollection $deleteroutes;


    public function __construct()
    {
        
        $this->getroutes = new RouteCollection();
        $this->postroutes = new RouteCollection();
        $this->putroutes = new RouteCollection();
        $this->deleteroutes = new RouteCollection();

    }

    /**
     * Add a new route to the router.
     *
     * @param string $method The HTTP method for the route (e.g. GET, POST, PUT, DELETE).
     * @param string $route The URL path for the route.
     * @param callable $callback The function to call when the route is matched.
     * @return void
     */
    public function addRoute(string $method, string $route, callable $callback)
    {
        if ($method !== self::METHOD_GET && $method !== self::METHOD_POST && $method !== self::METHOD_PUT && $method !== self::METHOD_DELETE) {
            throw new \InvalidArgumentException('Invalid HTTP method');
        }
        if (empty($route) || is_string($route) === false) {
            throw new \InvalidArgumentException('Invalid route');
        }
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Invalid callback');
        }

        switch ($method) {

            case SimpleRouter::METHOD_GET:
                $this->getroutes->add(new Route($method, $route, $callback));
                break;

            case SimpleRouter::METHOD_POST:
                $this->postroutes->add(new Route($method, $route, $callback));
                break;
            case SimpleRouter::METHOD_PUT:
                $this->putroutes->add(new Route($method, $route, $callback));
                break;
            case SimpleRouter::METHOD_DELETE:
                $this->deleteroutes->add(new Route($method, $route, $callback));
                break;
        }

    }

    /**
     * Adds a GET route to the router.
     *
     * @param string $route The route to match.
     * @param callable $callback The callback function to execute when the route is matched.
     * @return void
     */
    public function addGet(string $route, callable $callback)
    {
        $this->addRoute(self::METHOD_GET, $route, $callback);

    }

    /**
     * Add a POST route to the router.
     *
     * @param string $route The route to match.
     * @param callable $callback The callback to execute when the route is matched.
     * @return void
     */
    public function addPost(string $route, callable $callback)
    {
        $this->addRoute(self::METHOD_POST, $route, $callback);

    }

    /**
     * Add a PUT route to the router.
     *
     * @param string $route The route URL.
     * @param callable $callback The callback function to be executed when the route is matched.
     * @return void
     */
    public function addPut(string $route, callable $callback)
    {
        $this->addRoute(self::METHOD_PUT, $route, $callback);

    }

    /**
     * Adds a DELETE route to the router.
     *
     * @param string $route The route to add.
     * @param callable $callback The callback function to execute when the route is matched.
     * @return void
     */
    public function addDelete(string $route, callable $callback)
    {
        $this->addRoute(self::METHOD_DELETE, $route, $callback);
    }

    public function redirectionErreur404()
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    /**
     * Runs the router for the given HTTP method and URI.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param string $uri The URI to search for.
     * @return void
     */
    public function run(string $method, string $uri)
    {
        // Validate the URI input
        if (!preg_match('/^[a-zA-Z0-9\/_-]+$/', $uri)) {
            $this->redirectionErreur404();
            return;
        }

        switch ($method) {
            case SimpleRouter::METHOD_GET:
                if ($this->getroutes->runRouteForUri($uri) === true) {
                    return;
                }
                break;

            case SimpleRouter::METHOD_POST:
                if ($this->postroutes->runRouteForUri($uri) === true) {
                    return;
                }

                break;

            case SimpleRouter::METHOD_PUT:
                if ($this->putroutes->runRouteForUri($uri) === true) {
                    return;
                }

                break;

            case SimpleRouter::METHOD_DELETE:
                if ($this->deleteroutes->runRouteForUri($uri) === true) {
                    return;
                }

                break;

            default:
                break;
        }

        $this->redirectionErreur404();
    }
}
