<?php

require_once './config/db_info.php';

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
            // Prepare the query
            $statement = $this->connection->prepare($query);

            // Execute the query
            $statement->execute();

            // Fetch the result
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Return the result
            return $result;
        } catch (PDOException $e) {
            // Handle any exceptions
            echo "Error executing custom query: " . $e->getMessage();
            return false;
        }
    }

    public function paramsQuery($query, $params, $search_fields) {
        try {
                $max_limit = 50;
                // var_dump($params);
            
                $page = isset($params['page']) ? intval($params['page']) : 1;
                $limit = isset($params['limit']) ? intval($params['limit']) : 10;
                $order_by = isset($params['order']) ? $params['order'] : null;
                $search = isset($params['search']) ? $params['search'] : null;
            
                $filters = array_diff_key($params, array_flip(['page', 'limit', 'order', 'search']));
            
                if ($page < 1 || $limit < 1 || $limit > $max_limit) {
                    // Handle invalid pagination parameters
                    throw new Exception('Invalid pagination parameters');
                }
            
                $filter_conditions = [];
            
                if ($search && $search_fields) {
                    foreach ($search_fields as $field) {
                        $filter_conditions[] = "$field LIKE '%" . $search . "%'";
                    }
                }
            
                if ($search && !$search_fields) {
                    // Handle invalid search parameters
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
            

            // Count total records
            $totalRecordsQuery = "SELECT COUNT(*) AS total_records FROM ($query) AS subquery";
            $statement = $this->connection->prepare($totalRecordsQuery);
            $statement->execute();
            $totalRecords = $statement->fetch(PDO::FETCH_ASSOC)['total_records'];
    
            // Calculate total pages
            $totalPages = ceil($totalRecords / $limit);
    
            // Calculate offset
            $offset = ($page - 1) * $limit;
    
            // Add LIMIT and OFFSET to the original query
            $query .= " LIMIT $limit OFFSET $offset";
    
            // Execute the query
            $statement = $this->connection->prepare($query);
            $statement->execute();
    
            // Fetch the data
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            // Return the data along with pagination information
            return [
                'data' => $data,
                'total_pages' => $totalPages,
                'total_records' => $totalRecords,
                'current_page' => $page
            ];
        } catch (PDOException $e) {
            // Handle any exceptions
            echo "Error executing custom query: " . $e->getMessage();
            return false;
        }
    }
// ====================================================

    public function insert($table, $columns, $values) {
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($query);

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

    public function update($table, $id, $fields) {
        $query = "UPDATE $table SET $fields WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

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

    public function getAllUsers()
    {
        $query = "SELECT * FROM users";

        try
        {
            $statement = $this->connection->prepare($query);
            $res = $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
        catch(PDOException $e)
        {
            return "Error";
        }
    }

    public function findOneUser($email,$password)
    {
        $query = "SELECT * FROM users WHERE email= :email AND password= :password";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':email',$email);
        $statement->bindParam(':password',$password);

        try
        {
            $statement->execute();
            if($statement->rowCount() == 1)
            {
                echo "User found!";
                return true;
            }
            echo "User not found!";
            return false;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id',$id);

        try
        {
            $statement->execute();
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        }   
        catch (PDOException)
        {
            return "Error";
        }
    }
    
    public function __destruct() {
        $this->connection = null;
    }

}

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// $database->select(DB_TABLE);

// $database->insert(DB_TABLE,"name,password,email,room_number", "'Mohamed','123','Mohamed@gmail.com','Application1'");

// $database->update(DB_TABLE,7,"name='hamada',password='1234',room_number='Cloud'");

// $database->delete(DB_TABLE,7);

// $database->findOneUser('AhmedAli117@gmail.com','123');

?>

