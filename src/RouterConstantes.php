<?php 

declare(strict_types=1);

namespace Lgrdev\SimpleRouter;

interface RouterConstantes
{
   /**
     * Indicates that the parameter is not a route parameter.
     */
    const PARAMETER_ROOT = 0;

    /**
     * Indicates that the parameter is not a route parameter.
     */
    const PARAMETER_NO = 1;

    /**
     * Indicates that the parameter is a mandatory route parameter.
     */
    const PARAMETER_MANDATORY = 2;

    /**
     * Indicates that the parameter is an optional route parameter.
     */
    const PARAMETER_OPTIONAL = 3;
}
