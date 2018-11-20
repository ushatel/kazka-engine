<?php 

namespace System; 

abstract class Controller { 

    private $pageContent = ""; 

    public function render(String $facade): String { 
        $rootLayout = Application::getRoot()."/".$facade; 
        if(is_file($rootLayout)) { 
            ob_start(); 
            include_once($rootLayout);
            $this->pageContent = ob_get_clean(); 
        }

        return $this->getContent(); 
    }

    public function getContent(): String { 
        return $this->pageContent; 
    }

}

?> 