<?php

class DB
{
    private $pdo;

    private static $instance = null;
    // Constructor that initializes the database connection
    public function __construct()
    {
        // Load the config file
        $config = require __DIR__ . '/config.php';

        // Get the database connection info from the config array
        $host     = $config['DB_HOST'];
        $port     = $config['DB_PORT'];
        $dbname   = $config['DB_DATABASE'];
        $username = $config['DB_USERNAME'];
        $password = $config['DB_PASSWORD'];

        // Create a DSN (Data Source Name) for PDO
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

        try {
            // Create a new PDO instance
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Static method to get the instance of the DB class
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    // Generalized query method to handle all queries (SELECT, INSERT, UPDATE, DELETE)
    public function query($sql, $params = [], $fetch = true)
    {
        try {
            // Prepare the SQL statement
            $stmt = $this->pdo->prepare($sql);

            // Execute the query with the provided parameters
            $stmt->execute($params);

            // If fetching results (for SELECT queries), return the results
            if ($fetch) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // For non-fetch queries (INSERT, UPDATE, DELETE), return true if successful
            return true;
        } catch (PDOException $e) {
            // Handle any query errors
            die("Query failed: " . $e->getMessage());
        }
    }

    // Get PDO instance if needed
    public function getPDO()
    {
        return $this->pdo;
    }
}
