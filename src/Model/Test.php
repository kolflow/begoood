<?php

/**
 * class Test
 *
 * Represents a test in the system. 
 * Each test is composed of a single query to run, and there can't be 2 different
 * tests with the same query.
 * A Test is a class with attributes: id-t, uri-t, status-t,
 * label-t, label-q and uri-q
 *
 * @author julietteDompe, laurinf
 * @package Model
 **/

class Test extends DBModel {

    public $tAnswers;

    /**
     *  Test Constructor
     *
     *  make a new empty test
     * 
     *  @param array $tval an array containing temporary values por the Test
     *  attributes
     */
    public function __construct($tval = null) {
        $this->_a = array('id-t' => 'int',
            'uri-t' => 'string',
            'status-t' => 'set',
            'label-t' => 'string',
            'label-q' => 'string',
            'uri-q' => 'string');
        $this->_oid = 'id-t';
        $this->_mname = 'Test';
        $this->_tname = 'Test';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
        $this->setAttr('status-t', 'Inactif');
    }

    /**
     * Create 
     * Creates a new report from an array of values with form :
     * 
     * array('status-t' => 'inactif', 'label-t' => 'anything', 
     * 'label-q' => 'anything', 'uri-q' => 'anything')
     * 
     * Important: the new test will be only created if it doesn't exist
     * already another one with the same query. 
     * 
     * @param array $data : array with necessary values to create the test
     * @return Test a new object of type test
     * 
     * */
    function create($data) {
        $test = $this->find(array('conditions' => array(array('uri-q' => $data['uri-q']))));
        if (is_null($test)) {
            $test = new Test($data);
            $ins = $test->insert();
            if ($ins === 1) {
                $test->setAttr('uri-t', __URL__ . "/tests/" . $test->getOid());
                $test->update();
            }
        }
        return $test;
    }

    /* méthodes métiers */

     
   
    /**
     * getAsserts 
     * return an array of assert dependent on this Test
     * @return Array[Assert]
     * 
     */
    public function getAsserts() {
        $array = null;
        $concern = new concern();
        $c = $concern->find(array('conditions' => array(array('id-t' => $this->getOid()))));
        if (!is_null($c)) {
            $assert = new Assert();
            foreach ($c as $value) {
                $array[] = $assert->findById($value->getAttr('id-assert'));
            }
        }
        return $array;
    }
    
     /**
     * returns an array of all answers dependent on this Test
     * @return Array[Answers]
     * 
     */
   public function getAnswers() {
        $answers = array();
            $u = new used();
            $use = $u->find(array('conditions' => array(array('id-t' => $this->getOid()))));
            if (!is_null($use)) {
                $a = new Answer();
                foreach ($use as $value) {
                    $answers[] = $a->find($value->getAttr('id-a'))->getAttr('answer-value');
                }
            }
            return $answers;
        
    }
    
    /**
     * returns an array of all plans dependent on this Test
     * @return Array[Plans]
     * 
     */
   public function getPlans() {
        $res = array();
        $isC = new isComposedOf();
        $c = $isC->find(array('conditions' => array(array('id-t' => $this->getOid()))));
        if (!is_null($c)) {
            $test = new Plan();
            foreach ($c as $value) {
                $res[] = $test->find($value->getAttr('id-p'));
            }
        }
        return $res;
      }

    /**
     * getR 
     * return an array of answers dependent on this Test
     * @param string $subset it can take the folowing values:
     * '+' : indicates that the returned answers will be the positive ones R+
     * '-' : indicates that the returned answers will be the negative ones R-
     * '?' : indicates that the returned answers will be the undefined ones R?
     * null : the returned answers will be the current answers for the test R
     * @return Array of answers 
     * 
     */
   public function getR($subSet = null) {
        $answers = array();
        if (!is_null($subSet)) {
            $u = new used();
            $use = $u->find(array('conditions' => array(array('status-u' => $subSet), array('id-t' => $this->getOid()))));
            if (!is_null($use)) {
                $a = new Answer();
                foreach ($use as $value) {
                    $answers[] = $a->find($value->getAttr('id-a'))->getAttr('answer-value');
                }
            }
            return $answers;
        }
        return $this->tAnswers;
    }
    
   

    /**
     * setTemporaryAnswers
     * 
     * set the current answers for the test
     * 
     * @param array[Answer] $newAnswers an array containing the returned answers
     * for the current test
     */
    public function setTemporaryAnswers($newAnswers) {
        $this->tAnswers = $newAnswers;
    }

}
?>

