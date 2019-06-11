<?php

namespace SocialGraph\Domain\Edge;

use Doctrine\ORM\Mapping as ORM;
use http\Exception\InvalidArgumentException;
use SocialGraph\Port\Interfaces\NodeInterface;

/**
 * Class UndirectedEdge
 * @ORM\Entity(repositoryClass="SocialGraph\Application\Repository\UndirectedEdgeRepository")
 *
 * @package SocialGraph\Domain\Edge
 */
class UndirectedEdge extends Edge
{

    public function __construct(NodeInterface $source, NodeInterface $destination)
    {
        if ($source->getGraph() !== $destination->getGraph()) {
            throw new InvalidArgumentException('Nodes have to be within the same graph');
        }
        $this->source      = $source;
        $this->destination = $destination;
        $destination->getGraph()->addEdge($this);
    }

    /**
     * @param \SocialGraph\Port\Interfaces\NodeInterface $from
     * @param \SocialGraph\Port\Interfaces\NodeInterface $to
     *
     * @return bool
     */
    public function isConnection(NodeInterface $from, NodeInterface $to): bool
    {
        return (($this->source === $from && $this->destination === $to) ||
                ($this->destination === $from && $this->source === $to));
    }
}
