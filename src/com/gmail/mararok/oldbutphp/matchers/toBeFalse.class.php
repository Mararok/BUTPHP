<?
namespace WID\Test\Matchers;

class toBeFalse extends \WID\Test\Matcher {
	
	function match($target, $negation, $exp) {
		return (bool)($negation)?$target:!$target;
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be false';
	}
	
	function getName() {
		return 'toBeFalse';
	}
}
?>