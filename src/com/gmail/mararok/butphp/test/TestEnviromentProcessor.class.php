<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 * @package \com\gmail\mararok\butphp\test
 */
 
namespace com\gmail\mararok\butphp\test;

class TestEnviromentProcessor extends TestProcessor {
	private $currentTest;
	private $currentTestEnviroment;
	
	public function process() {
		$result = $this->getResultFactory()->newTestEnviromentResult($this->currentTestEnviroment);
		$result->oneStart($this->currentTestEnviroment);
			$currentTestEnviroment->executeTest($this->currentTest,$result);
		$result->oneEnd($this->currentTestEnviroment);
		return $result;
	}
	
	public function setTestEnviroment(TestEnviroment $newTestEnviroment) {
		$this->currentTestEnviroment = $newTestEnviroment;
	}
	
	public function setTest($newTest) {
		$this->currentTest = $newTest;
	}
}
?>