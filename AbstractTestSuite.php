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
	abstract function runSearch($i);
	abstract function runJoinSearch($i);
	
	public function run()
	{
		$t1 =  $this->runTest('runAuthorInsertion');
		$t1 += $this->runTest('runBookInsertion');
		$t2 = $this->runTest('runPKSearch', 5000);
		$t3 = $this->runTest('runSearch', 1200);
		$t4 = $this->runTest('runJoinSearch', 800);
		echo sprintf("%20s | %6d | %6d | %6d | %6d |\n", get_class($this), $t1, $t2, $t3, $t4);
	}
	
	public function runTest($methodName, $nbTest = self::NB_TEST)
	{
		$this->clearCache();
		$callable = array($this, $methodName);
		$this->beginTransaction();
		$timer = new sfTimer();
		for($i=0; $i<$nbTest; $i++) {
			call_user_func($callable, $i);
		}
		$t = $timer->getElapsedTime();
		$this->commit();
		return $t * 1000;
	}
	
	
}