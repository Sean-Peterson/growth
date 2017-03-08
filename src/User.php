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
        }

        function getGames()
        {

        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM users WHERE id={$this->getId()};");
            // MAYBE ADD FUNCTIONALITY
            // $GLOBALS['DB']->exec("DELETE FROM games WHERE user_id={$this->getId()};");

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
