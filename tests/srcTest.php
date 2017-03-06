<?php
    require_once 'src/src.php';

    class SourceTest extends PHPUnit_Framework_TestCase
    {
        function test_source_function() {
            $input = ' ';
            $test_source = new Source;

            $result = $test_source->test_function();

            $this->assertEquals(1, $result);
        }
    }



?>
