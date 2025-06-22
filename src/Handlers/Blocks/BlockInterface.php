<?php

namespace StarterKit\Handlers\Blocks;

interface BlockInterface
{
    /**
     * Register block additional arguments including server side render callback
     * $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
     *
     * @return void
     */
    public function registerBlockArgs(): void;

    /**
     * Register rest api endpoints
     * Runs by abstract constructor
     *
     * @return void
     */
    public function blockRestApiEndpoints(): void;
}
