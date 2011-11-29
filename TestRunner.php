<?php

echo "                     | Insert | findPk | complex| hydrate|  with  |     MB |\n";
echo "                     |--------|--------|--------|--------|--------|--------|\n";

//passthru('php raw_pdo/OptTestRunner.php');
passthru('php raw_pdo/TestRunner.php');

if(file_exists('dormio_01/vendor/dormio/classes')) {
  passthru('php dormio_01/OptTestRunner.php');
  passthru('php dormio_01/TestRunner.php');
}

if(file_exists('outlet_07/vendor/outlet/classes')) {
  passthru('php outlet_07/TestRunner.php');
}

if(file_exists('propel_14/vendor/propel/runtime')) {
  passthru('php propel_14/TestRunner.php');
}

if(file_exists('propel_15/vendor/propel/runtime')) {
  passthru('php propel_15/TestRunner.php');
  passthru('php propel_15_with_cache/TestRunner.php');
}

if(file_exists('doctrine_12/vendor/doctrine/lib')) {
  passthru('php doctrine_12/TestRunner.php');
}
//passthru('php doctrine_2/TestRunner.php');