<?
namespace com\gmail\mararok\butphp;

class MockObjectException extends \Exception {
	function __construct($message) {
		parent::__construct($message);
	}
}

class MockObjectUndefinedMethodException extends MockObjectException {
	function __construct($message) {
		parent::__construct($message);
	}
}

class MockObject {
	const EMPTY_ARGS = '[]';
	const EMPTY_RETURN = null;
	
	private $Methods;
	
	private $CurrentName;
	private $CurrentArgs;
	
	function __construct() {
		$this->Methods = array();
		$this->CurrentName = '';
		$this->CurrentArgs = self::EMPTY_ARGS;
	}
	
	function when($methodName) {
		$this->CurrentName = $methodName;
		return $this;
	}
	
	function get() {
		if ($this->CurrentName) {
			$this->CurrentArgs = $this->encodeArgs(func_get_args());
			return $this;
		}
		
		throw new MockObjectUndefinedMethodException('for args '.$this->CurrentArgs);
	}
	
	private function encodeArgs($args) {
		return json_encode($args);
	}
	
	function give($value = self::EMPTY_RETURN) {
		if ($this->CurrentName) {
			$this->addMethod($value);
			return $this;
		}
		
		throw new MockObjectUndefinedMethodException("Can't set return value: $value");
	}
	
	private function addMethod($returnValue) {
		if (!$this->methodExists($this->CurrentName)) {
			$this->MockMethods[$this->CurrentName] = array();
		}
		
		$this->Methods[$this->CurrentName][$this->CurrentArgs] = $returnValue;
		
		$this->CurrentName = '';
		$this->CurrentArgs = self::EMPTY_ARGS;
	}
	
	
	function __call($methodName,$args) {
		if ($this->methodExists($methodName)) {
			$args = encodeArgs($args);
			if ($this->argsExists($methodName, $args)) {
				return $this->Methods[$methodName][$args];
			}
		}
	}
	
	private function methodExists($methodName) {
		return isset($this->Methods[$methodName]);
	}
	
	private function argsExists($methodName, $args) {
		return (isset($this->Methods[$methodName][$args]));
	}
}

?>
