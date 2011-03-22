<?
require dirname(__FILE__) . '/Doctrine12WithCacheTestSuite.php';

$test = new Doctrine12WithCacheTestSuite();
$test->initialize();
$test->run();
?>