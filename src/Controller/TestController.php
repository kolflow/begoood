<?php

/**
 * Description of TestController
 *
 * @author juliettedompe, laurinf
 * @package Controller
 */
class TestController extends Controller {

    /**
     *  TestController Constructor
     *
     *  make a new TestController
     */
    public function __construct() {
        $this->class = 'Test';
    }

    /**
     * Called  by /tests/:id/:class (PUT)
     * modifies an existing link between test and one of the following:
     * Plan, assert, answer
     *  
     * @param String $id the Test identifier
     * @param String $class the class related to Test. 
     * Values: 'answers', 'asserts', 'plans'
     * 
     * @param Array[String] $data an array containing the following indexex:
     * 
     * if $class = 'plans': 'oldid-p' and 'newid-p' - the plan which contained the test and the
     * new we want to move it. Optionally 'order' can appear, if this index doesn't
     * exist in array $data, the test will be added at the end.
     * If we want to use this function to change the order of the parameter, index
     * 'id-p' will appear, instead of 'oldid-p' and 'newid-p'
     *
     * 
     * if $class = 'answers': 'oldid-a' and 'newid-a' - the answer associated to the test and
     * the new answer we want to associate instead. 'generatedBy' and 'status-u' are
     * optional. If these don't exist, old values will be stored.
     * If there's no 'oldid-a' nor 'newid-a' we understand what we want to change
     * is the 'status' and/or 'generatedBy'. In this case an 'id-a' will be provided
     * 
     * if '$class' = 'asserts': 'oldid-assert' and 'newid-assert' - the assert associated to the
     * test and the new assert we want to associate instead. No more parameters are
     * required.
     */
    public function modifyLink($id, $class, $data) {
        if (!isset($data['operation']))
            return null;
        if ($data['operation'] == 'modification') {
            unset($data['operation']);
            switch ($class) {
                case 'plans':
                    return $this->modifyPlanLink($id, $data);
                case 'asserts':
                    return $this->modifyAssertLink($id, $data);
                case 'answers':
                    return $this->modifyAnswerLink($id, $data);
                default:
                    return null;
            }
        } else {
            if ($data['operation'] == 'deletion') {
                unset($data['operation']);
                return $this->removeLink($id, $class, $data);
            }
        }
    }

    /**
     * 
     * Modifies an existing link between a test and a plan
     * and/or change the order of the link with data corresponing to attribute order in parameter
     * 
     * @param String $id identifier of Test
     * @param Array[String] $data may contain the folowing indexes:
     * 
     * 'oldid-p' and 'newid-p' - the plan which contained the test and the
     * new one we want to move it. Optionally 'order' can appear, if this index doesn't
     * exist in array $data, the test will be added at the end.
     * 
     *  If we want to use this function to change the order of the parameter, index
     * 'id-p' will appear, instead of 'oldid-p' and 'newid-p'
     * 
     */
    protected function modifyPlanLink($id, $data) {
        $isC = new isComposedOf();
        if (isset($data['oldid-p']) && isset($data['newid-p'])) {
            //we have to be sure that the new link doesn't exist already
            //if it exists we won't make the update
            $r = $isC->find(array('conditions' => array(array('id-p' => $data['newid-p']), array('id-t' => $id))));
            if (!is_null($r))
                return $r;
            //Otherwise we continue processing the update
            $i = $isC->find(array('conditions' => array(array('id-p' => $data['oldid-p']), array('id-t' => $id))));
            if (is_null($i))
                return null;
            $i->setAttr('id-p', $data['newid-p']);
            if (isset($data['order'])) {
                $i->setAttr('order', $data['order']);
            } else {
                $testsPlan = $isC->find(array('conditions' => array(array('id-p' => $data['newid-p']))));
                $newOrder = 0;
                if (!is_null($testsPlan)) {
                    if (is_array($testsPlan)) {
                        foreach ($testsPlan as $testp) {
                            $newOrder = max($testp->getAttr('order'), $newOrder);
                        }
                        $newOrder++;
                    } else {
                        $newOrder = $testsPlan->getAttr('order') + 1;
                    }
                } else {
                    $newOrder = 1;
                }
            }
        } else {
            $i = $isC->find(array('conditions' => array(array('id-p' => $data['id-p']), array('id-t' => $id))));
            if (isset($data['order'])) {
                $i->setAttr('order', $data['order']);
            }
        }
        if ($i->update() == 1) {
            return $i;
        }
        return null;
    }

    /**
     * 
     * Modifies an existing link between a test and an answer 
     * and/or change the status of the link with data corresponing to attribute 
     * status in parameter $data['status']
     * @param String $id identifier of Test
     * @param Array[String] $data may contain the folowing indexes:
     * 
     * 'oldid-a' and 'newid-a' - the answer associated to the test and
     * the new answer we want to associate instead. 'generatedBy' and 'status-u' are
     * optional. If these don't exist, old values will be stored.
     * 
     * If there's no 'oldid-a' nor 'newid-a' we understand what we want to change
     * is the 'status' and/or 'generatedBy'. In this case an 'id-a' will be provided
     */
    protected function modifyAnswerLink($id, $data) {
        $used = new used();
        if (isset($data['oldid-a']) && isset($data['newid-a'])) {
            //we have to be sure that the new link doesn't exist already
            //if it exists we won't make the update
            $r = $used->find(array('conditions' => array(array('id-a' => $data['newid-a']), array('id-t' => $id))));
            if (!is_null($r))
                return $r;
            $u = $used->find(array('conditions' => array(array('id-a' => $data['oldid-a']), array('id-t' => $id))));
            if (is_null($u))
                return null;
            if (is_array($u))
                $u = $u[0];
            $u->setAttr('id-a', $data['newid-a']);
        } else {
            if (isset($data['id-a'])) {
                $u = $used->find(array('conditions' => array(array('id-a' => $data['id-a']), array('id-t' => $id))));
                if (is_null($u))
                    return null;
                if (is_array($u))
                    $u = $u[0];
            }
        }
        if (isset($data['generatedBy'])) {
            $u->setAttr('generatedBy', $data['generatedBy']);
        }
        if (isset($data['status-u'])) {
            $u->setAttr('status-u', $data['status-u']);
        }
        if ($u->update() == 1) {
            return $u;
        }
        return null;
    }

    /**
     * 
     * Modifies an existing link between a test and an assert
     * 
     * @param type $id
     * @param type $data may contain the following indexes:
     * 
     * 'oldid-assert' and 'newid-assert' - the assert associated to the
     * test and the new assert we want to associate instead. No more parameters are
     * required.
     */
    protected function modifyAssertLink($id, $data) {
        $concern = new concern();
        if (isset($data['oldid-assert']) && isset($data['newid-assert'])) {
            //we have to be sure that the new link doesn't exist already
            //if it exists we won't make the update
            $r = $concern->find(array('conditions' => array(array('id-assert' => $data['newid-assert']), array('id-t' => $id))));
            if (!is_null($r))
                return $r;
            $c = $concern->find(array('conditions' => array(array('id-assert' => $data['oldid-assert']), array('id-t' => $id))));
            if (is_null($c))
                return null;
            if (is_array($c))
                $c = $c[0];
            $c->setAttr('id-assert', $data['newid-assert']);
            if ($c->update() == 1) {
                return $c;
            }
        }
        return null;
    }

    /**
     *  remove one or all links between test and one of the followings:
     * 'plans', 'answers' or 'asserts' . 
     * 
     * 
     * @param String $id the test identifier
     * @param String $class the class to remove the link :
     * values: 'plans', 'answers', 'asserts'
     * 
     * @param $data contains the identifier of $class.
     * $data may contain de following indexes:
     * 
     * if $class = 'plans', $data['id-p] must be provided
     * if $class = 'answers', $data['id-a] must be provided
     * if $class = 'asserts', $data['id-assert] must be provided
     * 
     * if $data is not provided, all links between test and the class will
     * be removed
     */
    public function removeLink($id, $class, $data = null) {
        switch ($class) {
            case 'plans':
                return $this->removePlanLink($id, $data);
                break;
            case 'answers':
                return $this->removeAnswerLink($id, $data);
            case 'asserts':
                return $this->removeAssertLink($id, $data);
            default:
                return null;
        }
    }

    /**
     * removes a link between a test and a plan
     * 
     * @param String $id the test Identifier
     * @param Array[String] $data an array of data containing
     * the identifier of the plan. 
     * $data may contain 'id-p' index, if it is not provided 
     * all plans related to test will be removed
     */
    protected function removePlanLink($id, $data) {
        if (isset($data['id-p'])) {
            $isC = new isComposedOf();
            $i = $isC->find(array('conditions' => array(array('id-p' => $data['id-p'])), array('id-t' => $id)));
            if (is_null($i))
                return array('deleted' => 0);
            if (is_array($i))
                $i = $i[0];
            if ($i->delete() == 1) {
                return array('deleted' => 1);
            }
        } else {
            $isC = new isComposedOf();
            $i = $isC->find(array('conditions' => array(array('id-t' => $id))));
            if (is_null($i))
                return array('deleted' => 0);
            if (is_array($i)) {
                $cDeleted = 0;
                foreach ($i as $elem) {
                    if ($elem->delete() == 1) {
                        $cDeleted++;
                    }
                }
            }
            if ($cDeleted == count($i)) {
                return array('deleted' => 1);
            }
        }
        return array('deleted' => 0);
    }

    /**
     * removes a link between a test and an answer
     * 
     * @param String $id the test Identifier
     * @param Array[String] $data an array of data containing
     * the identifier of the answer. 
     * $data may contain 'id-a' index
     */
    protected function removeAnswerLink($id, $data) {
        if (isset($data['id-a'])) {
            $used = new used();
            $u = $used->find(array('conditions' => array(array('id-a' => $data['id-a'])), array('id-t' => $id)));
            if (is_null($u))
                return array('deleted' => 0);
            if (is_array($u))
                $u = $u[0];
            if ($u->delete() == 1) {
                return array('deleted' => 1);
            }
        } else {
            $used = new used();
            $u = $used->find(array('conditions' => array(array('id-t' => $id))));
            if (is_null($u))
                return array('deleted' => 0);
            if (is_array($u)) {
                $cDeleted = 0;
                foreach ($u as $elem) {
                    if ($elem->delete() == 1) {
                        $cDeleted++;
                    }
                }
            }
            if ($cDeleted == count($u)) {
                return array('deleted' => 1);
            }
        }
        return array('deleted' => 0);
    }

    /**
     * removes a link between a test and an assert
     * 
     * @param String $id the test Identifier
     * @param Array[String] $data an array of data containing
     * the identifier of the assert. 
     * $data may contain 'id-assert' index
     */
    protected function removeAssertLink($id, $data) {
        if (isset($data['id-assert'])) {
            $concern = new concern();
            $c = $concern->find(array('conditions' => array(array('id-assert' => $data['id-assert'])), array('id-t' => $id)));
            if (is_null($c))
                return array('deleted' => 0);
            if (is_array($c))
                $c = $c[0];
            if ($c->delete() == 1) {
                return array('deleted' => 1);
            }
        } else {
            $conc = new concern();
            $c = $conc->find(array('conditions' => array(array('id-t' => $id))));
            if (is_null($c))
                return array('deleted' => 0);
            if (is_array($c)) {
                $cDeleted = 0;
                foreach ($c as $elem) {
                    if ($elem->delete() == 1) {
                        $cDeleted++;
                    }
                }
            }
            if ($cDeleted == count($c)) {
                return array('deleted' => 1);
            }
        }
        return array('deleted' => 0);
    }

    /**
     * createLink 
     * Call by /tests/:id/:class (POST)
     * 
     * 
     * Creates a new link between an element of $class specified in $data and the test
     * which $id is in parameter
     * 
     * @param String $id identifier of Test
     * 
     * @param Array[String] $data : may contain the following indexes: 
     * 
     * for Plans: 'id-p' - the plan to which we want to add the test.
     * Optionally 'order' can appear, if this index doesn't
     * exist in array $data, the test will be added at the end.
     * 
     * for Answers: 'id-a' - the answer we want to associate to the test.
     * 'generatedBy' - the user who generates the answer.
     * 'status-u' is optional.  If it doesn't exist, it will be fixed to undefined (?)
     * 
     * for Asserts: 'id-assert' - the assert we want to associate to the
     * test. No more parameters are required.
     * 
     * @param String $class : 3 possiblities : 'plans', 'asserts', 'answers'
     */
    public function createLink($id, $data, $class) {
        if ($class == 'plans') {
            return $this->createPlanLink($id, $data);
        }
        if ($class == 'answers') {
            return $this->createAnswerLink($id, $data);
        }
        if ($class == 'asserts') {
            return $this->createAssertLink($id, $data);
        }
    }

    /**
     * Creates a new link between a Plan specified in $data
     * and a Test which identifier is $id
     * 
     * @param String $id identifier of test
     * @param array[String] $data may contain the following indexes:
     * 
     * 'id-p' - the plan to which we want to add the test.
     * Optionally 'order' can appear, if this index doesn't
     * exist in array $data, the test will be added at the end.
     * 
     */
    protected function createPlanLink($id, $data) {
        //first of all we have to be sure that the link doesn't exist already on the system
        $isC = new isComposedOf();
        $r = $isC->find(array('conditions' => array(array('id-p' => $data['id-p']), array('id-t' => $id))));
        if (!is_null($r)) {
            return $r;
        }
        //if it doesn't exist we create it
        $data['id-t'] = $id;
        if (!isset($data['order'])) { //if order is not set, we have to calculate it
            $testsPlan = $isC->find(array('conditions' => array(array('id-p' => $data['id-p']))));
            $newOrder = 0;
            if (!is_null($testsPlan)) {
                if (is_array($testsPlan)) {
                    foreach ($testsPlan as $testp) {
                        $newOrder = max($testp->getAttr('order'), $newOrder);
                    }
                    $newOrder++;
                } else {
                    $newOrder = $testsPlan->getAttr('order') + 1;
                }
            } else {
                $newOrder = 1;
            }
            $i = new isComposedOf($data);
            $i->setAttr('order', $newOrder);
        }
        if ($i->insert() == 1) {
            return $i;
        }
        return null;
    }

    /**
     * Creates a new link between an Answer specified in $data
     * and a Test which identifier is $id
     * 
     * @param String $id identifier of test
     * @param array[String] $data may contain the following indexes:
     * 
     * 'id-a' - the answer we want to associate to the test.
     * 'generatedBy' - the user who generates the answer.
     * 'status-u' is optional.  If it doesn't exist, it will be fixed to undefined (?)
     * 
     */
    protected function createAnswerLink($id, $data) {
        //first of all we have to be sure that the link doesn't exist already on the system
        $used = new used();
        $r = $used->find(array('conditions' => array(array('id-a' => $data['id-a']), array('id-t' => $id))));
        if (!is_null($r)) {
            return $r;
        }
        //if it doesn't exist already we create it
        $data['id-t'] = $id;
        $u = new used($data);
        if (!isset($data['status-u'])) {
            $u->setAttr('status-u', '?');
        }
        if ($u->insert() == 1) {
            return $u;
        }
        return null;
    }

    /**
     * Creates a new link between an Assert specified in $data
     * and a Test which identifier is $id
     * 
     * @param String $id identifier of test
     * @param array[String] $data may contain the following indexes:
     * 
     * 'id-assert' - the assert we want to associate to the
     * test. No more parameters are required.
     * 
     */
    protected function createAssertLink($id, $data) {
        //first of all we have to be sure that the link doesn't exist already on the system
        $conc = new concern();
        $r = $conc->find(array('conditions' => array(array('id-assert' => $data['id-assert']), array('id-t' => $id))));
        if (!is_null($r)) {
            return $r;
        }
        //if it doesn't exist already we create it
        $data['id-t'] = $id;
        $c = new concern($data);
        if ($c->insert() == 1) {
            return $c;
        }
        return null;
    }

    /**
     * 
     * called by /tests/:id/:class
     * 
     * list all links between a test and a Plan or Assert or Answer or Report 
     * 
     * @param String $id the Test identifier
     * @param String $class the element to list: 'plans', 'asserts', 'answers' or 'reports'
     * @return array[String] the list of desired elements
     */
    function listLinks($id, $class) {
        switch ($class) {
            case 'plans':
                return $this->listPlans($id);
                break;
            case 'answers':
                return $this->listAnswers($id);
                break;
            case 'asserts':
                return $this->listAsserts($id);
                break;
            case 'reports':
                return $this->listReports($id);
                break;
            case 'rplus':
                return $this->listAnswers($id, '+');
                break;
            case 'rminus':
                return $this->listAnswers($id, '-');
                break;
            case 'rundefined':
                return $this->listAnswers($id, '?');
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * returns a list of plans related to a Test
     * 
     * 
     * @param String $id the Test identifier 
     * @return array[Plans]
     */
    protected function listPlans($id) {
        $test = new Test();
        $t = $test->findById($id);
        return $t->getPlans();
    }

    /**
     * returns an array of answers linked to a test 
     * @param String $id the Test identifier
     * 
     * @param String $subSet it may contain the following values:
     * 
     * '+' - Lists just positive answers
     * '-' - Lists just negative answers
     * '?' - Lists just undefined answers
     * null - Lists all answers
     * 
     * @return array[Answer] Array containing the desired answers
     */
    protected function listAnswers($id, $subSet = null) {
        $test = new Test();
        $t = $test->findById($id);
        if (!is_null($subSet)) {
            return $t->getR($subSet);
        } else {
            return $t->getAnswers();
        }
    }

    /**
     * Returns an array of Asserts linked to test $id
     * 
     * @param String $id Test identifier
     * @return array[Assert] an array containing asserts related to test
     * 
     */
    protected function listAsserts($id) {
        $test = new Test();
        $t = $test->findById($id);
        return $t->getAsserts();
    }

    /**
     * List all reports related to a Test
     * 
     * @param String $id the Test identifier
     * @return array[Report] the list of reports related to the test
     * or a void array if there isn't any report
     */
    protected function listReports($id) {
        $res = array();
        $r = new TestReport();
        $res = $r->find(array('conditions' => array(array('id-t' => $id))));
        return $res;
    }

    /**
     * 
     * Runs a test specified by its id $id and generates a new Report
     * 
     * @param String $id the Test identifier
     * @return Report the generated report for the execution of the test
     */
    public function run($id) {
        $test = new Test();
        $t = $test->findById($id);
        if (!is_null($t))
            return $this->executeTest($t);
        return null;
    }

    /**
     *  
     * Runs the execution of a test specified by $t
     * and generates a new Report
     * @param Test $t the Test to execute
     * @param String $p the Plan identifier in wich the test is contained,
     * 0 by default when the test is not contained in a specific plan
     * 
     * @return Report the generated report
     */
    public function executeTest($t, $p = 0) {
        $execURI = $t->getAttr('uri-q');
        //here comes the code for executing the query
        //thta will return some answers 
        $newAnswers = $this->runRemoteTests($execURI);
        // now we have to create the temporary answers (won't be stocked in database)
        if (!is_null($newAnswers)) {
            if (is_array($newAnswers)) {
                $t->setTemporaryAnswers($newAnswers);
            }
            else
                $t->setTemporaryAnswers(array('0' => $newAnswers));
        } else {
            return "No retrieved answers to evaluate"; // returns null???
        }

        $asserts = $t->getAsserts();
        if (is_null($asserts)) {
            return "No retrieved assert to evaluate the answers for test" . $t->getOid(); //returns null?
        }
        $rapport = new TestReport();
        $data['id-t'] = $t->getOid();
        $data['id-p'] = $p;
        $data['exec-date'] = date("Y-m-d H:i:s");

        $resultsEval = array();
        foreach ($asserts as $assert) {
            $assertsCode[] = $assert->getAttr('code');
            $resultsEval[] = $assert->evaluate($t);
        }

        if (array_search(false, $resultsEval) === false) {
            $data['result'] = true;
        } else {
            $data['result'] = false;
        }

        $content['R+'] = $t->getR('+');
        $content['R-'] = $t->getR('-');
        $content['Ru'] = $t->getR('?');
        $content['R'] = $t->getR();
        $content['asserts'] = $assertsCode;
        $content['results'] = $resultsEval;

        $data['content'] = json_encode($content, JSON_UNESCAPED_SLASHES);

        $rapport->create($data);
        return $rapport;
    }

    /**
     * Execute the query contained in the test ($execURI) and returns the
     * results in an array of results 
     * 
     * @param String $execURI the query to run
     * @return Array[String] an Array containing Strings which represents the
     * answers to the test
     */
    protected function runRemoteTests($execURI) {
        $ch = curl_init($execURI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Accept: application/json"));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

}

?>
