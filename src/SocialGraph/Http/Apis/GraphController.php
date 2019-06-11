<?php

namespace SocialGraph\Http\Apis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use SocialGraph\Application\Repository\GraphRepository;
use SocialGraph\Domain\Graph\Graph;
use SocialGraph\Port\Exception\NotFoundException;

/**
 * Class GraphController
 *
 * @package SocialGraph\Http\Apis
 */
class GraphController extends ApiController
{
    protected $graphRepository;

    public function __construct(GraphRepository $graphRepository)
    {
        $this->graphRepository = $graphRepository;
    }

    /**
     * @param RequestInterface    $request
     * @param \Slim\Http\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAction(RequestInterface $request, Response $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        if (isset($data['name']) && $data['name']) {
            $graph = new Graph();
            $graph->setName($data['name']);
            $this->graphRepository->save($graph);
            $data = $graph->toArray();

            return $response
                ->withJson($data)
                ->withStatus(StatusCode::HTTP_CREATED);
        }

        return $response->withJson([], StatusCode::HTTP_BAD_REQUEST);
    }

    /**
     * @param                     $id
     * @param \Slim\Http\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function getAction($id, Response $response): ResponseInterface
    {
        $graph = $this->graphRepository->find($id);
        if (!$graph) {
            throw new NotFoundException();
        }


        return $response->withJson($graph->toArray())
                        ->withStatus(StatusCode::HTTP_OK);
    }

    /**
     * @param                     $id
     * @param \Slim\Http\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function deleteAction($id, Response $response): ResponseInterface
    {
        $graph = $this->graphRepository->find($id);
        if (!$graph) {
            throw new NotFoundException();
        }
        $this->graphRepository->delete($graph);

        return $response->withJson([], StatusCode::HTTP_OK);
    }

    /**
     * @param                                     $id
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function getGraphNodesAction($id, ResponseInterface $response): ResponseInterface
    {
        /** @var Graph $graph */
        $graph = $this->graphRepository->find($id);
        if (!$graph) {
            throw new NotFoundException();
        }

        $nodes = $this->getSerializer()->serialize($graph->getNodes(), 'json');

        return $response->write($nodes)->withHeader('Content-Type', 'application/json');
    }
}
