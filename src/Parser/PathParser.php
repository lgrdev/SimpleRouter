<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter\Parser;

class PathParser implements \Lgrdev\SimpleRouter\RouterConstantes
{
    /**
     * Class PathParser
     * Parses the path of a route and extracts its parameters.
     *
     * @package SimplifiedRouter\Parser
     */

 


    public function __construct() {}

    /**
     * Check if a path part is a parameter.
     *
     * @param string $pathpart The path part to check.
     *
     * @return bool Returns true if the path part is a parameter, false otherwise.
     */
    public function isParam(string $pathpart): bool
    {
        return preg_match('/\{(\w+?)(:([[:print:]]+))?(})/', $pathpart) || preg_match('/({\?)(\w+)(:([[:print:]]+))?(})/', $pathpart) ? true : false;
    }

    /**
     * Checks if a path part is an optional parameter.
     *
     * @param string $pathpart The path part to check.
     * @return bool Returns true if the path part is an optional parameter, false otherwise.
     */
    public function isOptionalParam(string $pathpart): bool
    {
        return preg_match('/({\?)(\w+)(:([[:print:]]+))?(})/', $pathpart) ? true : false;
    }

    /**
     * Returns the name of the parameter in the given path part.
     *
     * @param string $pathpart The path part to extract the parameter name from.
     * @return string The name of the parameter, or an empty string if the path part is not a parameter.
     */
    public function getParamName(string $pathpart): string
    {
        $path = trim($pathpart);

        if (substr($path, 0, 1) !== '{' || substr($path, -1, 1) !== '}') {
            return '';
        }

        if (substr($path, 0, 2) === '{?' && substr($path, -1, 1) === '}') {
            $path = '{' . substr($path, 2, null);
        }

        preg_match('/{(\w+?)(:([[:print:]]+))?\}/', $path, $matches);

        return $matches[1] ?? '';

    }

    /**
     * Returns the format of a parameter in a path part.
     *
     * @param string $pathpart The path part to analyze.
     *
     * @return string The format of the parameter, or an empty string if the path part is not a parameter.
     */
    public function getParamFormat(string $pathpart): string
    {
        $path = trim($pathpart);

        if (substr($path, 0, 1) !== '{' || substr($path, -1, 1) !== '}') {
            return '';
        }

        if (substr($path, 0, 2) === '{?' && substr($path, -1, 1) === '}') {
            $path = '{' . substr($path, 2, null);
        }

        preg_match('/{(\w+?)(:([[:print:]]+))?\}/', $path, $matches);

        return $matches[3] ?? '\w+';
    }


    /**
     * Parses a given path and returns an array of its URI parts.
     *
     * @param string $path The path to be parsed.
     *
     * @return array The array of URI parts.
     */
    public function getUriParts(string $path): array
    {
        if (empty($path) || is_string($path) === false || $path === null) {
            throw new \InvalidArgumentException('Invalid path');
        }

        if (empty($path) || $path === '/') {

            $list[] = ['type' => self::PARAMETER_ROOT,
                        'name' => '/',
                        'format' => '/'];

        } else {

            $list = explode('/', $path);

            if ($list[0] === '') {
                $list = array_slice($list, 1);
            }
            if (count($list) !== 0 && $list[count($list) - 1] === '') {
                array_pop($list);
            }

            foreach($list as $key => $value) {
                if($this->isParam($value)) {
                    $list[$key] =   ['type' => $this->isOptionalParam($value) ? self::PARAMETER_OPTIONAL : self::PARAMETER_MANDATORY ,
                                        'name' => $this->getParamName($value),
                                        'format' => $this->getParamFormat($value)];
                } else {
                    $list[$key] =   ['type' => self::PARAMETER_NO,
                                        'name' => $value,
                                        'format' => ''];
                }
            }

        }

        return $list;
    }
}
