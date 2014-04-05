<?
namespace WID\Test\Matchers;

class toBeDefined extends \WID\Test\Matcher {
	
	function match($target, $negation, $exp) {
		return ($negation)?$target === null:$target !== null;
	}
	
	function getInfo($target, $negation, $exp) {
		return parent::getInfo($target,$negation,$exp).'to be defined';
	}
	
	function getName() {
		return 'toBeDefined';
	}
}
?>