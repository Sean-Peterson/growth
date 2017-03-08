<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Network.php";

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $app->get('/', function() use($app) {
        $network = new Network([2,3,2]);
        $a = [1,0];
        // $array1 = [[1],[2]];
        // $array2 = [[3,4,5]];
        // $result = Network::dot($array1,$array2);
        $result = $network->feedforward($a);
        $result = $network->backprop([1,0],[0,1]);
        // var_dump($result);

        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    return $app;
?>
