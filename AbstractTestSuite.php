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
	
	public function run()
	{
		$t1 =  $this->runTest('runAuthorInsertion', 1600);
		$t1 += $this->runTest('runBookInsertion', 1600);
		$t2 = $this->runTest('runPKSearch', 1800);
		$t3 = $this->runTest('runComplexQuery', 200);
		$t4 = $this->runTest('runHydrate', 750);
		$t5 = $this->runTest('runJoinSearch', 700);
		echo sprintf("%30s | %6d | %6d | %6d | %6d | %6d |\n", get_class($this), $t1, $t2, $t3, $t4, $t5);
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