<?php
namespace StarterKit\Helper;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Exception thrown when a value is not found in the config.
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
