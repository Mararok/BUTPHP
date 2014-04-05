<?
namespace com\gmail\mararok\butphp;

abstract class Matcher {
	
	abstract function match($target, $negation, $exp); 
	abstract function getName();
		
	function getInfo($target, $negation, $exp) {
		return self::toPrimitive($target).( ($negation)?' not ':' ');
	}

	protected static function toPrimitive($value) {
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