# SimpleRouter


$myrouter = new SimpleRouter();

$myrouter->addGet('/', 
                    function () {   echo 'Hello, I\'m the home page'; }
                 );

$myrouter->addGet('/book/{id}', 
                    function ($id) {   echo 'Hello, book #' . $id; }
                 );


$myrouter->addGet('/book/{id:[0-9a-f]+}', 
                    function ($id) {   echo 'Hello, book #' . $id; }
                 );


$myrouter->addGet('/user/{id1}/{?id2}', 
                    function ($id1, $id2 = null) {   echo 'Hello User ' . $id; }
                 );

$myrouter->addDelete('/book/{id:[0-9a-f]+}', 
                    function ($id) {   echo 'Hello book #' . $id; }
                 );

$myrouter->addPost('/book/{id:[0-9a-f]+}', 
                    function ($id) {   echo 'Hello book #' . $id; }
                 );

$myrouter->run($_REQUEST['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);