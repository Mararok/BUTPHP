<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;

class TestEnviroment {
	private $testEnviromentElement;
	
	public function __construct($testEnviromentElement) {
		$this->testEnviromentElement;
	}	
	
	public function describe($description) {
		$this->describe($description);
	}
	
	public function expect($current) {
		$this->testEnviromentElement->expect($current);
		return this;
	}
	
	
}
?>