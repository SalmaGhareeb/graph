<?php

namespace SocialGraph\Port\Interfaces;

interface RepositoryInterface
{
    public function save(ModelInterface $model): void;
    public function delete(ModelInterface $model): void;
}
