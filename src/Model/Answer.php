<?php

/**
 *  Description of Answer
 * 
 *  Represents an answer in the system. 
 *  An answer is a class with attributes: id-a, uri-a and answer-value
 *  and it's linked to a test through an object of type "Used"
 * 
 *  @author julietteDompe, laurinf
 *  @package Model
 * 
 * */
class Answer extends DBModel {

    /**
     *  Answer Constructor
     *
     *  make a new empty answer
     * 
     *  @param array $tval an array containing temporary values por the answer
     *  parameters
     * 
     * */
    public function __construct($tval = null) {
        $this->_a = array('id-a' => 'int',
            'uri-a' => 'string',
            'answer-value' => 'string');
        $this->_oid = 'id-a';
        $this->_mname = 'Answer';
        $this->_tname = 'Answer';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

    /**
     * Create 
     * Creates a new answer from an array with form :
     * 
     * array('uri-a' => '/answerUri/uri', 'answer-value' => '+')
     * 
     * @param array $data : array with necessary values to create the answer
     * @return Answer a new object of type answer
     * */
    function create($data) {
        $answer = $this->find(array('conditions' => array(array('answer-value' => $data['answer-value']))));
        if (is_null($answer)) {
            $answer = new Answer($data);
            $ins = $answer->insert();
            if ($ins === 1) {
                $answer->setAttr('uri-a', __URL__ . "/answers/" . $answer->getOid());
                $answer->update();
            }
        }
        return $answer;
    }

    /**
     * obtains the tests related to this answer
     * @return Array[Test] an array containing the Tests related to this Answer
     * 
     * */
    public function getTests() {
        $a = new used();
        $r = $a->find(array('conditions' => array(array('id-a' => $this->getOid()))));
        if (!is_null($r)) {
            $t = new Test();
            foreach ($r as $val) {
                $answers[] = $t->findbyId($val->getAttr('id-t'));
            }
        }
        return $answers;
    }

}
?>	


