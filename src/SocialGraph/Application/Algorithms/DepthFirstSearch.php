<?php

namespace SocialGraph\Application\Algorithms;

use SocialGraph\Domain\Node\Node;

class DepthFirstSearch extends Algorithm
{
    /**
     * @param \SocialGraph\Domain\Node\Node $root
     */
    public function run(Node $root): void
    {
        $this->discovered             = [];
        $stack                        = new \SplStack();
        $this->dist[$root->getName()] = 0;
        $stack->push($root);
        while (!$stack->isEmpty()) {
            /** @var \SocialGraph\Domain\Node\Node $current */
            $current = $stack->pop();
            if (!in_array($current->getName(), $this->discovered, false)) {
                $this->discovered[] = $current->getName();

                $adjacentList = $current->getAdjacent();
                /** @var Node $node */
                foreach ($adjacentList as $node) {
                    $nodeName = $node->getName();
                    if (!isset($this->dist[$nodeName])) {
                        $this->dist[$nodeName]   = $this->dist[$current->getName()] + 1;
                        $this->parent[$nodeName] = $current->getName();
                        $stack->push($node);
                    }
                }
            }
        }
    }
}
