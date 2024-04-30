<?php

require_once './db/db_class.php';
require_once './config/db_info.php';

class Room
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    function createRoomsTable()
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS rooms (
                name VARCHAR(255) NOT NULL PRIMARY KEY
            )";

            $this->db->customQuery($query);
        } catch (PDOException $e) {
            die("Error creating users table: " . $e->getMessage());
        }
    }
}

$room = new Room();
$room->createRoomsTable();
