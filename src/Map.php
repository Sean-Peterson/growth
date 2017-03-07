<?php
    class Map
    {
        private $title;
        private $type;
        private $id;
        private $player_id;
        private $champion;
        private $champ_score;

        function __construct($title, $type, $id = null, $player_id = null, $champion = null, $champ_score = null)
        {
            $this->title = (string) $title;
            $this->type = (int) $type;
            $this->id = $id;
            $this->player_id = $player_id;
            $this->champion = $champion;
            $this->champ_score = $champ_score;
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

        function getPlayerId()
        {
            return $this->player_id;
        }

        function setPlayerId($new_player_id)
        {
            $this->player_id = (int) $new_player_id;
        }

        function getChampion()
        {
            return $this->champion;
        }

        function setChampion($new_champion)
        {
            $this->champion = (int) $new_champion;
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
            
        }

    }

?>
