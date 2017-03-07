<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Network.php";

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $app->get('/', function() use($app) {
        $network = new Network([2,3,1]);
        $array1 =         [
                    [1,2,3],
                    [4,5,6]
                ];
        $array2 =
                [
                    [7,8],
                    [9,10],
                    [11,12]
                ];
        var_dump($network->dot($array1, $array2));
        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    return $app;
?>
