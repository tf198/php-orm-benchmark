<?php

echo "                     | Insert | findPk |   find |   with |\n";
echo "                     |--------|--------|--------|------- |\n";

passthru('php raw_pdo/TestRunner.php');
passthru('php propel_14/TestRunner.php');
passthru('php propel_15/TestRunner.php');
passthru('php doctrine_12/TestRunner.php');