<?php

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder = apply_filters('starter_kit/container_builder', $builder);

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

return $builder->build();
