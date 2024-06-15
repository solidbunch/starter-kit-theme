<?php

namespace StarterKit\Handlers\Blocks;

interface BlockInterface
{
    function registerBlock(): void;

    function blockRestApiEndpoints(): void;

    function blockEditorAssets(): void;

    function blockAssets(): void;
}
