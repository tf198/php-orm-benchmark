<?php
$ms = microtime(true);
$mem = memory_get_usage();

require dirname(__FILE__) . '/OptDormioTestSuite.php';

$test = new OptDormioTestSuite();
$test->start_time = $ms;
$test->start_mem = $mem;
$test->run();
