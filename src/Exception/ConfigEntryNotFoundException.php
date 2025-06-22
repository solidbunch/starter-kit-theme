<?php

namespace StarterKit\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Exception thrown when a value is not found in the config.
 */
class ConfigEntryNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
