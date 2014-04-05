<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;

class TestCase extends TestElement {
	public $test;
	private $testList;
	
	public function __construct($name) {
		parent::__construct($name);
		$this->testList = array();
	}

	public function addTest($testName) {
		$this->testList[] = $testName;	
	}

	public function getTestList() {
		return $this->testList;
	}
}
?>