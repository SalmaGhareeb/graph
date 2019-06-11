<?php

namespace SocialGraph\Port\Interfaces;

interface GraphInterface
{
    public function addNode(NodeInterface $node);

    public function addEdge(EdgeInterface $edge);
}