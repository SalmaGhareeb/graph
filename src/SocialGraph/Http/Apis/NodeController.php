<?php

namespace SocialGraph\Http\Apis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use SocialGraph\Application\Repository\GraphRepository;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Domain\Node\Node;
use SocialGraph\Port\Exception\NotFoundException;

/**
 * Class NodeController
 *
 * @package SocialGraph\Http\Apis
 */
class NodeController extends ApiController
{
    protected $nodeRepository;

    protected $graphRepository;

    public function __construct(NodeRepository $nodeRepository, GraphRepository $graphRepository)
    {
        $this->nodeRepository  = $nodeRepository;
        $this->graphRepository = $graphRepository;
    }


    /**
     * @param RequestInterface    $request
     * @param \Slim\Http\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function createAction(RequestInterface $request, Response $response): ResponseInterface
    {
        $data = $request->getParsedBody();

        $graph = $this->graphRepository->find($data['graph']);
        if (!$graph) {
            throw new NotFoundException('Graph not found!');
        }

        $node = new Node($graph);
        $node->setName($data['name']);
        $node->setAttributes($data['meta']);
        $this->nodeRepository->save($node);
        $content = $this->getSerializer()->serialize($node, 'json');

        return $response->write($content)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(StatusCode::HTTP_CREATED);
    }

    /**
     * @param                     $id
     * @param \Slim\Http\Response $response
     *
     * @return \Slim\Http\Response
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function getAction($id, Response $response): ResponseInterface
    {
        $model = $this->nodeRepository->find($id);
        if (!$model) {
            throw new NotFoundException();
        }

        $data = $this->getSerializer()->serialize($model, 'json');

        return $response->write($data)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(StatusCode::HTTP_OK);
    }

    /**
     * @param                     $id
     * @param \Slim\Http\Response $response
     *
     * @return \Slim\Http\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function deleteAction($id, Response $response): ResponseInterface
    {
        $model = $this->nodeRepository->find($id);
        if (!$model) {
            throw new NotFoundException();
        }

        $this->nodeRepository->delete($model);

        return $response->withJson([], StatusCode::HTTP_OK);
    }
}
