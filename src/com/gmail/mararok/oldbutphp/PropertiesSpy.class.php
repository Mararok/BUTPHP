<?
namespace com\gmail\mararok\butphp;

class PropertiesSpyException extends \Exception {
	function __construct($message) {
		parent::__construct($message);
	}
}
class PropertiesSpy {
	private $Target;
	private $ClassInfo;
	private $Property;
	
	function __construct() {
		$this->Target = $this->ClassInfo = $this->Property = null;
	}
	
	function onObject($target) {
		if ($target) {
			$this->ClassInfo = new \ReflectionObject($target);
			$this->Target = $target;
			$this->Property = null;
			return $this;
		}
		throw new PropertiesSpyException('spy not have target'); 
	}
	
	function has($name) {
		if ($this->isValid()) {
			return $this->ClassInfo->hasProperty($name);
		}
		throw new PropertiesSpyException('spy not have target'); 
	}
	
	function valueOf($name) {
		if ($this->has($name)) {
			$property = $this->ClassInfo->getProperty($name);
			$property->setAccessible(true);
			return $property->getValue($this->Target);
		} 
		throw new PropertiesSpyException('property '.$name.' not exists');
	}
	
	function setValueOf($name) {
		if ($this->isValid()) {
			$this->Property = $this->ClassInfo->getProperty($name);
			$this->Property->setAccessible(true);
			return $this;
		}
		throw new PropertiesSpyException('spy not have target');
	}
	
	function on($value) {
		if ($this->Property) {
			$this->Property->setValue($this->Target,$value);
			$this->Property = null;
		} else {
			throw new PropertiesSpyException("can't set value of undefined property name");
		}
	}
	
	private function isValid() {
		return (bool)$this->ClassInfo;
	} 
}
?>
