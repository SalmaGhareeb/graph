<?php

use Slim\App;
use SocialGraph\Http\Apis\GraphController;

return function (App $app) {
    $app->group('/graph', function () use ($app) {
        $app->get('/{id}', GraphController::class . '::getAction');
        $app->delete('/{id}', GraphController::class . '::deleteAction');
        $app->post('/', GraphController::class . '::createAction');
        $app->get('/{id}/nodes', GraphController::class . '::getGraphNodesAction');
    });

    $app->group('/node', function () use ($app) {
        $app->get('/{id}', \SocialGraph\Http\Apis\NodeController::class . '::getAction');
        $app->delete('/{id}', \SocialGraph\Http\Apis\NodeController::class . '::deleteAction');
        $app->post('/', \SocialGraph\Http\Apis\NodeController::class . '::createAction');
    });

    $app->group('/edge', function () use ($app) {
        $app->get('/{id}', \SocialGraph\Http\Apis\EdgeController::class . '::getAction');
        $app->delete('/{id}', \SocialGraph\Http\Apis\EdgeController::class . '::deleteAction');
        $app->post('/', \SocialGraph\Http\Apis\EdgeController::class . '::createAction');
    });
};
