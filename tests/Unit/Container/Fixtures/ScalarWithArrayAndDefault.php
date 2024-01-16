<?php

namespace StarterKitTests\Unit\Container\Fixtures;

class ScalarWithArrayAndDefault
{
    public $inner;
    public $array;
    public $default;

    public function __construct(Inner $inner, array $array = [], $default = 10)
    {
        $this->inner = $inner;
        $this->array = $array;
        $this->default = $default;
    }
}
