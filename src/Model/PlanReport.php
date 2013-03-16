<?php


/**
 *  class PlanReport extends Report
 *
 *  Represents a report for a tests' plan in the system. 
 *  A PlanReport is a class with attributes: id-r, uri-r, exec-date,
 *  content, result and id-p 
 * 
 *  @author juliettedompe, laurinf
 *  @package Model
 */

class PlanReport extends Report {

    /**
     *  PlanReport Constructor
     *
     *  make a new empty PlanReport
     * 
     *  @param array $tval an array containing temporary values por the planReport
     *  attributes
     */
    public function __construct($tval=null) {//$plan) {
        parent::__construct($tval);
        $this->_a['id-p'] = 'int';
        $this->_mname = 'PlanReport';
        $this->type = 0;
        
        
    }


    

}

?>
