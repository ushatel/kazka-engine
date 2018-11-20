<?php 

namespace System; 

use System; 
use Mysqli;

class Database extends AbstractSystemFactory { 

    private static $database = null; // Database singletone 

    private const host = 'localhost:3306'; 
    private const login = 'kazka_client';
    private const pass = 'pass'; 
    private const dbName = 'kazka'; 

    private $mysqli = null; 

    public static function getDatabase() { 
        return self::$database; 
    }

    public function connect() {
        try {
            self::$database->mysqli = new mysqli(Database::host, Database::login, Database::pass, Database::dbName); 

            if(mysqli_connect_errno()) {
                print_f("Connection was not successful: ".mysqli_connect_error()); 
                exit();
            }
            //@\mysqli_connect('localhost:3306', Database::login, Database::pass, Database::dbName);
        //echo self::$database->mysqli::$server_version; 

        //self::$database->mysqli = new \PDO("mysql:host=localhost;dbname=kazka", Database::login, Database::pass);
        //var_dump(self::$database->mysqli);
            
        }
        catch( Exception $ex ) {
            echo $ex->getMessage();
        }
    }

    public function storeObject(DatabaseEntity $entity): int {
        return $this->query($entity->save()); 
    }

    public function selectObject(DatabaseEntity $entity, $where ) {
        if($this->query($entity->select($where))) {
            return $entity->append(); /*$entity, $this->query($entity->select($where))*/
        }
        else {
            return []; 
        }
    }

    public function truncateObject(DatabaseEntity $entity) {
        return $this->query($entity->truncate() ); 
    }

    public function append(DatabaseEntity $entity, $row) {
        return 1; 
    }

    public static function useResult(): object {
        $result = self::$database->mysqli->use_result(); 
        return $result; 
    }

    public static function fetch(object $result) : ?object {
        return $result->fetch_object(); 
    }

    public static function freeResult( $result ) { 
        return $result->free(); 
    }

    public function loadObjects(DatabaseEntity $entity)  {
        return []; 
    }

    public function close() {
        if($this->mysqli) {
            $this->mysqli->close(); 
        }
    }

    public function query($query) {
        echo $query."<br>";
        if(!($result = $this->mysqli->real_query($query))) {
            echo $this->mysqli->error; 
        }
        return $result; 
    }

    public static function create() {
        if( self::$database != null ) {
            return self::$database; 
        }
        else { 
            return new Database(); 
        }
    }

    public function __construct () { 
        self::$database = $this; 
        $this->connect(); 
        return self::$database; 
    }

    public static function getObject () {
        return self::$database; 
    }

    public static function escape( String $str ): String {
        return self::$database->mysqli->real_escape_string( $str ); 
    }

    public static function getInsertId(): int {
        if(self::$database->mysqli) {
            return self::$database->mysqli->insert_id; 
        }
        else {
            return 0; 
        }
    }

    public function clearMemory() {
        self::$database->close(); 
        self::$database = null; 
    }

    public function QueryBuilder() { 

    }

}

?>