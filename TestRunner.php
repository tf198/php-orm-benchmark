<?php

require dirname(__FILE__) . '/propel_15/Propel15TestSuite.php';

$test = new Propel15TestSuite();
$test->initialize();
$test->run();

require dirname(__FILE__) . '/raw_pdo/PDOTestSuite.php';

$test = new PDOTestSuite();
$test->initialize();
$test->run();