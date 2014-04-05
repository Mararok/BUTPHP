<?
namespace WID\Test\Matchers;

class toBeGreaterThan extends \WID\Test\Matcher {
	static $Comparator;
	function match($target, $negation, $exp, $comparator = false) {
		$comparator = ($comparator)?$comparator:self::$Comparator;
		
		return ($negation)?!$comparator($target,$exp):$comparator($target,$exp);
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be greater than '.self::toPrimitive($exp);
	}
	
	function getName() {
		return 'toBeGreaterThan';
	}
}

toBeGreaterThan::$Comparator = function($v1, $v2) {return ($v1 > $v2);};
?>