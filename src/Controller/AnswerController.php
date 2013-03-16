<?php

/**
 * Description of AnswerController
 *
 * @author juliettedompe, laurinf
 * @package Controller
 */
class AnswerController extends Controller {

    /**
     *  AnswerController Constructor
     *
     *  make a new AnswerController
     */
    public function __construct() {

        $this->class = 'Answer';
    }

    
    /**
     * 
     * lists the links between an answer and another element of other class
     * this method return the Test list bound to the answer of identifier equals $id
     * @param String $id the answer identifier
     * @param String $class the related class: in this case only 'tests' value can be accepted
     * @return Array[Test] list of Test link to answer $id
     */
    function listLinks($id, $class) {
        if ($class == 'tests') {
            return $this->listTests($id);
        }
    }

    /**
     * lists all tests related to an answer
     * 
     * @param string $id the answer identifier
     * @return Array[tests]
     */
    public function listTests($id) {
        $answer = new Answer();
        $a = $answer->findById($id);
        return $a->getTests();
    }

}

?>
