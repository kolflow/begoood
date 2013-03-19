<?php

//require 'Slim/Slim.php';
//require 'Slim/View.php';
//\Slim\Slim::registerAutoloader();

require 'vendor/autoload.php';
include_once 'src/config/setup_app.php';

$app = new \Slim\Slim();
$app->contentType('application/json');

$app->get("/", function () {
    echo "This is TestApp System";
});

$app->get("/start", function () {
    $c = new Controller();
    echo $c->showStatus();
});

// GET route 

/**
 *  get the test with identifier $id
 */
$app->get("/tests/:id", function ($id) { 
            $c = new TestController();
            echo json_encode($c->listId($id));
});

/**
 *  list all tests
 */
$app->get("/tests", function () {
            $c = new TestController();
            echo json_encode($c->listAll());
        });

/** 
 * list all elements of a class (answer,assert,plan or report)
 * related to test $id  
 */
$app->get('/tests/:id/:class', function ($id, $class) {
            $c = new TestController();
            echo json_encode($c->listLinks($id, $class));
        });

/**
 * get the answer with identifier $id
 */
$app->get('/answers/:id', function ($id) {
            $c = new AnswerController();
            echo json_encode($c->listId($id));
        });
        
/**
 * list all answers
 */
$app->get('/answers', function () {
            $c = new AnswerController();
            echo json_encode($c->listAll());
        });
        
/**
 * lists all elements of a class 'tests' related to answer $id
 */
$app->get('/answers/:id/:class', function ($id, $class) {
            $c = new AnswerController();
            echo json_encode($c->listLinks($id, $class));
        });
        
/**
 * get the assert with identifier $id
 */
$app->get('/asserts/:id', function ($id) {
            $c = new AssertController();
            echo json_encode($c->listId($id));
        });
        
/**
 * list all asserts
 */
$app->get('/asserts', function () {
            $c = new AssertController();
            echo json_encode($c->listAll());
        });
        
/**
 *  list all elements of a class 'tests' related to assert $id
 */
$app->get('/asserts/:id/:class', function ($id, $class) {
            $c = new AssertController();
            echo json_encode($c->listLinks($id, $class));
        });
        
/**
 * get the plan with identifier $id
 */
$app->get('/plans/:id', function ($id) {
            $c = new PlanController();
            echo json_encode($c->listId($id));
        });
        
/**
 *  list all plans
 */
$app->get('/plans', function () {
            $c = new PlanController();
            echo json_encode($c->listAll());
        });
        
/**
 *  list all elements of a class (tests, reports) related to plan $id
 */
$app->get('/plans/:id/:class', function ($id, $class) {
            $c = new PlanController();
            echo json_encode($c->listLinks($id, $class));
        });
        
/**
 * get the report with identifier $id
 */
$app->get('/reports/:id', function ($id) {
            $c = new ReportController();
            echo json_encode($c->listId($id));
        });
        
/**
 * list all reports
 */
$app->get('/reports', function () {
            $c = new ReportController();
            echo json_encode($c->listAll());
        });
        
/**
 * list all elements (tests, plans) related to report $id
 */
$app->get('/reports/:id/:class', function ($id, $class) {
            $c = new ReportController();
            echo json_encode($c->listLinks($id, $class));
        });




// POST route

/**
 *  insert a new test 
 */
$app->post('/tests', function () use ($app) {
            $v = $app->request()->post();
            $t = new TestController();
            echo json_encode($t->create($v));
        });

/**
 *  insert a new plan 
 */
$app->post('/plans', function () use ($app) {
            $v = $app->request()->post();
            $p = new PlanController();
            echo json_encode($p->create($v));
        });

/**
 *  insert a new assert 
 */
$app->post('/asserts', function () use($app) {
            $v = $app->request()->post();
            $a = new AssertController();
            echo json_encode($a->create($v));
        });
        
/**
 *  insert a new answer
 */
$app->post('/answers', function () use($app) {
            $v = $app->request()->post();
            $a = new AnswerController();
            echo json_encode($a->create($v));
        });

/**
 *  insert a new report
 */
$app->post('/reports', function () use($app) {
            $v = $app->request()->post();
            $r = new ReportController($v['type']);
            echo json_encode($r->create($v));
        });
        
        
/**
 *  insert a link of test to another class (plans, answers or asserts)
 *  $v must contain the necessary identifier (id-p, id-a or id-assert)
 *  or run a test with identifier $id
 */

$app->post('/tests/:id/:class', function ($id, $class) use ($app) {
            $v = $app->request()->post();
            $t = new TestController();
            if ($class == 'run') {
                echo json_encode($t->run($id));
            } else {
            echo json_encode($t->createLink($id, $v, $class));
            }
        });

/**
 * run a plan with identifier $id
 */
$app->post('/plans/:id/run', function ($id) use ($app) {
            $v = $app->request()->post();
            $p = new PlanController();
            echo json_encode($p->run($id));
   });

   
   
// PUT route

/**
 * modify test with id $id.
 * $v must contain new values for the test attributes
 */
$app->put('/tests/:id', function ($id) use ($app) {
            $v = $app->request()->put();
            $t = new TestController();
            echo json_encode($t->modify($id, $v));
        });

/**
 * modify assert with id $id. 
 * $v must contain new values for the assert attributes
 */
$app->put('/asserts/:id', function ($id) use ($app) {
            $v = $app->request()->put();
            $a = new AssertController();
            echo json_encode($a->modify($id, $v));
        });
        
/**
 * modify report with id $id. 
 * $v must contain new values for the report attributes
 */
$app->put('/reports/:id', function ($id) use ($app) {
            $v = $app->request()->put();
            $a = new ReportController($v['type']);
            echo json_encode($a->modify($id, $v));
        });
        
/**
 * modify answer with id $id. 
 * $v must contain new values for the answer attributes
 */
$app->put('/answers/:id', function ($id) use ($app) {
            $v = $app->request()->put();
            $a = new AnswerController();
            echo json_encode($a->modify($id, $v));
        });
        
/**
 * modify plan with id $id. 
 * $v must contain new values for the plan attributes
 */
$app->put('/plans/:id', function ($id) use ($app) {
            $v = $app->request()->put();
            $p = new PlanController();
            echo json_encode($p->modify($id, $v));
        });        
        

/**
 *  modifiy or deletes the link from test to another element of a class.
 *  to indicate the operation we want to execute, we will include a parameter
 *  operation: 
 *
 *    'operation' = 'modification'. It is used in two different ways:
 *      1. To modify parameters like status-t in links between a test and an answer
 *         in which case, there $v must contain the identifier of the answer (id-a)
 *         and the new value for parameter status-t.
 *      2. To modify the link to a class. For instance, if we want to remove a test
 *         from a plan and put it into another. In this case, $v must contain an index oldid-p
 *         and another one newid-p. See modifyLink() doc for more info.
 * 
 *    'operation' = 'deletion'. It is used to remove a link between a test and 
 *    another specific element of a class. 
 *    Note that this will just remove the link between a test and another class object
 *    but both objets will still remain there as thay may have still another links
 * 
 *    If you want to completely remove an answer associated to a test, you have
 *    to use /answers/:idanswer and then /tests/:idtest/answer 
 
 */
$app->put('/tests/:id/:class', function ($id, $class)use ($app) {
            $v = $app->request()->put();
            $t = new TestController();
            echo json_encode($t->modifyLink($id, $class, $v));
        });




// DELETE route


/**
 *  remove all tests
 */
$app->delete('/tests', function () {
            $c = new TestController();
            echo json_encode($c->removeAll());
        });

/**
 *  remove test with id $id
 */
$app->delete('/tests/:id', function ($id) {
            $c = new TestController();
            echo json_encode($c->removeById($id));
        });

/**
 * remove all plans 
 */
$app->delete('/plans', function () {
            $c = new PlanController();
            echo json_encode($c->removeAll());
        });

/**
 * remove plan with id $id
 */
$app->delete('/plans/:id', function ($id) {
            $c = new PlanController();
            echo json_encode($c->removeById($id));
        });

/**
 * remove all links bound to the test $id 
 * or a specific link if $v contains an index representing a identifier of an object.
 * 
 * Note that this will just remove the link between a test and all associated objects
 * belonging to a class but all objets will still remain there as thay may have still
 * another links
 * 
 * If you want to completely remove an answer associated to a test, you have
 * to use /answers/:idanswer and then /tests/:idtest/answer 
 * 
 * If you want to completely remove a test and all links bound to this,
 * you have to call delete /tests/3 and then /tests/3/plans, /tests/3/answers,
 * /tests/3/asserts but this is not recommended as the answers or asserts 
 * may belong to another test ...
 * 
 */
$app->delete('/tests/:id/:class', function ($id, $class) {
            $c = new TestController();
            echo json_encode($c->removeLink($id, $class));
        });

/**
 * Run the Slim application
 *
 * This executes the Slim application and returns the HTTP response to the HTTP client.
 */
$app->run();
?>