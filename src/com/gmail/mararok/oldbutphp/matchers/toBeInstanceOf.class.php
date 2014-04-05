<?
namespace WID\Test\Matchers;

class toBeInstanceOf extends \WID\Test\Matcher {
	
	function match($target, $negation, $className) {
		return ($negation)?!is_a($target,$className):is_a($target,$className);
	}
	
	function getInfo($target, $negation, $className) {
		return parent::getInfo($target,$negation,$className).'to be instance of '.$className;
	}
	
	function getName() {
		return 'toBeInstanceOf';
	}
}
?>