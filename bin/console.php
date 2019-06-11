#!/usr/bin/env php
<?php

// application.php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Slim\Container;
use SocialGraph\Infrastructure\SocialGraphApp;
use Symfony\Component\Console\Application;

$dotenv = Dotenv::create(__DIR__ . '/../');
$dotenv->load();
/** @var Container $container */
$app         = new SocialGraphApp();
$container   = $app->getContainer();
$application = new Application();

$algorithmsService = $container->get(\SocialGraph\Application\Service\AlgorithmsService::class);

$application->add(new \SocialGraph\Port\DFSAlgorithmCommand($algorithmsService));

$application->run();
