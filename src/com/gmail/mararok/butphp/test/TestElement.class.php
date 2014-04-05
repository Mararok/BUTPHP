<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;

class TestElement {
	private $name;
	private $description;
	private $ignored = false;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function describe($description) {
		$this->description = $description;
	}	

	public function ignore() {
		$this->ignored = true;
	}
	
	public function isIgnored() {
		return $this->ignored;
	}
	
	public function beforeEach() {}
	public function afterEach() {}
	
	
	public function getName() {
		return $this->name;
	}
	
	public function getDescription() {
		return $this->description;
	}
}
?>