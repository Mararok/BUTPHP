<?
namespace WID\Test\Matchers;

class toBeNull extends \WID\Test\Matcher {
	
	function match($target, $negation, $exp) {
		return ($negation)?$target !== null:$target === null;
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be null';
	}
	
	function getName() {
		return 'toBeNull';
	}
}
?>