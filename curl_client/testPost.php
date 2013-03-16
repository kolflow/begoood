<?php

/**
 * testPost.php : Tests all POSTS defined in index.php
 * This is not a formal test, is used just for depuration tasks
 * @author: laurinf
 **/

include_once 'Client_http.php';

const __URL__ = 'localhost/sysTestNonReg/';

//TODO - Only test post is being tested for the moment. We should do the same
// with the other classes.
$testClasses = ['tests','plans','answers','asserts','tests/3/answers','tests/3/asserts','tests/4/plans','tests/1/run','plans/2/run'];

$testData = [
             array('label-t' => 'Les nombres divisibles par 3 inférieurs ou égales à 20','label-q' => 'pr. aleatoire', 'uri-q'=>'localhost/QueryTest/1'),
             array('label-p' =>'plan de tests de programmes'),
             array('answer-value' => 'No'),
             array('label' => '|Rp| > 4 => Le nombre de reponses positives est supérieur a 4',
                   'code'=>'<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE assertion SYSTEM "assertion.dtd"><assertion><gt><card><Rp/></card><number>4</number></gt></assertion>'),
             array('id-a' => '11', 'status-u'=>'-','generatedBy' =>'Laurinf'),      
             array('id-assert'=>'2'),      
             array('id-p'=>'3'),
             array(),
             array()];
$i=0;
while ($i<count($testClasses)) {
    testSimplePost($testClasses[$i], $testData[$i]);
    $i++;
}

function testSimplePost($class, $data) {
  $h = new Client_http();
    $h->acceptJson();
    echo "Testing ... $class\n";
    $result = $h->POST(__URL__.$class,$data);
    echo "Result = $result \n*************************************\n";
    $h->close();
}
?>