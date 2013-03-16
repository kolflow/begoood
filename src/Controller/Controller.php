<?php

/**
 * Description of Controller
 *
 * @author juliettedompe, laurinf
 * @package Controller
 */
class Controller {

    /**
     *  attribut class
     */
    protected $class;

    /**
     * Called by /tests/:id
     *         /plans/:id
     *         /asserts/:id
     *         /answers/:id
     *         /reports/:id
     * 
     * return the element of the class called which the identifier is in parameter $id
     * @param String $id the 'class' identifier number
     * @return DBModel an object of type DBModel. 
     * It can be 'Plan', 'Test', 'Answer', 'Assert' or 'Report'
     */
    function listId($id) {
        $c = new $this->class();
        $t = $c->findById($id);
        return $t;
    }

    /**
     * Called by /tests
     *          /answers
     *          /asserts
     *          /plans
     *          /reports
     * 
     * return the list of all the object of the class $this->class
     * @return Array[DBModel] all the elements of class called
     */
    function listAll() {
        $res = array();
        $c = new $this->class();
        $res = $c->find();
        return $res;
    }

    /**
     * Called by /$1' (POST)
     * 
     * creates an object of type $this->class
     * @param Array[String] $data an array containing all the values for
     * the creation of the element of type $this->class
     * @return DBModel The created element : 'Plan' or 'Test' or 'Report'
     * or 'Assert' or 'Answer'
     */
    function create($data) {
        $class = new $this->class();
        $obj = $class->create($data);
        if (!is_null($obj)) {
            return $obj;
        }
    }

    /**
     * Called by /$1' (PUT)
     * 
     * Updates an object of type $this->class()
     * @param Array[String] $data an array containing all the values we want to 
     * update in an object
     * @return DBModel the modified object 
     */
    function modify($id, $data) {
        $class = new $this->class();
        $nc = $class->findById($id);
        if (!is_null($nc)) {
            $nc->setAttrValues($data);
            if ($nc->update() == 1)
                return $nc;
        }
        return null;
    }

    /**
     * CallED by /tests/ (DELETE)
     *         /plans/ (DELETE)
     * 
     * remove all existing plans or tests
     * @return Array[String] an array containing the following indexed and values
     * 'deleted' => 1 : if the element was correctly deleted
     * 'deleted' => 0 : if the element wasn't deleted for 'any' reason
     */
    function removeAll() {
        $test = new $this->class();
        $t = $test->find();
        $contDel = 0;
        foreach ($t as $value) {
            if ($value->delete() == 1) {
                $contDel++;
            }
        }
        if ($contDel == count($t)) {
            return array('deleted' => 1);
        }
        return array('deleted' => 0);
    }

    /**
     * 
     * Called by /tests/:id (DELETE)
     *         /plans/:id (DELETE)
     * 
     * remove a class (= plan or test ) corresponding to identifier $id
     * 
     * @param String $id the element to remove
     * 
     * @return Array[String] an array containing the following indexed and values
     * 'deleted' => 1 : if the element was correctly deleted
     * 'deleted' => 0 : if the element wasn't deleted for 'any' reason

     */
    function removeById($id) {
        $c = new $this->class();
        $t = $c->findById($id);
        if (!is_null($t)) {
            if ($t->delete() == 1) {
                return array('deleted' => 1);
            }
        }
        return array('deleted' => 0);
    }

    public function showStatus() {
        try {
            $errors = array('Errors');
            $modules = apache_get_modules();
            if (!in_array("mod_rewrite", $modules)) {
                $errors[] = 'mod_rewrite module is missing';
            }
            if (version_compare(PHP_VERSION, '5.3.15', '<')) {
                $errors[] = "Php version " . PHP_VERSION . "is not compatible with the system";
            }
            DBFactory::makeConnection('MAIN');
        } catch (DBException $d) {
            $errors[] = $d->__toString();
            return $errors;
        }
        if (count($errors)==1) {
            return "TestApp has been succesfully installed and it's ready to be used";
        }
        return $errors;
    }

}

?>
