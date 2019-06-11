<?php


namespace SocialGraph\Domain\Edge;

use Doctrine\ORM\Mapping as ORM;
use SocialGraph\Port\Interfaces\NodeInterface;

/**
 * Class DirectedEdge
 *
 * @package SocialGraph\Domain\Edge
 * @ORM\Entity(repositoryClass="SocialGraph\Application\Repository\DirectedEdge")
 */
class DirectedEdge extends Edge
{
    public function isConnection(NodeInterface $from, NodeInterface $to): bool
    {
        return ($this->source === $from && $this->destination === $to);
    }
}
