<?php

require_once './db/db_class.php';
require_once './config/db_info.php';

class User {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    function createUsersTable()
    {

        try {
            $query = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                is_admin BOOLEAN NOT NULL,
                image VARCHAR(255) NOT NULL
            )";

        $this->db->customQuery($query);

        } catch (PDOException $e) {
            die("Error creating users table: " . $e->getMessage());
        }
    }

}

$user = new User();

$user->createUsersTable();
