<?php

/**
 *  class Report 
 *
 *  Represents a generic report for a test or a plan in the system. 
 *  A PlanReport is a class with attributes: id-r, uri-r, exec-date,
 *  content and result
 * 
 *  @author julietteDompe
 *  @package Model
 *
 **/

class Report extends DBModel {

    /**
     *  Report Constructor
     *
     *  make a new empty Report
     * 
     *  @param array $tval an array containing temporary values por the Report
     *  attributes
     * 
     */
    public function __construct($tval = null) {
        $this->_a = array('id-r' => 'int',
            'uri-r' => 'string',
            'exec-date' => 'string',
            'content' => 'string',
            'result' => 'string',
            'type' => 'int');
        $this->_oid = 'id-r';
        $this->_mname = 'Report'; //__CLASS__;
        $this->_tname = 'Report';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

    
     /**
     * Create 
     * Creates a new report from an array with form :
     * 
     * array('exec-date' => '13/08/2012', 'content' => 'anything', 
     * 'result' => 0, 'type' => 0, 'id-t' => 2, 'id-p' = 1)
     * 
     * @param array $data : array with necessary values to create the report
     * @return Report a new object of type report
     * 
     **/
 
    public function create($data) {
        $this->setAttrValues($data);
        $ins = $this->insert();
        if ($ins === 1) {
            $this->setAttr('uri-r', __URL__ . "/reports/" . $this->getOid());
            $this->update();
        }
        return $this;
    }


}
?>	


