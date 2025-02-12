<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'id17597613_user_k');
define('DB_PASS', 'Rohil21@Kashie13');
define('DB_NAME', 'id17597613_kashie');

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        
        $this->connection->set_charset("utf8mb4");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new Exception("Query failed: " . $this->connection->error);
        }
        return $result;
    }

    public function prepare($sql) {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }
        return $stmt;
    }

    public function escape($string) {
        return $this->connection->real_escape_string($string);
    }
}

// Helper functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function json_response($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Error handling
function handleError($errno, $errstr, $errfile, $errline) {
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    if (ini_get('display_errors')) {
        echo "An error occurred. Please try again later.";
    }
    return true;
}

set_error_handler('handleError');
?>
