<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 * @package com\gmail\mararok\butphp\result
 */
 
namespace com\gmail\mararok\butphp\result;
use \com\gmail\mararok\butphp\test as test;

class TestCaseResult extends TestResult {
	private $numberOfTests;
	private $testResults;
	
	public function __construct() {
		$this->numberOfTests = 0;
		$this->testResults = array();
	}	
	
	public function onStart(test\TestCaseElement $testCaseElement) {
		parent::onStart($testCaseElement);
		$this->getReporter()->onCaseStart($this);
	}	
	
	public function onEnd(test\TestCaseElement $testCaseElement) {
		parent::onEnd($testCaseElement);
		$this->getReporter()->onCaseEnd($this);
	}
	
	public function addTestEnviromentResult(TestEnviromentResult $testEnviromentResult) {
		$this->testResults[] = $testResult;
		$testEnviromentResult->setParentResult($this);
		
		++$this->numberOfTests;
	}
	
	public function getNumberOfTest() {
		return $this->numberOfTests;
	}
	
	public function getTestResults() {
		return $this->testResults;
	}

}
?>