<?php

namespace StarterKit\Handlers\Blocks;

interface BlockInterface
{
    public function registerBlock(): void;

    public function blockRestApiEndpoints(): void;

    public function blockEditorAssets(): void;

    public function blockAssets(): void;
}
