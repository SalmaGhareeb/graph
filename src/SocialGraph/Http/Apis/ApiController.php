<?php

namespace SocialGraph\Http\Apis;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

abstract class ApiController
{
    abstract public function createAction(RequestInterface $request, Response $response): ResponseInterface;

    abstract public function getAction($id, Response $response): ResponseInterface;

    abstract public function deleteAction($id, Response $response): ResponseInterface;

    /**
     * @return \JMS\Serializer\SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return SerializerBuilder::create()->build();
    }
}
