<?php

namespace Tests\Application\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Mockery;
use PHPUnit\Framework\TestCase;
use SocialGraph\Application\Repository\GraphRepository;
use SocialGraph\Application\Repository\NodeRepository;
use SocialGraph\Application\Service\AlgorithmsService;
use SocialGraph\Domain\Edge\UndirectedEdge;
use SocialGraph\Domain\Graph\Graph;
use SocialGraph\Domain\Node\Node;
use SocialGraph\Port\Exception\NotFoundException;

class AlgorithmsServiceTest extends TestCase
{
    private $algorithmService;

    private $nodeRepository;
    private $graphRepository;

    public function __construct()
    {
        $this->nodeRepository  = Mockery::mock(NodeRepository::class);
        $this->graphRepository = Mockery::mock(GraphRepository::class);

        $this->algorithmService = new AlgorithmsService($this->graphRepository, $this->nodeRepository);

        parent::__construct();
    }

    /**
     * @throws \SocialGraph\Port\Exception\InvalidArgumentException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function testRunBreadthFirstSearch(): void
    {
        $graph = $this->getGraph();

        $this->graphRepository->allows('findOneByName')
                              ->with('test')
                              ->andReturn($graph);

        $this->nodeRepository->allows('findOneByName')
                             ->with('A')
                             ->andReturn($graph->getNodes()[0]);

        $result = $this->algorithmService->runBreadthFirstSearch('test', 'A');
        $this->assertIsArray($result);
        $this->assertSame([
            'A' => 0,
            'B' => 1,
            'C' => 1,
            'E' => 2,
            'D' => 2,
            'F' => 3,
        ], $result['dist']);

        $this->assertSame([
            'A',
            'B',
            'C',
            'E',
            'D',
            'F',
        ], $result['discovered']);
    }


    /**
     * @throws \SocialGraph\Port\Exception\InvalidArgumentException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function testRunDepthFirstSearch(): void
    {
        $graph = $this->getGraph();

        $this->graphRepository->allows('findOneByName')
                              ->with('test')
                              ->andReturn($graph);

        $this->nodeRepository->allows('findOneByName')
                             ->with('A')
                             ->andReturn($graph->getNodes()[0]);

        $result = $this->algorithmService->runDepthFirstSearch('test', 'A');

        $this->assertIsArray($result);

        $this->assertSame([
            'A' => 0,
            'B' => 1,
            'C' => 1,
            'E' => 2,
            'F' => 3,
            'D' => 2,
        ], $result['dist']);

        $this->assertSame([
            'A',
            'C',
            'E',
            'F',
            'B',
            'D',
        ], $result['discovered']);
    }

    /**
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function testNotFoundGraph(): void
    {
        $this->expectException(NotFoundException::class);
        $this->graphRepository->allows('findOneByName')
                              ->andReturnNull();

        $this->algorithmService->runDepthFirstSearch('test', 'A');
    }

    /**
     * @throws \SocialGraph\Port\Exception\InvalidArgumentException
     * @throws \SocialGraph\Port\Exception\NotFoundException
     */
    public function testNotFoundNode(): void
    {
        $this->expectException(NotFoundException::class);
        $this->graphRepository->allows('findOneByName')
                              ->with('test')
                              ->andReturn($this->getGraph());

        $this->nodeRepository->allows('findOneByName')->andReturnNull();

        $this->algorithmService->runDepthFirstSearch('test', 'A');
    }


    /**
     * @return \SocialGraph\Domain\Graph\Graph
     * @throws \SocialGraph\Port\Exception\InvalidArgumentException
     */
    private function getGraph(): Graph
    {
        $graph = new Graph();
        $graph->setName('test');
        $nodes = new ArrayCollection();
        $edges = new ArrayCollection();

        $A = new Node($graph);
        $A->setName('A');
        $nodes->add($A);
        $B = new Node($graph);
        $B->setName('B');
        $nodes->add($B);
        $C = new Node($graph);
        $C->setName('C');
        $nodes->add($C);
        $D = new Node($graph);
        $D->setName('D');
        $nodes->add($D);
        $E = new Node($graph);
        $E->setName('E');
        $nodes->add($E);
        $F = new Node($graph);
        $F->setName('F');
        $nodes->add($F);

        $edge = new UndirectedEdge($A, $B);
        $edges->add($edge);
        $A->addEdge($edge);
        $B->addEdge($edge);

        $edge = new UndirectedEdge($A, $C);
        $edges->add($edge);
        $A->addEdge($edge);
        $C->addEdge($edge);

        $edge = new UndirectedEdge($B, $E);
        $edges->add($edge);
        $B->addEdge($edge);
        $E->addEdge($edge);

        $edge = new UndirectedEdge($B, $D);
        $edges->add($edge);
        $B->addEdge($edge);
        $D->addEdge($edge);

        $edge = new UndirectedEdge($C, $E);
        $edges->add($edge);
        $C->addEdge($edge);
        $E->addEdge($edge);

        $edge = new UndirectedEdge($E, $F);
        $edges->add($edge);
        $F->addEdge($edge);
        $E->addEdge($edge);

        $edge = new UndirectedEdge($D, $F);
        $edges->add($edge);
        $F->addEdge($edge);
        $D->addEdge($edge);

        $graph->setEdges($edges);
        $graph->setNodes($nodes);

        return $graph;
    }
}
