<?php

use Dotenv\Dotenv;
use SocialGraph\Infrastructure\SocialGraphApp;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::create(__DIR__ . '/../');
$dotenv->load();

session_start();

// Instantiate the app
//$settings = require __DIR__ . '/../src/SocialGraph/bootstrap.php';
$app = new SocialGraphApp();

Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
// Register routes
$routes = require __DIR__ . '/../src/SocialGraph/Infrastructure/routes.php';
$routes($app);

// Run app
$app->run();
