<?php

/**
 *  class Plan
 * 
 *  Represents a plan in the system. 
 *  A plan is a class with attributes: id-p, uri-p, label-p, exec-mod and stop-mod
 *  and it's linked to a test through an object of type "IsComposedOf"
 *
 *  @author julietteDompe, laurinf
 *  @package Model
 */
class Plan extends DBModel {

    /**
     *  Plan Constructor
     * 
     *  make a new empty plan
     * 
     *  @param array $tval an array containing temporary values por the plan
     *  attributes
     */
    public function __construct($tval = null) {
        $this->_a = array('id-p' => 'int',
            'uri-p' => 'string',
            'label-p' => 'string',
            'exec-mod' => 'string',
            'stop-mod' => 'string');
        $this->_oid = 'id-p';
        $this->_mname = 'Plan'; //__CLASS__;
        $this->_tname = 'Plan';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

    /* fonctions metiers */

    /**
     * Create 
     * Creates a new plan from an array with form :
     * 
     * array('uri-p' => 'string',
      'label-p' => 'string',
      'exec-mod' => 'string',
      'stop-mod' => 'string')'uri-assert' => '/assertUri/uri', 'label' => 'Rp inclus R', 'code' => '<?xml version ...')
     * 
     * @param array $data : array with necessary values to create the assert
     * @return Answer a new object of type assert
     * 
     * */
    function create($data) {
        if (!isset($data['exec-mod']))
            $data['exec-mod'] = 'SET';
        if (!isset($data['stop-mod']))
            $data['stop-mod'] = '0';
        $this->setAttrValues($data);
        $ins = $this->insert();
        if ($ins === 1) {
            $this->setAttr('uri-p', __URL__ . "/plans/" . $this->getOid());
            $this->update();
        }
        return $this;
    }

  
    /**
     * 
     * get all the tests associated to this plan taken in account the exec-mod of plan
     * if exec-mod = 0, tests will be returned with no order, 
     * if exec-mod = 1, tests will be returned with the order indicated in the registration.
     * 
     * @return array[Test] array containing ordered or unordered tests.
     * */
    public function getTests() {
        $res = null;
        $i = new isComposedOf();
        $isC = $i->find(array('conditions' => array(array('id-p' => $this->getOid()))));
        if (!is_null($isC)) {
            $t = new Test();
            if ($this->getAttr('exec-mod') == 1) {
                foreach ($isC as $is) {
                    $res[$is->getAttr('order')] = $t->findById($is->getAttr('id-t'));
                }
            } else {
                foreach ($isC as $is) {
                    $res[] = $t->findById($is->getAttr('id-t'));
                }
            }
        }
        return $res;
    }

}
?>	


