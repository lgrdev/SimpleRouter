<?php

use Lgrdev\SimpleRouter\SimpleRouter;

require_once __DIR__ . '/../vendor/autoload.php';

$myrouter = new SimpleRouter();

$myrouter->addGet('/', function () {   echo 'Hello, I\'m the Home page '; });

$myrouter->addGet('/user/{id1:[0-9a-f]+}', function ($id1) {   echo 'Hello User ' . $id1; });

$myrouter->addGet('/phone/{id1:[0-9]+}/{?id2:[0-9]+}', function ($id1,$id2=null) {   echo 'Hello Phone ' . $id1 .' - '.$id2; });

$myrouter->run($_REQUEST['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
