<?php

namespace SocialGraph\Application\Algorithms;

use SocialGraph\Domain\Graph\Graph;
use SocialGraph\Port\Interfaces\AlgorithmInterface;

abstract class Algorithm implements AlgorithmInterface
{
    /**
     * Reference to the graph.
     *
     * @var Graph
     */
    public $graph;
    /**
     * Distances for each node to root in hops.
     *
     * @var array
     */

    public $dist;
    /**
     * Parents for each vertex.
     *
     * @var array
     */
    public $parent;
    /**
     *
     * @var array
     */
    public $discovered;

    /**
     * Constructor for the DFS algorithm.
     *
     * @param Graph $graph The graph to which the DFS algorithm should be applied
     */
    public function __construct(Graph $graph)
    {
        $this->graph      = &$graph;
        $this->discovered = [];
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'dist'       => $this->dist,
            'parent'     => $this->parent,
            'discovered' => $this->discovered,
        ];
    }
}
