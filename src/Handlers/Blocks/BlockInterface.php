<?php

namespace StarterKit\Handlers\Blocks;

interface BlockInterface
{
    function registerBlock(): void;

    function blockRestApiEndpoints(): void;

    function blockOnInit();

    function blockAssets(): void;

}
