<?php
  /**
   * DBFactory.php : fabrique pour la connexion PDO vers la base SQL 
   *
   * @author Gérome Canals
   * @package DBModel
   */


/**
 *  La classe DBFactory : fabrique des connexions PDO
 * 
 *  
 */

class DBFactory {


  
  private static $path_config = 'config/db.config.ini';
  

  /**
   *   makeConnection() : fabrique une instance PDO 
   *
   *   
   *   Charge le fichier de configuration
   *   @access public
   *   @return PDO un nouvel objet PDO ou False en cas d'erreur
   **/  
  public static  function makeConnection($conf) {
    $configpath = dirname(__FILE__).DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. self::$path_config;
    $ini_array= parse_ini_file($configpath,true);
    $config = $ini_array[$conf];
   
    if (!$config) throw new DBException("DBFactory::makeConnection: could not parse config file $configpath <br/>");

    $dbtype=$config['db_driver'];$host=$config['host']; $dbname=$config['dbname'];
    $user=$config['db_user']; $pass=$config['db_password']; 
    try {
        $dsn="$dbtype:host=$host;dbname=$dbname";
        $db = new PDO($dsn, $user,$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                                               
                                               PDO::ATTR_PERSISTENT=>true   ));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(PDOException $e) {
            
	    throw new DBException("connection: $dsn  ".$e->getMessage(). '<br/>');
    }
    return $db;
  }


 

}

?>
	


  
