
<?php

/**
 * class Assert
 * 
 *  Represents an anssert in the system. 
 *  An assert is a class with attributes: id-assert, uri-assert, label and code
 *  and it's linked to a test through an object of type "Concern"
 * 
 * 
 *  @author julietteDompe, laurinf
 *  @package Model
 * 
 * */
//require_once '../xml/assertion.dtd';

class Assert extends DBModel {

    /**
     *  Assert Constructor
     * 
     *  make a new empty assert
     * 
     *  @param array $tval an array containing temporary values por the assert
     *  parameters
     */
    public function __construct($tval = null) {
        $this->_a = array('id-assert' => 'int',
            'uri-assert' => 'string',
            'label' => 'string',
            'code' => 'string');
        $this->_oid = 'id-assert';
        $this->_mname = 'Assert'; //__CLASS__;
        $this->_tname = 'Assert';
        $this->_dbconfig = 'MAIN';
        parent::__construct($tval);
    }

    /**
     * Create 
     * Creates a new answer from an array with form :
     * 
     * array('uri-assert' => '/assertUri/uri', 'label' => 'Rp inclus R', 'code' => '<?xml version ...')
     * 
     * @param array $data : array with necessary values to create the assert
     * @return Answer a new object of type assert
     * 
     * */
    function create($data) {
        if ($this->isValidAssertion($data['code'])) {
            $this->setAttrValues($data);
            $ins = $this->insert();
            if ($ins === 1) {
                $this->setAttr('uri-assert', __URL__ . "/asserts/" . $this->getOid());
                $this->update();
            }
            return $this;
        }
        return null;
    }

    /**
     * modify
     * 
     * modify the assert with new values
     * @param array $data array containing the new values for the assert
     * @return Assert a valid modified assertion or null if there's a problem
     * */
    public function modify($data) {
        if ($this->isValidAssertion($data['code'])) {
            $this->setAttrValues($data);
            if ($this->update() > 0) {
                return $this;
            }
        }
        return null;
    }

    /**
     * getTest 
     * gets an array of Tests using this Assert
     * @return array[Test]
     * 
     * */
    public function getTests() {
        $answers = array();
        $c = new concern();
        $concern = $c->find(array('conditions' => array(array('id-assert' => $this->getOid()))));
        if (!is_null($concern)) {
            $a = new Test();
            $answers = array();
            foreach ($concern as  $value) {
                $answers[] = $a->find($value->getAttr('id-t'));
            }
        }
        return $answers;
    }

    /**
     * isValidAssertion
     * 
     * validates the XML code of Assertion with the RelaxNG file
     * @param String $code string containing the xml code to validate
     * @return boolean true if assertion is valid, false otherwise
     */
    public function isValidAssertion($code) {
        $doc = new DOMDocument();
        if ($doc->loadXML($code)) { 
            if ($doc->validate()) {
                return true;
            }
        }
        return false;
    }

    /**
     * evaluate
     * 
     * evaluates current assertion for a specifif test $t
     * @param Test $t the test for which we want to evaluate the assertion
     * @return boolean true if the assertion was sattisfied with test t, false otherwise
     */
    public function evaluate($t) {

        $assXml = $this->getAttr('code');
        $xml = new DOMDocument('1.0', 'iso-8859-1');
        $xml->loadXML($assXml);
        $element = $xml->getElementsByTagName('assertion')->item(0);
        return $this->evalAssertion($element, $t);
    }

    /**
     * evalAssertion
     * 
     * recursively covers all xml nodes to evaluate the current assertion face to a test
     * @param DOMNode $element the test for which we want to evaluate the assertion
     * @return a new expression to evaluate
     */
    public function evalAssertion($element, $t) {

        $operateur = $element->tagName;
        $Xpath = new DOMXPath($element->ownerDocument);
        $childrenElements = $Xpath->query('*', $element);

        switch ($operateur) {


            case "Rp" :
                return $t->getR('+');
                break;

            case "Rn" :
                return $t->getR('-');
                break;

            case "Ru" :
                return $t->getR('?');
                break;

            case "R" :
                return $t->getR();
                break;

            case "Tp" :
                return array_intersect($t->getR('+'), $t->getR());
                break;

            case "Tn" :
                return array_intersect($t->getR('-'), $t->getR());
                break;

            case "Tu" :
                return ($t->getR() - array_intersect($t->getR('+'), $t->getR()) - array_intersect($t->getR('-'), $t->getR()) );
                break;

            case "Empty-set" :
                return array();
                break;

            case "number" :
                return $element->nodeValue;
                break;

            case "not" :
                return !$this->evalAssertion($childrenElements->item(0), $t);
                break;

            case "card" :
                return count($this->evalAssertion($childrenElements->item(0), $t));
                break;


            case "neq-set";
            case "neq" :
                return ($this->evalAssertion($childrenElements->item(0), $t) != $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "eq-set":
            case "eq" :
                return ($this->evalAssertion($childrenElements->item(0), $t) == $this->evalAssertion($childrenElements->item(1), $t));
                break;


            case "gt" :
                return ($this->evalAssertion($childrenElements->item(0), $t) > $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "lt" :
                return ($this->evalAssertion($childrenElements->item(0), $t) < $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "le" :
                return ($this->evalAssertion($childrenElements->item(0), $t) <= $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "ge" :
                return ($this->evalAssertion($childrenElements->item(0), $t) >= $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "and" :
                return ($this->evalAssertion($childrenElements->item(0), $t) && $this->evalAssertion($childrenElements->item(1), $t));
                break;


            case "or" :
                return ($this->evalAssertion($childrenElements->item(0), $t) || $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "union";
            case "plus" :
                return ($this->evalAssertion($childrenElements->item(0), $t) + $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "intersect" :
                return (array_intersect($this->evalAssertion($childrenElements->item(0), $t), $this->evalAssertion($childrenElements->item(1), $t)));
                break;

            case "dif";
            case "minus" :
                return ($this->evalAssertion($childrenElements->item(0), $t) - $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "divide" :
                return ($this->evalAssertion($childrenElements->item(0), $t) / $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "times" :
                return ($this->evalAssertion($childrenElements->item(0), $t) * $this->evalAssertion($childrenElements->item(1), $t));
                break;

            case "assertion" :
                return ($this->evalAssertion($childrenElements->item(0), $t));
                break;

            default:
                break;
        }
    }

}
?>	


