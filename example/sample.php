<?php

use Lgrdev\SimpleRouter\SimpleRouter;

require_once __DIR__ . '/../vendor/autoload.php';

$myrouter = new SimpleRouter();

// voir pour tester si user = UseR
// $myrouter->addGet('/', function () { echo 'Hello World, I\'m home page'; });

// preg_match (\/user\/)(\d+)((\/)(\d+))?  '/user/1/2'
// $myrouter->addGet('/user/{id:[0-9a-f]+}/{id1}', function ($id, $id1) {   echo 'Hello User ' . $id . ' - ' . $id1; });
$myrouter->addGet('/user/{id1:[0-9]+}/{?id2:[0-9]+}', function ($id=null) {   echo 'Hello User ' . $id; });


// $myrouter->run('GET', '/');

$myrouter->run('GET', '/user/125/238');

$myrouter->run($_REQUEST['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
