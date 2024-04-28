<?php

class Database {

    private static $instance;
    private $connection;

    private function __construct() 
    {

    }

    public static function getInstance() 
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect($host, $username, $password, $database)
    {
        try {
            // Connect to MySQL server
            $dsn = "mysql:host=$host";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Check if the database exists
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :database";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':database', $database);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
    
            // If the database doesn't exist, create it
            if (!$result) {
                $pdo->exec("CREATE DATABASE $database");
                echo "Database created successfully.\n";
            }
    
            // Connect to the specified database
            $dsn = "mysql:host=$host;dbname=$database";
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function customQuery($query) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error executing custom query: " . $e->getMessage();
            return false;
        }
    }

    public function paramsQuery($query, $params, $search_fields) {
        try {
                $max_limit = 50;
            
                $page = isset($params['page']) ? intval($params['page']) : 1;
                $limit = isset($params['limit']) ? intval($params['limit']) : 10;
                $order_by = isset($params['order']) ? $params['order'] : null;
                $search = isset($params['search']) ? $params['search'] : null;
            
                $filters = array_diff_key($params, array_flip(['page', 'limit', 'order', 'search']));
            
                if ($page < 1 || $limit < 1 || $limit > $max_limit) {
                    throw new Exception('Invalid pagination parameters');
                }
            
                $filter_conditions = [];
                
                if ($search && $search_fields) {
                    foreach ($search_fields as $field) {
                        $filter_conditions[] = "$field LIKE '%" . $search . "%'";
                    }
                }
                
                if ($search && !$search_fields) {
                    throw new Exception('Invalid search parameters');
                }
                
                foreach ($filters as $key => $value) {
                    $filter_conditions[] = "$key = '$value'";
                }
                
                if (!empty($filter_conditions)) {
                    $query .= " WHERE " . implode(' AND ', $filter_conditions);
                }

                if ($order_by) {
                    $query .= " ORDER BY $order_by";
                }

                $totalRecordsQuery = "SELECT COUNT(*) AS total_records FROM ($query) AS subquery";
                $statement = $this->connection->prepare($totalRecordsQuery);
                $statement->execute();
                $totalRecords = $statement->fetch(PDO::FETCH_ASSOC)['total_records'];
                
                $totalPages = ceil($totalRecords / $limit);
                $offset = ($page - 1) * $limit;
                
                $query .= " LIMIT $limit OFFSET $offset";
                
                $statement = $this->connection->prepare($query);
                $statement->execute();      
                
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                return [
                    'data' => $data,
                    'total_pages' => $totalPages,
                    'total_records' => $totalRecords,
                    'current_page' => $page
                ];

            } catch (PDOException $e) {
                echo "Error executing custom query: " . $e->getMessage();
                return false;
            }
    }

    public function insert($table, $columns, $values, $data) {
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($query);

        $values = explode(",", $values);
        $columns = explode(",", $columns);
        
        for ($i=0; $i < count($values); $i++) { 
            $statement->bindParam("$values[$i]", $data[$columns[$i]]);
        }

        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error inserting record: " . $e->getMessage();
            return false;
        }
    }

    public function select($table) {
        $query = "SELECT * FROM $table";
        $statement = $this->connection->prepare($query);

        try {
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result;
            } else {
                echo "No users found yet.";
            }
        } catch (PDOException $e) {
            echo "Error selecting records: " . $e->getMessage();
        }
    }

    public function update($table, $id, $fields, $keys, $values) {
        $query = "UPDATE $table SET $fields WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $columns = explode(",", $keys);

        for ($i=0; $i < count($columns); $i++) { 
            if ($columns[$i] === "room") {
                $statement->bindParam($columns[$i], $values[$i], PDO::PARAM_INT);
            }
            $statement->bindParam($columns[$i], $values[$i], PDO::PARAM_STR);
        }

        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
            return false;
        }
    }

    public function delete($table, $id) {
        $query = "DELETE FROM $table WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $statement->execute();
            echo "Record deleted successfully.";
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
        }
    }

}

?>

