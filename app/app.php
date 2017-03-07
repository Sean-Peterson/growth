<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Map.php";

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $server = 'mysql:host=localhost:8889;dbname=growth';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->get('/', function() use($app) {
        $result = 'hello';
        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    $app->get('/hello', function() use($app) {
        $result = 'hello';
        return $result;
    });

    $app->post('/save_map', function() use ($app){
        //will save map here
        return json_encode($_POST['map']);
    });

    return $app;
?>
