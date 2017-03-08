<?php
    require_once 'src/User.php';
    /**
       * @backupGlobals disabled
       * @backupStaticAttributes disabled
       */

       $server = 'mysql:host=localhost:8889;dbname=growth_test';
       $username = 'root';
       $password = 'root';
       $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
                User::deleteAll();
        }

        function test_save() {
            $name = 'Washington D.C.';
            $password = 0;
            $id = null;
            $test_user = new User($name, $password, $id);
            $test_user->save();

            $result = User::getAll();

            $this->assertEquals([$test_user], $result);
        }

        function test_find()
        {
            $name = 'Washington D.C.';
            $password = 0;
            $id = null;
            $test_user = new User($name, $password, $id);
            $test_user->save();

            $result = User::find($test_user->getId());

            $this->assertEquals($test_user, $result);
        }

    }

?>
