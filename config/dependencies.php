<?php

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

// Base providers (theme)
$providers = [
    new PhpFileProvider(__DIR__ . '/common/*.php'),
    new PhpFileProvider(__DIR__ . '/' . wp_get_environment_type() . '/*.php'),
];

// Allow plugins to inject config files
$additionalFiles = apply_filters('starter_kit/config/additional_files', []);
foreach ($additionalFiles as $file) {
    $providers[] = new PhpFileProvider($file);
}

$aggregator = new ConfigAggregator($providers);

return $aggregator->getMergedConfig();
