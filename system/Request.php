<?php 

namespace System;

class Request extends AbstractSystemFactory {

    private static $request = null; 
    private $requestData = null; 

    public static function getRequest(): Request {
        return self::$request; 
    }

    public static function getKey(String $requestItem): String { 
        if(array_key_exists($requestItem, Request::getRequest()->requestData)) {
            return Request::getRequest()->requestData[$requestItem]; 
        }
        else return ""; 
    } 

    public static function getAction() : String {
        // Resolve Action 
        //echo 'Load';
        return Request::getKey( "action" ); 
    }

    public static function create () {
        if( self::$request != null ) { 
            return self::$request; 
        }
        else {
            return new Request(); 
        }
    }

    public function __construct() {
        $this->requestData = $_REQUEST; 
        return self::$request = $this; 
    }

    public static function getObject() {
        return self::$request; 
    }

    public function clearMemory() {
        self::$request = null; 
    }

}

?> 