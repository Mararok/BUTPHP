<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;

class TestSuite extends TestElement {
	private $testCaseList;
	private $testSuiteList;
	
	public function __construct($name) {
		parent::__construct($name);
		$this->testCaseList = array();
		$this->testSuiteList = array();
	}
	
	public function addTestCase(TestCase $testCase) {
		$this->testCaseList[] = $testCase;
	}
	
	public function addTestSuite(TestSuite $testSuite) {
		$this->testSuiteList[] = $testSuite;
	}
	
	public function getTestCaseList() {
		return $this->testCaseList;
	}
	
	public function getTestSuiteList() {
		return $this->testSuiteList;
	}
}
?>