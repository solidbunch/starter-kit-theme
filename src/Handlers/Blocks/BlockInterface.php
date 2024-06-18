<?php

namespace StarterKit\Handlers\Blocks;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Helper\NotFoundException;

interface BlockInterface
{
    /**
     * Server side render callback function, used only if block need to be rendered on server side
     * Not mandatory
     *
     * @param array  $attributes
     * @param string $content
     * @param object $block
     *
     * @return string
     */
    //public function blockServerSideCallback(array $attributes, string $content, object $block): string;

    /**
     * Register rest api endpoints
     * Runs by abstract constructor
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockRestApiEndpoints(): void;
}
