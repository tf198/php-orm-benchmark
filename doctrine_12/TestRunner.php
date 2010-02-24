<?php

require dirname(__FILE__) . '/Doctrine12TestSuite.php';

$test = new Doctrine12TestSuite();
$test->initialize();
$test->run();
