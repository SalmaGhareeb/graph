<?php

namespace SocialGraph\Http\Apis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Application\Repository\UndirectedEdgeRepository;
use SocialGraph\Domain\Edge\UndirectedEdge;
use SocialGraph\Port\Exception\NotFoundException;

class EdgeController extends ApiController
{

    protected $edgeRepository;
    protected $nodeRepository;

    public function __construct(UndirectedEdgeRepository $edgeRepository, NodeRepository $nodeRepository)
    {
        $this->edgeRepository = $edgeRepository;
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Slim\Http\Response                $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function createAction(RequestInterface $request, Response $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        /** @var \SocialGraph\Domain\Node\Node $sourceNode */
        $sourceNode      = $this->nodeRepository->find($data['source']);
        $destinationNode = $this->nodeRepository->find($data['destination']);

        if (!$sourceNode || !$destinationNode) {
            throw new NotFoundException("Node not found!");
        }

        $edge = new UndirectedEdge($sourceNode, $destinationNode);
        $edge->setWeight($data['weight'] ?? 1);

        $this->edgeRepository->save($edge);
        $content = $this->getSerializer()->serialize($edge, 'json');

        return $response->write($content)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(StatusCode::HTTP_CREATED);
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
        $model = $this->edgeRepository->find($id);
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
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function deleteAction($id, Response $response): ResponseInterface
    {
        $edge = $this->edgeRepository->find($id);
        if (!$edge) {
            throw new NotFoundException();
        }
        $this->edgeRepository->delete($edge);

        return $response->withJson([], StatusCode::HTTP_OK);
    }
}
