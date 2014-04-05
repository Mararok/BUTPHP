<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;

class TestCaseProcessor extends TestProcessor {
	private $currentTestCase;
	private $testEnviromentProcessor;
	
	public function __construct() {
		$this->testEnviromentProcessor = new TestEnviromentProcessor();
	}
	
	public function process() {
		$result = $this->getResultFactory()->newTestCaseResult();
		$result->onStart($this->currentTestCase);
			if ($this->currentTestCase->isIgnored()) {
				$result->onEnd($result);
				return $result;
			}
		
			$testEnviroment = new TestEnviromentElement();
			$testEnviroment->setContext($this->currentTestCase);
		
			$this->currentTestCase->test = new TestEnviroment($testEnviroment);
		
			foreach ($this->currentTestCase->getTestList() as $test) {
				$this->testEnviromentProcessor->setTest($test);
				$this->testEnviromentProcessor->setTestEnviroment($testEnviroment);
				$subResult = $this->testEnviromentProcessor->process();
				$result->addTestResult($subResult);
			}
		
		$result->onEnd($result);
		return $result;

	}
	
	public function setTestCase(TestCase $newTestCase) {
		$this->currentTestCase = $newTestCase;
	}
}
?>