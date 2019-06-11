<?php

namespace SocialGraph\Application\Service;

use SocialGraph\Application\Algorithms\DepthFirstSearch;
use SocialGraph\Application\Repository\GraphRepository;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Port\Exception\NotFoundException;

class AlgorithmsService
{

    private $graphRepository;
    private $nodeRepository;

    public function __construct(GraphRepository $graphRepository, NodeRepository $nodeRepository)
    {
        $this->graphRepository = $graphRepository;
        $this->nodeRepository  = $nodeRepository;
    }

    public function runDepthFirstSearch(string $graphName, string $root): array
    {
        $graph = $this->graphRepository->findOneByName($graphName);
        if (!$graph) {
            throw new NotFoundException('Graph not found!');
        }

        $rootNode = $this->nodeRepository->findOneByName($root);

        if (!$rootNode) {
            throw new NotFoundException('Node not found!');
        }
        
        $search = new DepthFirstSearch($graph);
        $search->run($rootNode);

        return $search->get([]);
    }
}