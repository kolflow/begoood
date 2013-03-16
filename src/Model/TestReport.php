<?php

/**
 *  class TestReport extends Report
 *
 *  Represents a report for a test runned in the system. 
 *  A TestReport is a class with attributes: id-r, uri-r, exec-date,
 *  content, result, id-t and id-p 
 *
 * @author juliettedompe, laurinf
 * @package Model
 */

/**
 *  
 */
class TestReport extends Report {

    /**
     *  TestReport Constructor
     *
     *  make a new empty TestReport
     * 
     *  @param array $tval an array containing temporary values por the 
     *  testReport attributes
     */
    public function __construct() {
        parent::__construct();
        $this->_a['id-p'] = 'int';
        $this->_a['id-t'] = 'int';
        $this->type = 1;
        $this->_mname = 'TestReport';
        
    }


}

?>      