<?php

namespace StarterKitTests\Unit\Container;

use DI\Container;
use DI\Definition\Exception\InvalidDefinition;
use Psr\Container\NotFoundExceptionInterface;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{

    protected static $container;

    protected function setUp(): void
    {
        parent::setUp();

        static::$container = new Container();
    }

    public function testPrimitives()
    {
        $container = static::$container;

        $container->set($name = 'name', $value = 5);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = 'string');
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = ['array']);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = new \stdClass());
        self::assertEquals($value, $container->get($name));
    }

    public function testCallback()
    {
        $container = static::$container;

        $container->set($name = 'name', function () {
            return new \stdClass();
        });

        self::assertNotNull($value = $container->get($name));
        self::assertInstanceOf(\stdClass::class, $value);
    }

    public function testContainerPass()
    {
        $container = static::$container;

        $container->set('param', $value = 15);
        $container->set($name = 'name', function (Container $container) {
            $object = new \stdClass();
            $object->param = $container->get('param');

            return $object;
        });

        self::assertObjectHasProperty('param', $object = $container->get($name));
        self::assertEquals($value, $object->param);
    }

    public function testSingleton()
    {
        $container = static::$container;

        $container->set($name = 'name', function () {
            return new \stdClass();
        });

        self::assertNotNull($value1 = $container->get($name));
        self::assertNotNull($value2 = $container->get($name));
        self::assertSame($value1, $value2);
    }

    public function testAutoInstantiating()
    {
        $container = static::$container;

        self::assertNotNull($value1 = $container->get(\stdClass::class));
        self::assertNotNull($value2 = $container->get(\stdClass::class));

        self::assertInstanceOf(\stdClass::class, $value1);
        self::assertInstanceOf(\stdClass::class, $value2);

        self::assertSame($value1, $value2);
    }

    public function testAutowiring()
    {
        $container = static::$container;

        $outer = $container->get(Outer::class);

        self::assertNotNull($outer);
        self::assertInstanceOf(Outer::class, $outer);

        self::assertNotNull($middle = $outer->middle);
        self::assertInstanceOf(Middle::class, $middle);

        self::assertNotNull($inner = $middle->inner);
        self::assertInstanceOf(Inner::class, $inner);
    }

    public function testAutowiringScalarWithDefault()
    {
        $container = static::$container;

        $scalar = $container->get(ScalarWithArrayAndDefault::class);

        self::assertNotNull($scalar);

        self::assertNotNull($inner = $scalar->inner);
        self::assertInstanceOf(Inner::class, $inner);

        self::assertEquals([], $scalar->array);
        self::assertEquals(10, $scalar->default);
    }

    public function testAutowiringScalarWithoutDefault()
    {
        $container = static::$container;

        $this->expectException(InvalidDefinition::class);

        $container->get(ScalarWithOutDefault::class);
    }

    public function testNotFound()
    {
        $container = static::$container;

        $this->expectException(NotFoundExceptionInterface::class);

        $container->get('email');
    }
}


class Outer
{

    public $middle;

    public function __construct(Middle $middle)
    {
        $this->middle = $middle;
    }
}


class Middle
{

    public $inner;

    public function __construct(Inner $inner)
    {
        $this->inner = $inner;
    }
}


class Inner
{

}


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


