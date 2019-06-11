<?php

namespace SocialGraph\Domain\Edge;

use Doctrine\ORM\Mapping as ORM;
use SocialGraph\Port\Interfaces\EdgeInterface;
use SocialGraph\Port\Interfaces\GraphInterface;
use SocialGraph\Port\Interfaces\ModelInterface;
use SocialGraph\Port\Interfaces\NodeInterface;

/**
 * Class Node
 *
 * @package SocialGraph\Domain
 * @ORM\Table(name="edge")
 * @ORM\Entity()
 * @ORM\MappedSuperclass()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="directed", type="integer")
 * @ORM\DiscriminatorMap({"0" = "SocialGraph\Domain\Edge\UndirectedEdge", "1"= "SocialGraph\Domain\Edge\DirectedEdge"})
 */
abstract class Edge implements EdgeInterface, ModelInterface
{
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="SocialGraph\Domain\Node\Node", inversedBy="edges")
     */
    protected $source;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="SocialGraph\Domain\Node\Node")
     */
    protected $destination;

    /**
     * @var
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * weight of this edge
     *
     * @var int|NULL
     * @see self::getWeight()
     *
     * @ORM\Column(type="integer")
     */
    protected $weight;

    /**
     * @var \SocialGraph\Port\Interfaces\GraphInterface $graph
     * @ORM\ManyToOne(targetEntity="SocialGraph\Domain\Graph\Graph",inversedBy="edges", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(fieldName="graph_id", onDelete="CASCADE")
     */
    protected $graph;

    /**
     * @return \SocialGraph\Port\Interfaces\GraphInterface
     */
    public function getGraph(): GraphInterface
    {
        return $this->graph;
    }

    /**
     * @param \SocialGraph\Port\Interfaces\GraphInterface $graph
     */
    public function setGraph(GraphInterface $graph)
    {
        $this->graph = $graph;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return int|NULL
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param int|NULL $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @param \SocialGraph\Port\Interfaces\NodeInterface $from
     * @param \SocialGraph\Port\Interfaces\NodeInterface $to
     *
     * @return bool
     */
    abstract public function isConnection(NodeInterface $from, NodeInterface $to): bool;

    /**
     * returns whether this edge is actually a loop
     *
     * @return boolean
     */
    public function isLoop(): bool
    {
        return ($this->source === $this->destination);
    }
}
