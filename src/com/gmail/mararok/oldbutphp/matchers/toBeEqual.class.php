<?
namespace WID\Test\Matchers;

class toBeEqual extends \WID\Test\Matcher {
	static $Comparator;
	function match($target, $negation, $exp, $comparator = false) {
		$comparator = ($comparator)?$comparator:self::$Comparator;
		
		return ($negation)?!$comparator($target,$exp):$comparator($target,$exp);
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be equal '.self::toPrimitive($exp);
	}
	
	function getName() {
		return 'toBeEqual';
	}
}

toBeEqual::$Comparator = function($v1, $v2) {return ($v1 === $v2);};
?>