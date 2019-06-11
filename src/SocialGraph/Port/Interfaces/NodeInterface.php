<?php

namespace SocialGraph\Port\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

interface NodeInterface
{
    public function getGraph(): GraphInterface;

    public function getAdjacent(): array ;
}
