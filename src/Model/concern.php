<?php

/**
 *  class concern
 *
 *  Represents the association between a test and an assert
 *  this class has attributes: 'id-t' and 'id-assert'
 * 
 *  @author julietteDompe, laurinf
 *  @package Model
 */

/**

 */
class concern extends DBModel {

    /**
     *  concern Constructor
     *
     *  make a new empty concern
     * 
     *  @param array $tval an array containing temporary values por the 
     *  concern attributes
     */
    public function __construct($tval = null) {
        $this->_a = array('id-c' => 'int',
            'id-t' => 'int',
            'id-assert' => 'int');
        $this->_oid = 'id-c';
        $this->_mname = 'concern';
        $this->_tname = 'concern';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

}
?>

