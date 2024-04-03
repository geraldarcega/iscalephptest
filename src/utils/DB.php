<?php

namespace App\Utils;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class DB
{
    private Connection $connection;
    public EntityManager $entityManager;

    /**
     * Setup DB configuration and connection
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $paths = ['./src/Entity'];
        $isDevMode = true;

        $setup = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $this->connection = DriverManager::getConnection($config, $setup);
        $this->entityManager = new EntityManager($this->connection, $setup);
    }

    public function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}