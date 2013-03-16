<?php

/**
 *  class isComposedOf
 *
 *  Represents the association between a plan and one of its tests.
 *  Attributes: id-i, id-p, id-t, order
 * 
 *  @author julietteDompe, laurinf
 *  @package Model
 */

/**

 *
 */
class isComposedOf extends DBModel {

    /**
     *  isComposedOf Constructor
     *
     *  make a new empty isComposedOf
     * 
     *  @param array $tval an array containing temporary values por the 
     *  isComposedOf attributes
     */
    public function __construct($tval = null) {
        $this->_a = array('id-i' => 'int',
            'id-t' => 'int',
            'id-p' => 'int',
            'order' => 'string');
        $this->_oid = 'id-i';
        $this->_mname = 'isComposedOf';
        $this->_tname = 'isComposedOf';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

}

?>
