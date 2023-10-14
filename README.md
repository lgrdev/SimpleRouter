# SimpleRouter

A very simple router for GET, POST, PUT, DELETE methods

<p align="center">
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/lgrdev/simplerouter/releases"><img src="https://img.shields.io/github/release/lgrdev/simplerouter.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Install

```
$ composer require lgrdev/simplerouter
```

## Usage

```php

$myrouter = new SimpleRouter();

// add route to home page
$myrouter->addGet('/', function () {   echo 'Hello, I\'m the home page'; } );

// route with a parameter
$myrouter->addGet('/book/{id}', function ($id) {   echo 'Hello, book #' . $id; } );

// route with a parameter id with format control
$myrouter->addGet('/book/{id:[0-9a-f]+}', function ($id) {   echo 'Hello, book #' . $id; } );

// route with a parameter and an optional parameter id2
$myrouter->addGet('/user/{id1}/{?id2}', function ($id1, $id2 = null) {   echo 'Hello User ' . $id; } );

// add a route for the method DELETE
$myrouter->addDelete('/book/{id:[0-9a-f]+}',  function ($id) {   echo 'Delete book #' . $id; } );

// add a POST route
$myrouter->addPost('/book', function ($id) {   echo 'Post a new book #'; } );

// display page
$myrouter->run($_REQUEST['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

```