<?php
// cli-config.php
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Dotenv\Dotenv;
use Slim\Container;

$dotenv = Dotenv::create(__DIR__ . '/../');
$dotenv->load();

Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

/** @var Container $container */
$app = new \SocialGraph\Infrastructure\SocialGraphApp();
$container = $app->getContainer();

ConsoleRunner::run(
    ConsoleRunner::createHelperSet($container->get(\Doctrine\ORM\EntityManager::class))
);
