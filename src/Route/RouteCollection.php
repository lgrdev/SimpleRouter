<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter\Route;

use Lgrdev\SimpleRouter\Route\Route;

/**
 * @implements \Iterator<int, Route>
 */
class RouteCollection implements \Iterator
{
    private array $routes = [];
    private int $position = 0;

    /**
     * Add a new route to the collection.
     *
     * @param Route $route The route to add.
     * @return void
     */
    public function add(Route $route): void
    {
        $this->routes[] = $route;
        $this->sortRoute();
    }

    /**
     * Returns the current Route object.
     *
     * @return Route The current Route object.
     */
    public function current(): Route
    {
        return $this->routes[$this->position];
    }

    /**
     * Moves the internal pointer to the next Route object.
     *
     * @return void
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * Returns the key of the current Route object.
     *
     * @return int The key of the current Route object.
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Checks if the current position is valid.
     *
     * @return bool True if the current position is valid, false otherwise.
     */
    public function valid(): bool
    {
        return isset($this->routes[$this->position]);
    }

    /**
     * Resets the internal pointer to the beginning of the Route collection.
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Returns the number of routes in the collection.
     *
     * @return int The number of routes in the collection.
     */
    public function count(): int
    {
        return count($this->routes);
    }

    /**
     * Returns the Route collection as an array.
     *
     * @return array The Route collection as an array.
     */
    public function toArray(): array
    {
        return $this->routes;
    }

    /**
     * Sorts the Route collection by weight.
     *
     * @return void
     */
    private function sortRoute(): void
    {
        // Sort the routes by weight, descending.
        usort($this->routes, function (Route $a, Route $b) {
            return $b->getWeight() <=> $a->getWeight();
        });
    }

    /**
     * Get the matched route for the given URI.
     *
     * @param string $uri The URI to match against the routes.
     *
     * @return Route|null The matched Route object, or null if no match was found.
     */
    public function getMatchedRoute(string $uri): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->is_match($uri)) {
                return $route;
            }
        }

        return null;
    }

    public function runRouteForUri(string $uri): bool
    {
        $route = $this->getMatchedRoute($uri);

        if ($route === null) {
            return false;
        }
        
        $uri_params = $route->extractParams($uri);

        if (isset($uri_params)) {
            call_user_func_array($route->getCallback(), $uri_params);
        } else {
            call_user_func_array($route->getCallback(), [null]);
        }

        return true;
    }


}
