<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter;

use Lgrdev\SimpleRouter\Parser\PathParser;

class SimpleRouter
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';


    private $getroutes = [];
    private $postroutes = [];
    private $putroutes = [];
    private $deleteroutes = [];

    private PathParser $parsepath;



    public function __construct()
    {
        $this->parsepath = new PathParser();
    }

    /**
     * Returns an array of registered GET routes.
     *
     * @return array
     */
    public function getGetRoutes() {
        return $this->getroutes;
    }

    /**
     * Returns an array of registered POST routes.
     *
     * @return array
     */
    public function getPostRoutes() {
        return $this->postroutes;
    }

    /**
     * Returns an array of registered PUT routes.
     *
     * @return array
     */
    public function getPutRoutes() {
        return $this->putroutes;
    }

    /**
     * Returns an array of registered DELETE routes.
     *
     * @return array
     */
    public function getDeleteRoutes() {
        return $this->deleteroutes;
    }
    


    /**
     * Calculates the weight of a given path array based on the type of each parameter.
     *
     * @param array $arrPath The path array to calculate the weight for.
     *
     * @return int The weight of the path array.
     */
    private function calculationWeight($arrPath): int
    {
        $weight = 0;
        
        foreach($arrPath as $value) {
        
            if ($value['type'] === PathParser::PARAMETER_MANDATORY) {
                $weight += 2;
            } elseif ($value['type'] === PathParser::PARAMETER_OPTIONAL) {
                $weight += 3;
            } else {
                $weight += 1;
            }
        }

        return $weight;
    }

    /**
     * Returns a string pattern for the given array of routes.
     *  Route / => Weight 0
     *  Route /user => Weight 1
     *  Route /user/125 => Weight 3
     *
     * @param array $arrRoute An array of routes.
     *
     * @return string The string pattern for the given array of routes.
     */
    private function getPatternRoute(array $arrRoute): string
    {
        $pattern = '';

        if (empty($arrRoute) || is_array($arrRoute[0]) === false) {
            return $pattern;
        }


        foreach($arrRoute as $value) {
            if ($value['type'] === PathParser::PARAMETER_MANDATORY) {
                $pattern .= '(\/' . $value['format'] . ')';
            } elseif ($value['type'] === PathParser::PARAMETER_OPTIONAL) {
                $pattern .= '(\/' . $value['format'] . ')?';
            } elseif ($value['type'] === PathParser::PARAMETER_NO) {
                $pattern .= '(\/' . $value['name'] . ')';
            } else {
                $pattern .= '^\/$';
            }
        }

        return $pattern;
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
            return;
        }
        if (empty($route) || is_string($route) === false) {
            throw new \InvalidArgumentException('Invalid route');
            return;
        }
        if (is_callable($callback) === false) {
            throw new \InvalidArgumentException('Invalid callback');
            return;
        }


        $arrPath = $this->parsepath->getUriParts($route);

        // Calculate the weight to process the simplest cases first:
        // Route / => Weight 0
        // Route /user => Weight 1
        // Route /user/125 => Weight 3
        if (empty($arrPath) || is_array($arrPath[0]) === false) {
            $weight = 0;
        } else   {
            $weight = $this->calculationWeight($arrPath);
        }

        switch ($method) {

            case SimpleRouter::METHOD_GET:
                $this->getroutes[] = [
                    'path' => $route,
                    'pattern' => $this->getPatternRoute($arrPath),
                    'callable' => $callback,
                    'params' => $arrPath,
                    'weight' => $weight
                ];
                uasort($this->getroutes, function ($a, $b) {
                    return $a['weight'] <=> $b['weight'];
                });
                break;

            case SimpleRouter::METHOD_POST:
                $this->postroutes[] = [
                    'path' => $route,
                    'pattern' => $this->getPatternRoute($arrPath),
                    'callable' => $callback,
                    'params' => $arrPath,
                    'weight' => $weight
                ];
                uasort($this->postroutes, function ($a, $b) {
                    return $a['weight'] <=> $b['weight'];
                });
                break;
            case SimpleRouter::METHOD_PUT:
                $this->putroutes[] = [
                    'path' => $route,
                    'pattern' => $this->getPatternRoute($arrPath),
                    'callable' => $callback,
                    'params' => $arrPath,
                    'weight' => $weight
                ];
                uasort($this->putroutes, function ($a, $b) {
                    return $a['weight'] <=> $b['weight'];
                });
                break;
            case SimpleRouter::METHOD_DELETE:
                $this->deleteroutes[] = [
                    'path' => $route,
                    'pattern' => $this->getPatternRoute($arrPath),
                    'callable' => $callback,
                    'params' => $arrPath,
                    'weight' => $weight
                ];
                uasort($this->deleteroutes, function ($a, $b) {
                    return $a['weight'] <=> $b['weight'];
                });
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

    /**
     * Search for a matching route in the given array of routes for the given URI.
     *
     * @param array $routes An array of routes to search through.
     * @param string $uri The URI to search for a matching route.
     * @return bool Returns TRUE if a matching route was found, FALSE otherwise.
     */
    private function searchRoute(array $routes, string $uri): bool
    {

        foreach ($routes as $route) {
            // appel d'une fonction qui ne garde que les parametre dans $matches

            if (preg_match('/' . $route['pattern'] . '/', $uri, $matches)) {
                array_shift($matches); // Remove the full match
                for ($i = 0; $i < count($matches); $i++) {
                    // Vérifiez si le "type" est égal à 1 dans le tableau de définition
                    if ($route['params'][$i]["type"] != PathParser::PARAMETER_NO) {
                        // Ajoutez l'élément correspondant du tableau user au résultat
                        $result[] = preg_replace('/^\/(.*)/', '$1', $matches[$i]);
                    }
                }

                if (isset($result)) {
                    call_user_func_array($route['callable'], $result);
                } else {
                    call_user_func_array($route['callable'], [null]);
                }

                return true;
            }
        }

        return false;
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

        switch ($method) {
            case SimpleRouter::METHOD_GET:
                if ($this->searchRoute($this->getroutes, $uri) === true) {
                    return;
                }

                break;

            case SimpleRouter::METHOD_POST:
                if ($this->searchRoute($this->postroutes, $uri) === true) {
                    return;
                }

                break;

            case SimpleRouter::METHOD_PUT:
                if ($this->searchRoute($this->putroutes, $uri) === true) {
                    return;
                }

                break;

            case SimpleRouter::METHOD_DELETE:
                if ($this->searchRoute($this->deleteroutes, $uri) === true) {
                    return;
                }

                break;

            default:
                echo "Verb not found";
                return;
        }

        echo "Route not found";
    }

}
