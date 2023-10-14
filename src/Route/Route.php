<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter\Route;

use Lgrdev\SimpleRouter\Route\RouteSegment;
use Lgrdev\SimpleRouter\Route\RouteSegmentCollection;
use Lgrdev\SimpleRouter\Parser\PathParser;

class Route implements \Lgrdev\SimpleRouter\RouterConstantes
{
    private string $method;
    private string $path;
    private $callback;
    private string $pattern;
    private RouteSegmentCollection $segments;
    private int $weight;

    private PathParser $parsepath;

    public function __construct(string $method, string $route, callable $callback)
    {
        $this->parsepath = new PathParser();
        
        $this->method = $method;
        $this->path = $route;
        $this->callback = $callback;
        $this->segments = new RouteSegmentCollection();
        $this->pattern = '';
        $this->weight = 0;
        
        // add segments from $route avec le parser
        $this->setSegments($this->parsepath->getUriParts($route));
        
        // calculate pattern and wieght
        $this->calculatePattern();
        $this->calculateWeight();
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function setPattern(string $pattern): void
    {
        $this->pattern = $pattern;
    }
    
    public function setSegments(array $asegments): void
    {
        
        foreach ($asegments as $segment) {

            $this->segments->add(new RouteSegment($segment['type'], $segment['name'], $segment['format']));

        }
        $this->calculatePattern();
        $this->calculateWeight();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function getSegments(): RouteSegmentCollection
    {
        return $this->segments;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function is_match(string $url): bool
    {
        return (preg_match('/' . $this->pattern . '/', $url) === 1);
    }

    private function calculateWeight(): void
    {

        $this->weight = 0;
        foreach ($this->segments as $segment) {
            if ($segment->isParamMandatory()) {
                $this->weight += 2;
            } elseif ($segment->isParamOptional()) {
                $this->weight += 3;
            } elseif ($segment->isStatic()) {
                $this->weight += 1;
            }
        }
    }

    private function calculatePattern():void
    {
        $this->pattern = '';

        foreach($this->segments as $segment) {
            if ($segment->isParamMandatory()) {
                $this->pattern .= '(\/' . $segment->getFormat() . ')';
            } elseif ($segment->isParamOptional()) {
                $this->pattern .= '(\/' . $segment->getFormat() . ')?';
            } elseif ($segment->isStatic()) {
                $this->pattern .= '(\/' . $segment->getValue() . ')';
            } else {
                // it's the root
                $this->pattern .= '^\/$';
            }
        }

    }

    public function extractParams($uri): array|null
    {
        if (preg_match('/' . $this->pattern . '/', $uri, $matches)) {
            array_shift($matches); // Remove the full match
            $arsegments = $this->segments->getSegments();
            for ($i = 0; $i < count($matches); $i++) {
                
                // Vérifiez si le "type" est égal à 1 dans le tableau de définition
                if (!$arsegments[$i]->isStatic()) {
                    // Ajoutez l'élément correspondant du tableau user au résultat
                    $result[] = preg_replace('/^\/(.*)/', '$1', $matches[$i]);
                }
            }
            unset($arsegments);
        }
        
        return isset($result) ? $result : null;
    }

}
