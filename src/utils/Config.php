<?php

namespace App\Utils;

/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config = [];

    /**
     * Set environment configuration with key value pair
     *
     * @param array $env
     */
    public function __construct(array $env)
    {
        $this->config = [
            'db'     => [
                'host'     => $env['DB_HOST'],
                'user'     => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD'],
                'dbname'   => $env['DB_DATABASE'],
                'driver'   => $env['DB_DRIVER'] ?? 'pdo_mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
