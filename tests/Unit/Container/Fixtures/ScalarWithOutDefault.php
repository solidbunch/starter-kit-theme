<?php

namespace StarterKitTests\Unit\Container\Fixtures;

class ScalarWithOutDefault
{
    public $inner;
    public $some;

    public function __construct(Inner $inner, $some)
    {
        $this->inner = $inner;
        $this->some = $some;
    }
}
