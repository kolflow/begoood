<?php

/**
 * Description of AssertController
 *
 * @author juliettedompe, laurinf
 * @package Controller
 */
class AssertController extends Controller {

    /**
     *  AssertController Constructor
     *
     *  make a new AssertController
     */
    public function __construct() {
        $this->class = 'Assert';
    }
    
    

    /**
     * 
     * lists the links between an assert and annother class specified in $class
     * 
     * @param String $id the Assert identifier
     * @param String $class the class name: in this case just value 'tests' can be provided
     * @return list of Test link to assert $id
     */
    function listLinks($id, $class) {
        if ($class == 'tests') {
            return $this->listTests($id);
        }
        
    }

    /**
     * listTests (call by the method listeIdWithLiaison($id, $class))
     * 
     * @param String $id the assert identifier
     * @return Array[Tests]
     */
    public function listTests($id) {
        $assert = new Assert();
        $a = $assert->findById($id);
        return $a->getTests();
    }

   

    /**
     * 
     * creates a new object of type Assert, verifying that the xml code is valid
     * face to the rnc file 
     * 
     * @param Array $data an array containing the fields to create the assert
     * @return Assert the created assert
     */
  /*  function create($data) {
        if ($this->class->isValidAssertion($data['uri-assert'])) {
            return parent::create($data);
        }
    }*/


}

?>
