<?php

namespace StarterKitTests\Unit\Container\Fixtures;

class Outer
{
    public $middle;

    public function __construct(Middle $middle)
    {
        $this->middle = $middle;
    }
}
