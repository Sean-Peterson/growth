<?php
    require_once 'src/Map.php';
    /**
       * @backupGlobals disabled
       * @backupStaticAttributes disabled
       */

       $server = 'mysql:host=localhost:8889;dbname=growth_test';
       $username = 'root';
       $password = 'root';
       $DB = new PDO($server, $username, $password);

    class MapTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
                Map::deleteAll();
        }

        function test_save() {
            $title = 'Washington D.C.';
            $type = 0;
            $id = null;
            $creator_id = 43;
            $champion_id = 3;
            $champ_score = 642;
            $tiles = [];
            $test_map = new Map($title, $type, $id, $creator_id, $champion_id, $champ_score, $tiles);
            $test_map->save();

            $result = Map::getAll();

            $this->assertEquals([$test_map], $result);
        }

        function test_save_coordinates()
        {
            $title = 'Washington D.C.';
            $type = 0;
            $id = null;
            $creator_id = 43;
            $champion_id = 3;
            $champ_score = 642;
            $tiles = [[23, 34, 1], [23, 34, 1], [9, 43, 1], [5, 2, 1], [12, 3, 3], [1, 2, 3], [2, 32, 1], [4, 21, 3]];
            $test_map = new Map($title, $type, $id, $creator_id, $champion_id, $champ_score, $tiles);
            $test_map->save();

            $result = $test_map->getCoordinates();

            $this->assertEquals($tiles, $result);
        }

    }



?>
