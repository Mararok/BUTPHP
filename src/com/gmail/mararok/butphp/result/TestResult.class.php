<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 * @package com\gmail\mararok\butphp\result
 */
 
namespace com\gmail\mararok\butphp\result;
use \com\gmail\mararok\butphp\test as test;
use \com\gmail\mararok\butphp\report as report;

class TestResult {
	private $name;
	private $description;
	private $ignored;
	
	private $parentResult;
	private $reporter;
	
	private $startTime;
	private $executeTime;

	public function onStart(test\TestElement $testElement) {
		$this->name = $testElement->getName();
		$this->startTime = time();
	}	
	
	public function onEnd(test\TestElement $testElement) {
		$this->description = $testElement->getDescription();
		$this->executeTime = time() - $this->startTime;
	}
	
	public function isIgnored() {
		return $this->ignored;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return string
	 */
	public function getFullname() {
		$fullname = ($this->parentResult != null)?$this->parentResult->getFullname():'';
		$fullname .= '.'.$this->getName();
		return $fullname;
	}
	
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * @return \com\gmail\mararok\butphp\result\TestResult
	 */
	public function getParentResult() {
		return $this->parentResult;
	}
	
	public function setParentResult(TestResult $newParentResult) {
		$this->parentResult = $newParentResult;
	}
	
	/**
	 * @return \com\gmail\mararok\butphp\report\Reporter
	 */
	public function getReporter() {
		return $this->reporter;
	}

	public function setReporter(report\Reporter $newReporter) {
		$this->reporter = $newReporter;
	}
}
?>