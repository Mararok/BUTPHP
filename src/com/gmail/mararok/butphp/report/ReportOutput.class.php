<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\report;
use \com\gmail\mararok\butphp\test as test;

interface ReportOutput {
	public function onReportStart(test\ReportResult $result);
	public function onReportEnd(test\ReportResult $result);
	
	public function onSuiteStart(test\SuiteResult $result);
	public function onSuiteEnd(test\SuiteResult $result);
	
	public function onCaseStart(test\CaseResult $result);
	public function onCaseEnd(test\CaseResult $result);
	
	public function onTestStart(test\TestResult $result);
	public function onTestEnd(test\TestResult $result);
}
?>