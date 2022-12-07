<?php

class Database {
    private  $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private PDOStatement|false $statement;
    private PDO $dbHandler;
    private string $error;

    public function __construct() {
        $dbHost = $this->dbHost;
        $dbName = $this->dbName;

        $conn = "mysql:host=${dbHost};dbname=${dbName}";
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $connection = new PDO($conn, $this->dbUser, $this->dbPass, $options);
            
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->dbHandler = $connection;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // allows us to write queries
    public function prepare(string $sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
        return $this->statement;
    }
    // bind values
    public function bind(string $parameter, $value)
    {
        $value_t = gettype($value);
        $type = PDO::PARAM_STR;
        switch ($value_t) {
            case "integer":
                $type = PDO::PARAM_INT;
                break;
            case "boolean":
                $type = PDO::PARAM_BOOL;
                break;
            case "NULL":
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        return $this->statement->bindValue($parameter, $value, $type);
    }


    // execute the prepared statement
    public function execute(array|null $params = null)
    {
        return $this->statement->execute($params);
    }

    public function resultSet()
    {
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    // return a specific row as an object
    public function single()
    {
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    // get the row count
    public function rowCount() {
        return $this->statement->rowCount();
    }
    // https://medium.com/an-idea/php-pdo-lastinsertid-method-with-examples-in-mysql-f6d649c92aa
    public function lastInsertId() {
        return $this->dbHandler->lastInsertId();
    }

    public function get_statement()
    {
        return $this->statement;
    }
}
class User
{
    public int $id;
    public string $firstname;
    public string  $username;
    public string $password;
    public string $lastname;
    public string $role;
    public string $level;
    public function __construct(int $id, string $firstname, string  $username, string $password, string $lastname, string $role, string $level)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->username = $username;
        $this->password = $password;
        $this->lastname = $lastname;
        $this->role = $role;
        $this->level = $level;
    }
}

?>