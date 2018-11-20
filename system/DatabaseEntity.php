<?php 

namespace System; 

abstract class DatabaseEntity {

    public const CREATE = 1; 
    public const UPDATE = 2; 
    public const SELECT = 3; 
    public const TRUNCATE = 4; 

    private $_fields = array(); 
    private $_length = 0; 

    public function __construct () {
        $this->_fields = $this->getFields(); 
    }

    protected abstract function getTableName() : String; 
    protected abstract function getFields() : Array; 

    private function queryBuild( string $command, $where = "" )  { // JUST INSERT and SELECT for this time 
        $query = ""; // Move to DatabaseQuery 

        $this->_fields = $this->getFields(); 
        $this->_length = count( $this->_fields ); 

        switch( $command ) {
            case DatabaseEntity::CREATE: 
                $resolved = $this->resolveCreateFields(); 
                $query = " INSERT INTO `".$this->getTableName()."` (".$resolved["fields"].") VALUES (".$resolved["values"].");"; 
            break; 

            case DatabaseEntity::UPDATE: 
                $resolved = $this->resolveUpdateFields(); 
            break; 

            case DatabaseEntity::SELECT:
                $resolved = $this->resolveSelectFields(); 
                $query = " SELECT ".$resolved. " FROM `".$this->getTableName()."` WHERE ".$where; // WHERE 
            break; 

            case DatabaseEntity::TRUNCATE: 
                $query = "TRUNCATE TABLE `".$this->getTableName()."`"; 
            break; 
        }

        return $query; 
    }

    private function resolveNames () { // Move to DatabaseQuery 
        $fieldsString = ""; 
        for($ind = 0; $ind < ($len = count($this->_fields)); $ind++ ) {
            $fieldsString .= "`".$this->_fields[$ind]['dbf']."`". ( $ind < $len - 1 ? ", " : "" ); 
        } 
        return $fieldsString; 
    }

    private function resolveCreateFields() { // Move to DatabaseQuery 
        $fieldsString = ""; $valuesString = ""; $step = 0; 
        foreach($this->_fields as $fieldsKey => $fieldsItem ) {
            $step++; 
            if( $fieldsItem["dbt"] != 'id' && $fieldsItem["dbt"] != 'created' ) { // System fields 
                $fieldsString .= "`".$fieldsItem['dbf']."`". ( $step < $this->_length ? ", " : "") ; 
                $valuesString .= "'".Database::escape($this->{$fieldsKey})."'". ( $step < $this->_length ? ", " : "" ); 
            }
        } 
        return [ "fields" => $fieldsString, "values" => $valuesString ]; 
    }

    private function resolveUpdateFields() { // Move to DatabaseQuery 
        return ""; 
    }

    private function resolveSelectFields() { // Move to DatabaseQuery 
        $fieldsString = ""; $step = 0; 
        foreach( $this->_fields as $fieldsItem ) {
            $step++; 
            $fieldsString .= "`".$fieldsItem['dbf']."`". ( $step < $this->_length ? ", " : ""); 
        }
        return $fieldsString; 
    }

    private function resolveField( Array $field ) {
        switch( $field["dbt"] ) {

            case 'id': 
            break; 

            case 'timestamp':
            break; 

            case 'int': 
            break; 

            case 'string': 
            break; 

            default: 
            break; 
        }
    }

    public function save(): String { // Future result DatabaseQuery 
        return $this->queryBuild( self::CREATE ); 
    }

    public function select( String $where ): String { // Where would be implemented by DatabaseQuery 
        return $this->queryBuild( self::SELECT, $where ); 
    }

    public function append(): Array {
        $resultEntities = []; 

        $this->_fields = $this->getFields(); 
        $this->_length = count( $this->_fields );

        $result = Database::useResult(); 

        $resultEntities = [] ;  
        $entityName = get_class($this); 
        while( $obj = Database::fetch($result) ) {
            $entity = new $entityName(); 
            foreach($this->_fields as $key => $field) {
                $entity->{$key} = $obj->{$field["dbf"]}; 
            }
            $resultEntities[] = $entity; 
        }
        Database::freeResult($result);

        return $resultEntities; 
    }

    public function truncate(): String {
        return $this->queryBuild( self::TRUNCATE ); 
    }
}

?>