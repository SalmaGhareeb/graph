<?php

namespace SocialGraph\Application\Service;

use SocialGraph\Application\Algorithms\BFSearch;
use SocialGraph\Application\Algorithms\DepthFirstSearch;
use SocialGraph\Application\Repository\GraphRepository;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Port\Exception\NotFoundException;

/**
 * Class AlgorithmsService
 *
 * @package SocialGraph\Application\Service
 */
class AlgorithmsService
{
    private $graphRepository;
    private $nodeRepository;

    /**
     * AlgorithmsService constructor.
     *
     * @param \SocialGraph\Application\Repository\GraphRepository $graphRepository
     * @param \SocialGraph\Application\Repository\NodeRepository  $nodeRepository
     */
    public function __construct(GraphRepository $graphRepository, NodeRepository $nodeRepository)
    {
        $this->graphRepository = $graphRepository;
        $this->nodeRepository  = $nodeRepository;
    }

    /**
     * @param string $graphName
     * @param string $root
     *
     * @return array
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
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

        return $search->get();
    }

    /**
     * @param string $graphName
     * @param string $root
     *
     * @return array
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function runBreadthFirstSearch(string $graphName, string $root): array
    {
        $graph = $this->graphRepository->findOneByName($graphName);
        if (!$graph) {
            throw new NotFoundException('Graph not found!');
        }

        $rootNode = $this->nodeRepository->findOneByName($root);

        if (!$rootNode) {
            throw new NotFoundException('Node not found!');
        }

        $search = new BFSearch($graph);
        $search->run($rootNode);

        return $search->get();
    }
}