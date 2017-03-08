<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Network.php";

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $app->get('/', function() use($app) {
        $network = new Network([5,10,10,5]);
        $a = [1,0,0,0,1];
        // $array1 = [[1,2,3]];
        // $array2 = [[7],[9],[11]];
        // $result = Network::dot($array1,$array2);
        $result = $network->feedforward($a);



        var_dump($result);
        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    return $app;
?>
