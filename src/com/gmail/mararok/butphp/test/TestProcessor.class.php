<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 * @package com\gmail\mararok\butphp\test
 */
 
namespace com\gmail\mararok\butphp\test;
use com\gmail\mararok\butphp\result as result;

class TestProcessor {
	private $resultFactory;
	
	/**
	 * @return \com\gmail\mararok\butphp\result\Result
	 */
	public abstract function process();
	
	public function setResultFactory(result\ResultFactory $newResultFactory) {
		$this->resultFactory = $newResultFactory;
	}
	
	/**
	 * @return \com\gmail\mararok\butphp\result\ResultFactory
	 */
	public function getResultFactory() {
		return $this->resultFactory;
	}
}
?>