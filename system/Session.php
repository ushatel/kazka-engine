<?php 

namespace System; 

use System; 

class Session extends AbstractSystemFactory { 

    private static $session = null; 
    private $sessionData = null; 

    public static function getSession(): Session {
        return self::$session; 
    }

    public static function getKey(String $sessionItem): object {
        return Session::getSession()::$sessionData[$sessionItem]; 
    }

    public static function create ($session = null) {
        if( self::$session != null ) {
            return self::$session; 
        }
        else { 
            return new Session(); 
        }
    }

    public function __construct() {
        session_start(); 
        $this->sessionData = $_SESSION; 
        return self::$session = $this; 
    }

    public static function getObject() {
        return self::$session; 
    }

    public function clearMemory() {
        self::$sesion = null; 
    }
    
}

?> 