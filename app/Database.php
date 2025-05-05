<?php
/**
 * Database class for handling database connections
 */
class Database
{
    private static $instance = null;
    private $connection = null;

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        try {
            $config = require __DIR__ . '/config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $this->connection = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (Exception $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please check your configuration.");
        }
    }

    /**
     * Get the singleton instance
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the database connection
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone() {}

    /**
     * Prevent unserializing of the instance
     */
    public function __wakeup() {}
}
