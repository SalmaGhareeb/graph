<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use SocialGraph\Application\Repository\GraphRepository;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Application\Repository\UndirectedEdgeRepository;

$settings = require __DIR__ . '/settings.php';

return array_merge([
    EntityManager::class            => static function () use ($settings) : EntityManager {
        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['doctrine']['metadata_dirs'],
            $settings['doctrine']['dev_mode']
        );

        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader,
                $settings['doctrine']['metadata_dirs']
            )
        );

        return EntityManager::create(
            $settings['doctrine']['connection'],
            $config
        );
    },
    GraphRepository::class          => DI\factory(function (\DI\Container $c) {
        $em = $c->get(EntityManager::class);

        return $em->getRepository(\SocialGraph\Domain\Graph\Graph::class);
    }),
    NodeRepository::class           => DI\factory(function (\DI\Container $c) {
        $em = $c->get(EntityManager::class);

        return $em->getRepository(\SocialGraph\Domain\Node\Node::class);
    }),
    UndirectedEdgeRepository::class => DI\factory(function (\DI\Container $c) {
        $em = $c->get(EntityManager::class);

        return $em->getRepository(\SocialGraph\Domain\Edge\UndirectedEdge::class);
    }),
], $settings);
