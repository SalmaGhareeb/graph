<?php

namespace SocialGraph\Infrastructure;

use DI\Bridge\Slim\App as DIApp;
use DI\ContainerBuilder;

class SocialGraphApp extends DIApp
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder): void
    {
        $services = require __DIR__ . '/config/services.php';
        $builder->addDefinitions($services);
    }

}
