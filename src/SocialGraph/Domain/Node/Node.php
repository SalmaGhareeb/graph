<?php

namespace SocialGraph\Domain\Node;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SocialGraph\Port\Interfaces\ArrayExpressibleInterface;
use SocialGraph\Port\Interfaces\EdgeInterface;
use SocialGraph\Port\Interfaces\GraphInterface;
use SocialGraph\Port\Interfaces\ModelInterface;
use SocialGraph\Port\Interfaces\NodeInterface;

/**
 * Class Node
 *
 * @package SocialGraph\Domain
 * @ORM\Entity(repositoryClass="SocialGraph\Application\Repository\NodeRepository")
 * @ORM\Table(name="`node`")
 */
class Node implements NodeInterface, ModelInterface, ArrayExpressibleInterface
{
    /**
     * @var
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @var \SocialGraph\Port\Interfaces\GraphInterface $graph
     * @ORM\ManyToOne(targetEntity="SocialGraph\Domain\Graph\Graph",inversedBy="nodes")
     * @ORM\JoinColumn(fieldName="graph_id")
     */
    private $graph;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $attributes = [];

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SocialGraph\Domain\Edge\Edge", mappedBy="source")
     */
    private $edges;


    public function __construct(GraphInterface $graph)
    {
        $this->graph = $graph;
        $this->edges = new ArrayCollection();
        $graph->addNode($this);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

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
    public function setGraph(GraphInterface $graph): void
    {
        $this->graph = $graph;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getAdjacent(): array
    {
        return $this->edges->map(function (EdgeInterface $edge) {
            return $edge->getDestination();
        })->toArray();
    }

    /**
     * @return ArrayCollection
     */
    public function getEdges(): ArrayCollection
    {
        return $this->edges;
    }

    /**
     * @param ArrayCollection $edges
     */
    public function setEdges($edges): void
    {
        $this->edges = $edges;
    }

    public function addEdge(EdgeInterface $edge): void
    {
        $this->edges->add($edge);
    }
}
