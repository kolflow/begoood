<?php


  define ('CLASS_FILE_SUFFIX' , '.php');
  define ('__URL__' , 'localhost/SysTestNonReg'); 
 define ('INSTALLATION_DIR' , dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
 //define ('IMAGEDIR_NAME', 'images');
  


 spl_autoload_register(function ($className) {


	$myAppClasspath = PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR  . 'Controller' .
                        PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR  . 'Controller/LinkController' .
                        PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR  . 'Controller/ModelController' .
			PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR . 'DBModel' .
			PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR . 'Model' .
			PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR . 'View' .
                        PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR . 'config' .
                        PATH_SEPARATOR . INSTALLATION_DIR . DIRECTORY_SEPARATOR . 'Link';
			
	
	$systemIncludePath = get_include_path() ;
	set_include_path( $systemIncludePath . $myAppClasspath );
        
	require_once ($className. CLASS_FILE_SUFFIX);
        
	set_include_path( $systemIncludePath );
    } );
    

?>
