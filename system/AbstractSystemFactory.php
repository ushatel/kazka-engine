<?php 

namespace System; 

abstract class AbstractSystemFactory {

    abstract public static function create(); 
    abstract public static function getObject();
    abstract public function clearMemory(); 
}

?>