<?php

use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => function (ContainerInterface $container) {
        $config = $container->get('config');
        $configLogger = $config['logger'];

        $level = $config['isDebug'] ? Logger::DEBUG : Logger::INFO;

        $formatter = new LineFormatter(
            LineFormatter::SIMPLE_FORMAT,
            LineFormatter::SIMPLE_DATE
        );
        $formatter->includeStacktraces(true);

        $log = new Logger('SK-Theme');

        if ($configLogger['stderr']) {
            $log->pushHandler((new StreamHandler('php://stderr', $level))->setFormatter($formatter));
        }

        if (! empty($configLogger['file'])) {
            $log->pushHandler((new StreamHandler($configLogger['file'], $level))->setFormatter($formatter));
        }

        return $log;
    },

    'config' => [
        'logger' => [
            'file'   => null,
            'stderr' => true, // server error log
        ],
    ],
];
