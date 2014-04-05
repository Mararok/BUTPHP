<?
namespace WID\Test\Matchers;

class toBe extends \WID\Test\Matcher {
	
	function match($target, $negation, $exp) {
		return ($negation)?$target !== $exp:$target === $exp;
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be '.self::toPrimitive($exp);
	}
	
	function getName() {
		return 'toBe';
	}
}
?>