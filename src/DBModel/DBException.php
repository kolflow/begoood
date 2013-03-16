<?php
 /**
   * DBException.php : Exceptions pour les accès à la base
   *
   * @author Jérémy Fix
   * @author Gérôme Canals
   * 
   * @package DBModel
   */


class DBException extends Exception {

public function __construct($message, $code = 0) {
       
       // make sure everything is assigned properly
       parent::__construct($message, $code);
   }

   // custom string representation of object
public function __toString() {
       return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
   }
}
?>
