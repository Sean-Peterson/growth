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
        $network = new Network([2,3,2]);
        $a = [1,0];
        $b = [0,1];
        $c = [1,1];
        // $array1 = [[1,2,3],[4,5,6],[7,8,9]];
        // $array2 = [[3],[4],[5]];
        // $result = Network::dot($array1,$array2);
        for($i=0;$i<100;$i++){
            $network->backprop([1,0],[0,1],.1);
            $network->backprop([0,1],[1,0],.1);
            // var_dump($network->feedforward($a));
            // var_dump($network->feedforward($b));
            // var_dump($network->feedforward($c));
            // $network->backprop([0,1],[0,1],.1);å
            // var_dump($network->feedforward($a));
            // var_dump($network->feedforward($b));
            // var_dump($network->feedforward($c));
            // $network->backprop([1,1],[1,1],.1);
            // var_dump($network->feedforward($a));
            // var_dump($network->feedforward($b));
            // var_dump($network->feedforward($c));
        }
        $result = ($network->feedforward($c));
        // var_dump($network->feedforward($b));
        // var_dump($network->feedforward($c));




        var_dump($result);


        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    $app->get('/hello', function() use($app) {
        $result = 'hello';
        return $result;
    });

    $app->post('/save_map', function() use ($app){
        //will save map here
        $map = new Map($_POST['title'], $_POST['type'], null, null, null, null, $_POST['map']);
        $map->save();

        return json_encode($map->getCoordinates());
    });

    return $app;
?>
