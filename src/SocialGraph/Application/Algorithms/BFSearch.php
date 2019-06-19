<?php

namespace SocialGraph\Application\Algorithms;

use SocialGraph\Domain\Node\Node;

class BFSearch extends Algorithm
{
    /**
     * @param \SocialGraph\Domain\Node\Node $root
     */
    public function run(Node $root): void
    {
        $this->discovered             = [];
        $queue                        = new \SplQueue();
        $this->dist[$root->getName()] = 0;
        $queue->enqueue($root);
        while (!$queue->isEmpty()) {
            $current            = $queue->dequeue();
            $this->discovered[] = $current->getName();
            $adjacentList       = $current->getAdjacent();
            /** @var Node $node */
            foreach ($adjacentList as $node) {
                if (!isset($this->dist[$node->getName()])) {
                    $this->dist[$node->getName()]   = $this->dist[$current->getName()] + 1;
                    $this->parent[$node->getName()] = $current->getName();
                    $queue->enqueue($node);
                }
            }
        }
    }
}
