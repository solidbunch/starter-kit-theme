<?php

namespace StarterKit\Handlers\CLI\Commands;

defined('ABSPATH') || exit;

use StarterKit\Helper\Utils;
use WP_CLI;

class CloneTheme
{
    public static function run(): void
    {
        if (!Utils::isDoingWPCLI()) {
            return;
        }

        //$AcCache = AC()->getCache();
        //$result  = $AcCache->InstanceCache->clear();
        $result = 'test';
        WP_CLI::success($result);
    }

}
