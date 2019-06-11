<?php

namespace SocialGraph\Port\Interfaces;

use SocialGraph\Domain\Node\Node;

interface AlgorithmInterface
{
    // Running the algorithm
    public function run(Node $root);

    // Getting the results of the algorithm
    public function get(): array;
}
