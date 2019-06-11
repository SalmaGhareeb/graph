<?php

namespace SocialGraph\Domain\Graph;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SocialGraph\Port\Interfaces\ArrayExpressibleInterface;
use SocialGraph\Port\Interfaces\EdgeInterface;
use SocialGraph\Port\Interfaces\GraphInterface;
use SocialGraph\Port\Interfaces\ModelInterface;
use SocialGraph\Port\Interfaces\NodeInterface;

/**
 * Class Graph
 * @ORM\Entity(repositoryClass="SocialGraph\Application\Repository\GraphRepository")
 * @ORM\Table(name="graph")
 *
 * @package SocialGraph\Domain\Graph
 */
class Graph implements GraphInterface, ModelInterface, ArrayExpressibleInterface
{
    /**
     * @var
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @\Doctrine\ORM\Mapping\Column(name="name", type="string", unique=true)
     */
    private $name;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="SocialGraph\Domain\Node\Node", mappedBy="graph", cascade={"remove"},
     *     orphanRemoval=true)
     */
    protected $nodes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="SocialGraph\Domain\Edge\Edge", mappedBy="graph", cascade={"remove"},
     *     orphanRemoval=true)
     */
    protected $edges;


    public function __construct()
    {
        $this->edges = new ArrayCollection();
        $this->nodes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->nodes->toArray();
    }

    /**
     * @param mixed $nodes
     */
    public function setNodes($nodes): void
    {
        $this->nodes = $nodes;
    }

    public function addNode(NodeInterface $node): void
    {
        $this->nodes->add($node);
    }

    /**
     * @return ArrayCollection
     */
    public function getEdges(): ArrayCollection
    {
        return $this->edges;
    }

    /**
     * @param mixed $edges
     */
    public function setEdges($edges): void
    {
        $this->edges = $edges;
    }

    public function addEdge(EdgeInterface $edge): void
    {
        $this->edges->add($edge);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param $node
     */
    public function removeNode($node): void
    {
        if (!$this->nodes->contains($node)) {
            return;
        }
        $this->nodes->removeElement($node);
    }

    /**
     * @param $edge
     */
    public function removeEdge($edge): void
    {
        if (!$this->edges->contains($edge)) {
            return;
        }
        $this->edges->removeElement($edge);
    }


    public function toArray()
    {
        return get_object_vars($this);
    }
}
