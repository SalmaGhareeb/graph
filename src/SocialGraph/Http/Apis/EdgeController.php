<?php

namespace SocialGraph\Http\Apis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Application\Repository\UndirectedEdgeRepository;
use SocialGraph\Domain\Edge\UndirectedEdge;

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
     */
    public function createAction(RequestInterface $request, Response $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        /** @var \SocialGraph\Domain\Node\Node $sourceNode */
        $sourceNode      = $this->nodeRepository->find($data['source']);
        $destinationNode = $this->nodeRepository->find($data['destination']);

        $edge = new UndirectedEdge($sourceNode, $destinationNode);
        $edge->setWeight($data['weight'] ?? 1);

        $this->edgeRepository->save($edge);
        $content = $this->getSerializer()->serialize($edge, 'json');

        dd($sourceNode->getAdjacent());

        return $response->write($content)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(StatusCode::HTTP_CREATED);
    }


    public function getAction($id, Response $response): ResponseInterface
    {
        // TODO: Implement getAction() method.
    }

    public function deleteAction($id, Response $response): ResponseInterface
    {
        // TODO: Implement deleteAction() method.
    }
}
