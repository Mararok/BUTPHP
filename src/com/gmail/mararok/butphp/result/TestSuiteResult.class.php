<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\result;
use \com\gmail\mararok\butphp\test as test;

class TestSuiteResult extends Result {
	private $numberOfTest;
	private $numberOfTestCase;
	private $numberOfTestSuite;
	
	private $testCaseResults;
	private $testSuiteResults;
	
	public function __construct() {
		$this->numberOfTest = 0;
		$this->numberOfTestCase = 0;
		$this->numberOfTestSuite = 0;
		
		$this->testCaseResults = array();
		$this->testSuiteResults = array();
	}	

	public function onStart(test\TestSuiteElement $testSuiteElement) {
		parent::onStart($testSuiteElement);
		$this->getReporter()->onSuiteStart($this);
	}	
	
	public function onEnd(test\TestSuiteElement $testSuiteElement) {
		parent::onEnd($testSuiteElement);
		$this->getReporter()->onSuiteEnd($this);
	}
	
	public function addTestCaseResult(TestCaseResult $testCaseResult) {
		$this->testCaseResults[] = $testCaseResult;
		$testCaseResult->setParentResult($this);
		
		++$this->numberOfTestCase;
		
		$this->numberOfTest += $testCaseResult->getNumberOfTest(); 
	}
	
	public function addTestSuiteResult(TestCaseResult $testSuiteResult) {
		$this->testSuiteResults[] = $testSuiteResult;
		$testSuiteResult->setParentResult($this);
		
		++$this->numberOfTestSuite;
		
		$this->numberOfTest += $testSuiteResult->getNumberOfTest();
		$this->numberOfTestCase += $testSuiteResult->getNumberOfTestCase(); 
		$this->numberOfTestSuite += $testSuiteResult->getNumberOfTestSuite();
	}
	
	public function getNumberOfTest() {
		return $this->numberOfTest;
	}
	
	public function getNumberOfTestCase() {
		return $this->numberOfTestCase;
	}
	
	public function getNumberOfTestSuite() {
		return $this->numberOfTestSuite;
	}
	
	public function getTestCaseResults() {
		return $this->testCaseResults;
	}
	
	public function getTestSuiteResults() {
		return $this->testSuiteResults;
	}
}
?>