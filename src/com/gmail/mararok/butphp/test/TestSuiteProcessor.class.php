<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;

class TestSuiteProcessor extends TestProcessor {
	private $currentTestSuite;
	
	private $testCaseProcessor;
	private $testSuiteProcessor;
	
	public function __construct() {
		$this->testCaseProcessor = new TestCaseProcessor();
		$this->testSuiteProcessor = new TestSuiteProcessor();
	}
	
	public function process() {
		$result = $this->getResultFactory()->newTestSuiteResult($this->currentTestSuite);
		$result->onStart();
			if ($this->currentTestCase->isIgnored()) {
				$result->onEnd($result);
				return $result;
			}
			// processing sub test suite list.
			foreach ($this->currentTestSuite->getTestSuiteList() as $testSuite) {
				$this->testSuiteProcessor->setTestSuite($testSuite);
				$subResult = $this->testSuiteProcessor->process();
				$result->addTestSuiteResult($subResult);
			}
			$this->currentTestSuite = null;
			
			// processing sub test case list.
			foreach ($this->currentTestSuite->getTestCaseList() as $testCase) {
				$this->testCaseProcessor->setTestCase($testCase);
				$subResult = $this->testCaseProcessor->process();
				$result->addTestCaseResult($subResult);
			}
			$this->currentTestCase = null;
			
		$result->onEnd();
		return $result;
	}
	
	
	public function setTestSuite(TestSuiteElement $newTestSuite) {
		$this->currentTestSuite = $newTestSuite;
	}
}
?>