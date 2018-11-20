<?php 

namespace System; 

use System; 

class Application extends AbstractSystemFactory { 

    private const applicationName = "NexusMedia";

    private static $application = null; 

    private $controller = null; 
    private $action = null; 

    public static function getApplication(): Application {
        return self::$application; 
    }

    public static function getRoot(): String {
        return $_SERVER['CONTEXT_DOCUMENT_ROOT'];
    }

    public static function create($app = null) { 
        if( self::$application != null ) { // returns singletone for Application 
            return self::$application; 
        }
        else { 
            return new Application(); 
        }
    }

    public static function run() {
        self::$application->resolveController()
                          ->resolveAction()
                          ->runController()
                          ->render(); 
    }

    public function __construct () {
        return self::$application = $this; 
    }

    public static function getObject () {
        return self::$application; 
    }

    public function clearMemory() {
        self::$application = null; 
    }

    public function resolveController(): Application {
        // Resolve controller on request  
        $this->controller = new \NexusMedia\Controllers\IndexController();

        return $this; 
    }

    public function resolveAction(): Application {

        /// Here will search for routing files /config/routing 
        switch( Request::getAction() ) {
            case 'load':
                $this->action = "actionLoad"; 
            break; 

            default:
                $this->action = "actionIndex"; 
            break; 
        }
        return $this; 
    }

    public function runController(): Application {
        $this->controller->{$this->action}();

        return $this; 
    }

    public function registerView() {

    }

    public function render () { 
        // Response object flush works will come here 
        echo $this->controller->getContent(); 
    }

}

?> 