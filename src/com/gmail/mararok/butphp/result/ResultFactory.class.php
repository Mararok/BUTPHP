<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 * @package \com\gmail\mararok\butphp\result
 */
 
namespace com\gmail\mararok\butphp\result;
use \com\gmail\mararok\butphp\test as report;
use \com\gmail\mararok\butphp\test as test;

class ResultFactory {
	private $reporter;
	
	public function __construct(report\Reporter $reporter) {
		$this->reporter = $reporter;
	}	
	
	/**
	 * @return \com\gmail\mararok\butphp\result\TestEnviromentResult
	 */
	public function newTestResult() {
		$result = new TestEnviromentResult();
		$result->setReporter($this->getReporter());
		return $result;
	}
	
	/**
	 * @return \com\gmail\mararok\butphp\result\TestCaseResult
	 */
	public function newTestCaseResult() {
		$result = new TestCaseResult();
		$result->setReporter($this->getReporter());
		return $result;
	}
	
	/**
	 * @return \com\gmail\mararok\butphp\result\TestSuiteResult
	 */
	public function newTestSuiteResult() {
		$result = new TestSuiteResult();
		$result->setReporter($this->getReporter());
		return $result;
	}
	
	/**
	 * @return \com\gmail\mararok\butphp\report\Reporter
	 */
	public function getReporter() {
		return $this->reporter;
	}
}
?>