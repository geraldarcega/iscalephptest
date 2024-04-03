<?php

namespace App;

use App\Utils\DB;
use PDOStatement;
use App\Utils\App;

abstract class Model
{
    protected DB $db;
    protected string $entity;

    public function __construct()
    {
        $this->db = App::db();
    }

    /**
     * Find an entity by ID
     *
     * @param integer $id
     */
    public function find(int $id)
    {
        if (!$this->entity) {
            throw new \Exception('No entity configured in the model class');
        }

        return $this->db
            ->entityManager()
            ->find($this->entity, $id);
    }

    /**
     * Get all entity result
     *
     * @return array
     */
    public abstract function all(): array;
}
