<?
namespace WID\Test\Matchers;

class toBeTrue extends \WID\Test\Matcher {
	
	function match($target, $negation, $exp) {
		return (bool)($negation)?!$target:$target;
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be true';
	}
	
	function getName() {
		return 'toBeTrue';
	}
}
?>