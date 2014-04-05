<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 * @package com\gmail\mararok\butphp\result
 */
 
namespace com\gmail\mararok\butphp\result;
use \com\gmail\mararok\butphp\test as test;

class TestEnviromentResult extends TestResult {
	private $unexpectedResults = null;
	
	public function __construct() {
	}	
	
	public function onStart(test\TestEnviromentElement $testEnviromentElement) {
		parent::onStart($testEnviromentElement);
		$this->getReporter()->onTestStart($this);
	}	
	
	public function onEnd(test\TestEnviromentElement $testEnviromentElement) {
		parent::onEnd($testEnviromentElement);
		$this->getReporter()->onTestEnd($this);
	}
	
	public function addUnexpectedResults(UnexpectedResult $unexpectedResult) {
		if ($this->unexpectedResults === null) {
			$this->unexpectedResults = array($unexpectedResult);
		} else {
			$this->unexpectedResults[] = $unexpectedResult;
		}
		
	}
	
	public function hasUnexpectedResults() {
		reutrn ($this->unexpectedResults === null);
	}
	
	public function getUnexpectedResults() {
		return $this->unexpectedResults;
	}
}
?>