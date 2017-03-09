<?php
    class User
    {
        private $name;
        private $password;
        private $id;

        function __construct($name, $password, $id = null)
        {
            $this->name = (string) $name;
            $this->password = (string) $password;
            $this->id = $id;

        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getPassword()
        {
            return $this->password;
        }

        function setPassword($new_password)
        {
            $this->password = (string) $new_password;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO users (name, password) VALUES ('{$this->getName()}', '{$this->getPassword()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
            $_SESSION['user'] = $this;
        }

        function saveGame($start_conditions, $map_id, $winner_score, $player_int, $winner)
        {
            //if winner save winner score, insert $game_score
            $game_score = $winner_score;
            if($winner !== $player_int){
                $game_score = 1600 - $winner_score;
            }

            $GLOBALS['DB']->exec("INSERT INTO games (user_id, map_id, game_score, player_int, winner) VALUES ({$this->getId()}, {$map_id}, {$game_score}, {$player_int}, {$winner});");

            $game_id = $GLOBALS['DB']->lastInsertId();

            foreach($start_conditions as $tile){
                $GLOBALS['DB']->exec("INSERT INTO map_history_coordinates (map_id, x, y, player_int) VALUES ({$game_id}, {$tile[0]}, {$tile[1]}, {$tile[2]});");
            }
        }

        function getGames()
        {
            $games = [];
            $returned_games = $GLOBALS['DB']->query("SELECT * FROM games WHERE user_id = {$this->getId()};");
            foreach ($returned_games as $game) {

                $coords = [];
                $id = $game['id'];
                $game_coords = $GLOBALS['DB']->query("SELECT * FROM game_history_coordinates WHERE game_id = {$id};");
                foreach ($game_coords as $tile) {
                    array_push($coords, [$tile['x'],$tile['y'],$tile['player_int']]);
                }

                array_push($games, [$coords, $game['map_id'], $game['game_score'], $game['player_int'], $game['winner']]);
            }
            return $games;
        }

        function getMaps()
        {
            $returned_maps = $GLOBALS['DB']->query("SELECT * FROM maps WHERE creator_id={$this->getId};")->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Map", ['title', 'type', 'id', 'creator_id', 'champion_id', 'champ_score']);
            $returned_map->setTiles($returned_map->getCoordinates());
            return $returned_maps;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM users WHERE id={$this->getId()};");
            // MAYBE ADD FUNCTIONALITY
            // $GLOBALS['DB']->exec("DELETE FROM games WHERE user_id={$this->getId()};");

        }

        static function logIn($uname, $upassword)
        {
            $user = $GLOBALS['DB']->query("SELECT * FROM users WHERE name = '{$uname}' AND password = '{$upassword}';");

            if($user)
            {
                $new_user = $user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User", ['name', 'password', 'id'])[0];

                $_SESSION['user'] = $new_user;
            }
        }

        function logOut()
        {
            $_SESSION['user'] = [];
        }

        static function find($id)
        {
            $returned_user = $GLOBALS['DB']->query("SELECT * FROM users WHERE id={$id};")->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User", ['name', 'password', 'id'])[0];

            return $returned_user;
        }

        static function getAll()
        {
            $users = [];

            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            foreach($returned_users as $user)
            {
                $new_user = new User($user['name'], $user['password'], $user['id']);
                array_push($users, $new_user);
            }
            return $users;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM users;");
            //DELETE GAMES ASSOCIATED WITH PLAYER?
            // $GLOBALS['DB']->exec("DELETE FROM games WHERE user_id = {$this->getId()};");

        }
    }

?>
