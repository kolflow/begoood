<?php

/**
 * testDelete.php : Tests all DELETES defined in index.php
 * This is not a formal test, is used just for depuration tasks
 * @author: laurinf
 **/

include_once 'Client_http.php';

const __URL__ = 'localhost/sysTestNonReg/';

$testClasses = ['tests/3','plans/1','tests/3/plans','tests/2','tests/1/plans'];


$i=0;
while ($i<count($testClasses)) {
    testSimpleDelete($testClasses[$i]);
    $i++;
}

function testSimpleDelete($class) {
    $h = new Client_http();
    $h->acceptJson();
    echo "Testing ... $class\n";
    $result = $h->DELETE(__URL__.$class);
    echo "Result = $result \n*************************************\n";
    $h->close();
}

?>
