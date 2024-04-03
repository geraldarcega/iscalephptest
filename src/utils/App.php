<?php

namespace App\Utils;

use Dotenv\Dotenv;
use App\Utils\Config;

class App
{
    private static DB $db;
    private Config $config;

    /**
     * Initiate static instance of DB class
     *
     * @return DB
     */
    public static function db(): DB
    {
        return static::$db;
    }

    /**
     * Boot application
     *
     * @return static
     */
    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->config = new Config($_ENV);
        static::$db = new DB($this->config->db ?? []);

        return $this;
    }
}
