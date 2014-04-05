<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\matcher;

class ToBeMatcher extends Matcher {
	protected $expected;
	
	public function __construct($current, $expected) {
		parent::__construct($current);
		$this->expected = $expected;
	}	
	
	public function match() {
		return $this->current === $this->expected;
	}
	
	
	public abstract function getMatchMessage() {
		return sprintf(Matcher::matchMessageFormat,
			$this->toPrimitiveValue($this->current),
			'to be',
			$this->toPrimitiveValue($this->expected)
		);
	}
	
	public abstract function getMatchNegationMessage() {
		return sprintf(Matcher::matchNegationMessageFormat,
			$this->toPrimitiveValue($this->current),
			'to be',
			$this->toPrimitiveValue($this->expected)
		);
	}
}
?>