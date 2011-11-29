<?php

require_once dirname(__FILE__) . '/sfTimer.php';

abstract class AbstractTestSuite
{
	protected $books = array();
	protected $authors = array();
	
	const NB_TEST = 1000;
	
	abstract function initialize();
	abstract function clearCache();
	abstract function beginTransaction();
	abstract function commit();
	abstract function runAuthorInsertion($i);
	abstract function runBookInsertion($i);
	abstract function runPKSearch($i);
	abstract function runComplexQuery($i);
	abstract function runHydrate($i);
	abstract function runJoinSearch($i);
	
	public function initTables()
	{
		try {
			$this->con->exec('DROP TABLE [book]');
			$this->con->exec('DROP TABLE [author]');
		} catch (PDOException $e) {
			// do nothing - the tables probably don't exist yet
		}
		$this->con->exec('CREATE TABLE [book]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[title] VARCHAR(255)  NOT NULL,
			[isbn] VARCHAR(24)  NOT NULL,
			[price] FLOAT,
			[author_id] INTEGER
		)');
		$this->con->exec('CREATE TABLE [author]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[first_name] VARCHAR(128)  NOT NULL,
			[last_name] VARCHAR(128)  NOT NULL,
			[email] VARCHAR(128)
		)');
	}
	
	public function run()
	{

    $config = include dirname(__FILE__) . '/config.php';
    
    $t = array();
    $tests = array_keys($config);
    for($i=0; $i<count($tests); $i++) {
      $t[$i] = $this->runTest($tests[$i], $config[$tests[$i]]);
    }
    $mem = memory_get_peak_usage() / (1024*1024);
		echo sprintf("%20s | %6d | %6d | %6d | %6d | %6d | %6.2f |\n", 
      substr(get_class($this), 0, -9), $t[0]+$t[1], $t[2], $t[3], $t[4], $t[5], $mem);
	}
	
	public function runTest($methodName, $nbTest = self::NB_TEST)
	{
		$this->clearCache();
		$this->beginTransaction();
		$timer = new sfTimer();
		for($i=0; $i<$nbTest; $i++) {
			$this->$methodName($i);
		}
		$t = $timer->getElapsedTime();
		$this->commit();
		return $t * 1000;
	}
	
	
}