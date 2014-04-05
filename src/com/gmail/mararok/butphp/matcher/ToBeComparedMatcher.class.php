<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\matcher;

class ToBeComparedMatcher extends ToBeMatcher {
	private $comparator;
	private $comparedMessage;
	
	public function __construct($current, $expected,\Closure $comparator, $comparedMessage) {
		parent::__construct($current,$expected);
		$this->comparator = $comparator;
		$this->comparedMessage = $comparedMessage;
	}	
	
	public function match() {
		return $this->comparator($this->current,$this->expected);
	}
	
	public abstract function getMatchMessage() {
		return sprintf(Matcher::matchMessageFormat,
			$this->toPrimitiveValue($this->current),
			$this->comparedMessage,
			$this->toPrimitiveValue($this->expected)
		);
	}
	
	public abstract function getMatchNegationMessage() {
		return sprintf(Matcher::matchNegationMessageFormat,
			$this->toPrimitiveValue($this->current),
			$this->comparedMessage,
			$this->toPrimitiveValue($this->expected)
		);
	}
}
?>