<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Map.php";
    require_once __DIR__."/../src/Network.php";


    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $app['debug']= true;

    $server = 'mysql:host=localhost:8889;dbname=growth';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->get('/', function() use($app) {
        $network = new Network([5,10,10,5]);
        $a = [1,0,0,0,1];
        // $array1 = [[1,2,3]];
        // $array2 = [[7],[9],[11]];
        // $result = Network::dot($array1,$array2);
        $result = $network->feedforward($a);




        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    $app->get('/hello', function() use($app) {
        $result = 'hello';
        return $result;
    });
    $app->get('/deleteAll', function() use($app) {
        Map::deleteAll();
        return $app->redirect("/");
    });

    $app->post('/save_map', function() use ($app){
        //will save map here
        $map = new Map($_POST['title'], $_POST['type'], null, null, null, null, $_POST['map']);
        
        $map->save();


        return json_encode($_POST['map']);
    });

    return $app;
?>
