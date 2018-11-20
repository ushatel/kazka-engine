<?php 

//echo phpinfo(); 

// Autoloading 
spl_autoload_register ( function ($class_name) { include ($class_name . ".php"); /*echo $class_name."<br>";*/ } ); 

// Core Run 
System\SystemFactory::run();

?>