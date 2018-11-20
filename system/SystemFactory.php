<?php 

namespace System; 

use System\Application; 
use System\Session; 
use System\Database; 

class SystemFactory { // Abstract factory 

    private static $runState = 0; 

    public static function run(): void {
        if( self::$runState == 0 ) {
            self::initialize();
            Application::run(); 
            self::$runState = 1; 
        }
    }

    public static function stop(): void {
        if( self::$runState == 1) {
            self::$runState = 0; 
        }
    }

    private static function initialize() {
        self::createApplication(); 
        self::createSession(); 
        self::createRequest(); 
        self::createDatabase(); 
    }

    protected function clearUpMemory(): void {
        Application::getObject()->clearUpMemory(); 
        Session::getObject()->clearUpMemory(); 
        Request::getObject()->clearUpMemory(); 
        Database::getObject()->clearUpMemory(); 
    }

    protected static function createApplication() {
        Application::create(); 
    }

    protected static function createSession() {
        Session::create(); 
    }

    protected static function createRequest() {
        Request::create(); 
    }

    protected static function createDatabase() { 
        Database::create(); 
    }

}

?>