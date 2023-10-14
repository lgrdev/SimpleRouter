<?php

declare(strict_types=1);

namespace Lgrdev\SimpleRouter\Route;

class RouteSegment implements \Lgrdev\SimpleRouter\RouterConstantes
{

    private int $type;
    private string $value;
    private string $format;

    public function __construct(int $type, string $value, string $format)
    {
        $this->type = $type;
        $this->value = $value;
        $this->format = $format;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    
    public function getFormat(): string
    {
        return $this->format;
    }

    public function setType(int $type) 
    {
        $this->type = $type;
    }

    public function setValue(string $value) 
    {
        $this->value = $value;
    }

    public function setFormat(string $format) 
    {
        $this->format = $format;
    }

    public function isParamMandatory(): bool
    {
        return $this->type === self::PARAMETER_MANDATORY;
    }

    public function isParamOptional(): bool
    {
        return $this->type === self::PARAMETER_OPTIONAL;
    }

    public function isParam(): bool
    {
        return $this->type === self::PARAMETER_MANDATORY || $this->type === self::PARAMETER_OPTIONAL;
    }

    public function isStatic(): bool
    {
        return $this->type === self::PARAMETER_NO;
    }

    public function isRoot(): bool
    {
        return $this->type === self::PARAMETER_ROOT;
    }

}