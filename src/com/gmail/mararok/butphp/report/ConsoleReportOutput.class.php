<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\report;
use \com\gmail\mararok\butphp\result as result;
 
class ConsoleReportOutput implements ReportOutput {
	private $paddingLevel;
	private $paddingLevelBuffer;
	private $failureTestsResult;
	
	public function __construct() {
		$this->paddingLevel = 0;
		$this->paddingLevelBuffer = '';
		$this->failureTestsResult = array();
	}
	
	public function onReportStart(result\ReportResult $result) {
		$this->printf("Report %s \n",$result->getName());
		$this->println("##############################################################");
		$this->incLevel();
	}

	public function onReportEnd(result\ReportResult $result) {
		$this->decLevel();
		$this->println("##############################################################");
		$this->printf("Report end in %f s \n",(double)$result->getExecuteTime()/1000.0);
		$this->printf("%d suites, %d cases, %d tests \n",
				$result->getSuitesAmount(),$result->getCasesAmount(),$result->getTestsAmount());
		$this->printFailureTests();
	}

	public function onSuiteStart(result\SuiteResult $result) {
		$this->onStart($result,'S:%s end in %f s \n');
	}

	
	public function onSuiteEnd(result\SuiteResult $result) {
		$this->onEnd($result,'S:%s end in %f s \n');
	}

	
	public function onCaseStart(result\CaseResult $result) {
		$this->onStart($result,'C:%s \n');
	}

	public function onCaseEnd(result\CaseResult $result) {
		$this->onEnd($result,'C:%s end in %f s \n');
	}

	
	public function onTestStart(result\TestResult $result) {
		$this->onStart($result,'%s ');
	}

	public function onTestEnd(result\TestResult $result) {
		$unexpectedResults = $result->getUnexpectedResults();
		if (count($unexpectedResults) > 0 ) {
			$this->failureTestsResults.add($result);
			$this->println("");
			$this->printUnexpectedResults(ers);
			$this->onEnd($result,'%s end in %f s \n');
		} else {
			$this->onEnd($result,'%s end in %f s \n');
		}
	}	
	
	private function onStart(result\Result $result,$format) {
		$this->printf($format,$result->getName());
		$this->incLevel();
	}
	
	private function onEnd(result\Result $result,$format) {
		$this->decLevel();
		$this->printf($format,$result->getName(),(double)$result->getExecuteTime()/1000.0);
	}
	
	private function println($message) {
		$this->println($this->paddingLevelBuffer + message);
	}
	
	private function incLevel() {
		++$this->paddingLevel;
		$this->paddingLevelBuffer + '#';
	}
	
	private function decLevel() {
		--$this->paddingLevel;
		substr($this->paddingLevelBuffer,0,paddingLevel);
	}
	
	private function printf($format) {
		printf($this->paddingLevelBuffer+$format,func_get_args());
	}
	
	private function printUnexpectedResults($unexpectedResults) {
		foreach ($unexpectedResult as $eresult) {
			printf("%s:%d expected %s \n",$eresult->getSourceName(),$eresult->getLineNumber(),$eresult->getMatchMessage());
		}
	}
	private function printFailureTests() {
		if (count($this->failureTestsResult) > 0) {
			$this->println("Failures tests: ");
			$this->incLevel();
			foreach ($this->failureTestsResult as $result) {
				$this->printf("%s \n",$result->getName());
				$this->incLevel();
					$this->printUnexpectedResults($result->getUnexpectedResults());
				$this->decLevel();
			}
			$this->decLevel();
		}
	}
	
}
?>