<?php

/**
 * class used
 *
 * Represents the association between a test and one of its answers
 * Attributes: id-u, id-t, id-a, generatedBy, status-u
 *
 * @author julietteDompe, laurinf
 * @package Model
 **/
class used extends DBModel {

    /**
     *  used Constructor
     *
     *  make a new empty use
     * 
     *  @param array $tval an array containing temporary values por the 
     *  isComposedOf attributes
     */
    public function __construct($tval = null) {
        $this->_a = array('id-u' => 'int',
            'id-t' => 'int',
            'id-a' => 'int',
            'generatedBy' => 'string',
            'status-u' => 'string');
        $this->_oid = 'id-u';
        $this->_mname = 'used';
        $this->_tname = 'used';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

    /**
     *   change the value of status_ with the value in parameter
     *   @param string status One of these values '+', '-' or '?'
     */
    public function changeState($status) {
        $this->setattr('status-u', $status);
        $this->update();
    }

}
?>

