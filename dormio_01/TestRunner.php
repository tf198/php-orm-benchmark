<?php

require dirname(__FILE__) . '/DormioTestSuite.php';

$test = new DormioTestSuite();
$test->initialize();
$test->run();
