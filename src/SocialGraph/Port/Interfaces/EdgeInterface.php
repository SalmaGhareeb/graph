<?php

namespace SocialGraph\Port\Interfaces;

interface EdgeInterface
{

    /**
     * @param \SocialGraph\Port\Interfaces\NodeInterface $from
     * @param \SocialGraph\Port\Interfaces\NodeInterface $to
     *
     * @return bool
     */
    public function isConnection(NodeInterface $from, NodeInterface $to): bool;

    /**
     * @return bool
     */
    public function isLoop(): bool;

    public function getDestination();
}