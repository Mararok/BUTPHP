<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\matcher;

class Matcher {
	const matchMessageFormat = "%s %s %s";
	const matchNegationMessageFormat = "%s not %s %s";
	
	protected $current;
	
	public function __construct($current) {
		
	}	
	
	public abstract function match();
	public function matchNegation() {
		return !$this->match();
	}
	
	public abstract function getMatchMessage();
	public abstract function getMatchNegationMessage();
	
	protected static function toPrimitiveValue($value) {
		if (is_object($value)) {
			if ($value instanceof \Closure) {
				$p = '|Closure|';
			} else {
				$p = '|'.serialize($value).'|';
			}
		} else if (is_array($value)) {
			$p = '|'.serialize($value).'|';
		} else if (is_bool($value)) {
			$p = ($value) ? 'true' : 'false';
		} else if (is_string($value)) {
			$p = '"'.$value.'"';
		} else if (is_null($value)) {
			$p = 'null';
		} else
			$p = $value;
		return $p;
  }
}
?>