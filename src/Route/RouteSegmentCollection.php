<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter\Route;

use Lgrdev\SimpleRouter\Route\RouteSegment;

/**
 * @implements \Iterator<int, RouteSegment>
 */
class RouteSegmentCollection implements \Countable, \Iterator
{
    private array $route_segments = [];
    private int $position = 0;

    /**
     * Add a RouteSegment object to the collection
     * @param RouteSegment $routesegment The RouteSegment object to add
     * @return void
     */
    public function add(RouteSegment $routesegment): void
    {
        $this->route_segments[] = $routesegment;
    }

    /**
     * Get the current Route object in the collection
     * @return Route The current Route object
     */
    public function current(): RouteSegment
    {
        return $this->route_segments[$this->position];
    }

    /**
     * Move to the next Route object in the collection
     * @return void
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * Get the key of the current Route object in the collection
     * @return int The key of the current Route object
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Check if the current position in the collection is valid
     * @return bool True if the current position is valid, false otherwise
     */
    public function valid(): bool
    {
        return isset($this->route_segments[$this->position]);
    }

    /**
     * Rewind the position in the collection to the beginning
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Get the number of Route objects in the collection
     * @return int The number of Route objects in the collection
     */
    public function count(): int
    {
        return count($this->route_segments);
    }

    public function getSegments(): array
    {
        return $this->route_segments;
    }

}
