<?php

/**
 * testPut.php : Tests all PUTS  defined in index.php
 * This is not a formal test, is used just for depuration tasks
 * @author: laurinf
 **/

include_once 'Client_http.php';

const __URL__ = 'localhost/sysTestNonReg/';


//TODO - Only test PUT is being tested for the moment. We should do the same
// with the other classes.

//Testing test update (we try to change status of test 2 from 'actif' to 'inactif')

$testClass[0] = 'tests/2';
$testValues[0] = array('operation'=>'modification','status-t' => 'inactif');

//testing plan update (changing exec-mode and stop mode of plan 1, currently 1 et 0 to 0 et 1)
$testClass[1] = 'plans/2';
$testValues[1] = array('operation'=>'modification','exec-mod' => '0','stop-mod'=> '1');

//testing answer update (changing answer-value for answer 21 from 'No' to '21')
$testClass[2] = 'answers/20';
$testValues[2] = array('operation'=>'modification','answer-value' => '21');

//Testing assert update (changing label and code)
$testClass[3] = 'asserts/4';
$testValues[3] = array('operation'=>'modification','label' => '|Rp| > 6 => Le nombre de reponses positives est supérieur a 6',
                   'code'=>'<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE assertion SYSTEM "assertion.dtd"><assertion><gt><card><Rp/></card><number>6</number></gt></assertion>');
            
//Testing changing link between test 1 and plan 1 to plan 2
$testClass[4] = 'tests/1/plans';
$testValues[4] = array('operation'=>'modification','oldid-p' => '1', 'newid-p' => '2');

//Testing changing link between test 3 and assert 3 to assert 1
$testClass[5] = 'tests/3/asserts';
$testValues[5] = array('operation'=>'modification','oldid-assert' => '3', 'newid-assert' => '1');

//Testing changing link between test 3 and answer 9 to answer 13
$testClass[6] = 'tests/3/answers';
$testValues[6] = array('operation'=>'modification','oldid-a' => '9', 'newid-a' => '13');

//Testing updating status-u from '+' to '?' for a link between test 3 and answer 10;
$testClass[7] = 'tests/3/answers';
$testValues[7] = array('operation'=>'modification','id-a' => '10', 'status-u' => '?', 'generatedBy' => 'Laurinf');


//Testing tests deletion (deleting a link between a test and an object of another class)

//Testing deleting the link between the plan 3 and the test 4
//this means removing test 3 from plan 4
$testClass[8] = 'tests/4/plans';
$testValues[8] = array('operation'=>'deletion','id-p' => '3');

//Testing deleting answer 8 from test 3 
$testClass[9] = 'tests/3/answers';
$testValues[9] = array('operation'=>'deletion','id-a' => '8');

//Testing deleting assert 2 from test 3 
$testClass[10] = 'tests/3/asserts';
$testValues[10] = array('operation'=>'deletion','id-assert' => '2');


testSimplePut($testClass[10], $testValues[10]);
/*
$i=0;
while ($i<count($testClass)) {
    testSimplePut($testClass[$i], $testValues[$i]);
    $i++;
}
*/
function testSimplePut($class, $data) {
    $h = new Client_http();
    $h->acceptJson();
    echo "Testing ... $class\n";
    $result = $h->PUT(__URL__.$class,$data);
    echo "Result = $result \n*************************************\n";
    $h->close();

}

?>
