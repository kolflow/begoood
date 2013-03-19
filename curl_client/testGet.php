<?php

/**
 * testGet.php : Tests all gets defined in index.php
 * This is not a formal test, is used just for depuration tasks
 * @author: laurinf
 **/


include_once 'Client_http.php';

const __URL__ = 'http://localhost:8888/begood/src/';

$testClasses = ['tests','plans','answers','reports','tests/3','plans/1','asserts/1','answers/3','reports/9',
                'tests/1/plans','tests/1/asserts','tests/1/answers','tests/1/reports','tests/2/rminus','tests/3/rundefined',
                'plans/1/tests','asserts/1/tests','answers/6/tests','reports/1/tests'];

foreach($testClasses as $class){
    testSimpleGet($class);
}


function testSimpleGet($class) {
    $h = new Client_http();
    $h->acceptJson();
    echo "Testing ... $class\n";
    $result = $h->GET(__URL__.$class);
    echo "Result = $result \n*************************************\n";
    $h->close();
}

?>
