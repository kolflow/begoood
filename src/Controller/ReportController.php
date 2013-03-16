<?php

/**
 * Description of ReportController
 *
 * @author juliettedompe, laurinf
 * @package Controller
 */
class ReportController extends Controller {

    /**
     *  ReportController Constructor
     *
     *  make a new ReportController
     * 
     * @param $type the type of repport class 
     * values: 
     * 0 - 'PlanReport'
     * 1 - 'TestReport'
     * null - generic 'Report'
     */
    public function __construct($type = null) {
        if (is_null($type)) {
            $this->class = 'Report';
        } elseif ($type == 0) {
            $this->class = 'PlanReport';
        } elseif ($type == 1) {
            $this->class = 'TestReport';
        }
    }

    /**
     * 
     * list the existing link between a report and another class specified by $class
     * @param String $id the report identifier
     * @param String $class the linked class. Values can be: 'tests' or 'plans'
     * @return Array the list of linked class values to report $id
     */
    function listLinks($id, $class) {
        switch ($class) {
            case 'tests':
                return $this->listTests($id);
                break;
            case 'plans':
                return $this->listPlans($id);
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * lists all tests related to report specified by id $id
     * 
     * @param String $id the report identifier
     * @return Array[Test] the tests related to this repport
     */
    protected function listTests($id) {
        $res = array();
        $r = new TestReport();
        $c = $r->findById($id);
        if (!is_null($c)) {
            $test = new Test();
            if (is_array($c)) {
                foreach ($c as $value) {
                    $res[] = $test->findById($value->getAttr('id-t'));
                }
            } else {
                $res = $test->findById($c->getAttr('id-t'));
            }
        }
        return $res;
    }

    /**
     * lists all plan related to report specified by id $id
     * 
     * @param String $id the report identifier
     * @return Array[Plan] the plans related to this repport
     */
    protected function listPlans($id, $class) {
        $res = array();
        $r = new PlanReport();
        $c = $r->findById($id);
        if (!is_null($c)) {
            $plan = new Plan();
            foreach ($c as $value) {
                $res[] = $plan->findById($value->getAttr('id-p'));
            }
        }
        return $res;
    }

}

?>
