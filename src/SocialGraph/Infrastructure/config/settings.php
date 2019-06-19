<?php

use Psr\Http\Message\ResponseInterface;

return [
    'settings.debug'               => true,
    'settings.displayErrorDetails' => true,
    'errorHandler'                 => static function ($c) {
        return static function ($request, ResponseInterface $response, \Exception $exception) {
            return $response->withJson(['message' => $exception->getMessage(),
                                        'code'    => $exception->getCode()]);
        };
    },
    'doctrine'                     => [
        // if true, metadata caching is forcefully disabled
        'dev_mode'      => true,
        // path where the compiled metadata info will be cached
        // make sure the path exists and it is writable
        'cache_dir'     => __DIR__ . '/../../../../logs/doctrine',
        // you should add any other path containing annotated entity classes
        'metadata_dirs' => [__DIR__ . '/../../Domain'],
        'connection'    => [
            'driver'    => 'pdo_mysql',
            'host'      => getenv('MYSQL_DB_HOST'),
            'port'      => getenv('MYSQL_DB_PORT'),
            'dbname'    => getenv('MYSQL_DB_NAME'),
            'user'      => getenv('MYSQL_DB_USER'),
            'password'  => getenv('MYSQL_DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
