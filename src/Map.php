<?php
    class Map
    {
        private $title;
        private $type;
        private $id;
        private $creator_id;
        private $champion_id;
        private $champ_score;
        private $tiles;

        function __construct($title, $type, $id = null, $creator_id = null, $champion_id = null, $champ_score = null, $tiles = null)
        {
            $this->title = (string) $title;
            $this->type = (int) $type;
            $this->id = $id;
            $this->creator_id = $creator_id;
            $this->champion_id = $champion_id;
            $this->champ_score = $champ_score;
            $this->tiles = $tiles;
        }

        function getId()
        {
            return $this->id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getType()
        {
            return $this->type;
        }

        function setType($new_type)
        {
            $this->type = (int) $new_type;
        }

        function getTiles()
        {
            return $this->tiles;
        }

        function setTiles($new_tiles)
        {
            $this->tiles = $new_tiles;
        }

        function getCreatorId()
        {
            return $this->creator_id;
        }

        function setCreatorId($new_creator_id)
        {
            $this->creator_id = (int) $new_creator_id;
        }

        function getChampionId()
        {
            return $this->champion_id;
        }

        function setChampionId($new_champion_id)
        {
            $this->champion_id = (int) $new_champion_id;
        }

        function getChampScore()
        {
            return $this->champ_score;
        }

        function setChampScore($new_champ_score)
        {
            $this->champ_score = (int) $new_champ_score;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO maps (title, type, creator_id, champion_id, champ_score) VALUES ('{$this->getTitle()}', {$this->getType()}, {$this->getCreatorId()}, {$this->getChampionId()}, {$this->getChampScore()});");
            $this->id = $GLOBALS['DB']->lastInsertId();

            foreach($this->tiles as $tile){
                $GLOBALS['DB']->exec("INSERT INTO map_coordinates (map_id, x, y, player_int) VALUES ({$this->getId()}, {$tile[0]}, {$tile[1]}, {$tile[2]});");
            }
        }

        function getCoordinates()
        {
            $tiles = [];
            $coords = $GLOBALS['DB']->query("SELECT * FROM map_coordinates WHERE map_id = {$this->getId()};");
            foreach($coords as $tile)
            {
                array_push($tiles, [$tile['x'], $tile['y'], $tile['player_int']]);
            }
            return $tiles;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM maps WHERE id={$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM map_coordinates WHERE map_id={$this->getId()};");

        }

        static function find($id)
        {
            return $GLOBALS['DB']->query("SELECT FROM maps WHERE id={$id};")->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Map", ['title', 'type', 'id', 'creator_id', 'champion_id', 'champ_score'])[0];//may need to break apart
        }

        static function getAll()
        {
            $maps = [];

            $returned_maps = $GLOBALS['DB']->query("SELECT * FROM maps;");
            foreach($returned_maps as $map)
            {
                $new_map = new Map($map['title'], $map['type'], $map['id'], $map['creator_id'], $map['champion_id'], $map['champ_score'],[]);
                array_push($maps, $new_map);
            }
            return $maps;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM maps;");
            $GLOBALS['DB']->exec("DELETE FROM map_coordinates;");

        }

    }

?>
