<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\report;
use \com\gmail\mararok\butphp\result as result;

class Reporter implements ReportOutput {
	private $reportOutputs;
	
	public function __construct() {
		$this->reportOutputs = array();
	}
	
	public function addOutput(ReportOutput $reportOutput) {
		$this->reportOutput[] = $reportOutput;
	}

	
	public function onReportStart(result\ReportResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onReportStart($result);
		}
	}

	public function onReportEnd(result\ReportResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onReportEnd($result);
		}
	}

	public function onSuiteStart(result\SuiteResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onSuiteStart($result);
		}
	}

	
	public function onSuiteEnd(result\SuiteResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onSuiteEnd($result);
		}
	}

	
	public function onCaseStart(result\CaseResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onCaseStart($result);
		}
	}

	public function onCaseEnd(result\CaseResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onCaseEnd($result);
		}
	}

	
	public function onTestStart(result\TestResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onTestStart($result);
		}
	}

	public function onTestEnd(result\TestResult $result) {
		foreach ($this->reportOutputs as $output) {
			$output->onTestEnd($result);
		}
	}	
	
}
?>