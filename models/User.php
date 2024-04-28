<?php

require_once 'db/db_class.php';
require_once 'config/db_info.php';

class User
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    function createUsersTable()
    {

        try {
            $query = "CREATE TABLE IF NOT EXISTS users (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(40) NOT NULL,
                    `email` varchar(40) NOT NULL,
                    `password` varchar(50) NOT NULL,
                    `room` int(11) NOT NULL,
                    `ext` varchar(20) NOT NULL,
                    `profile` longblob NOT NULL,
                    `is_admin` tinyint(1) NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
            )";

            $this->db->customQuery($query);
        } catch (PDOException $e) {
            die("Error creating users table: " . $e->getMessage());
        }
    }
}

$user = new User();

$user->createUsersTable();
