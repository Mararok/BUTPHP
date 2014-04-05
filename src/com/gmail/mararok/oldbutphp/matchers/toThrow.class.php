<?
namespace WID\Test\Matchers;

class toThrow extends \WID\Test\Matcher {
	private $LastException;
	private $Negation;
	private $LastMessage;
	
	function match($target, $negation, $exceptionClassName) {
		$this->clear();
	 	try {
	 		$target->__invoke();
			return $this->matchNothingThrow($negation);
	 	} catch (\Exception $e) {
	 		return $this->matchException($e,$negation,$exceptionClassName);
	 	}
	}
	
	private function clear() {
		$this->Negation = false;
		$this->LastException = null;
		$this->Message = '';
	}
	
	private function matchNothingThrow($negation) {
		if ($negation) {
			return true;
		}
		return false;	
	}
	
	private function matchException($exception, $negation, $exceptionClassName) {
		$this->LastException = $exception;
		if ($negation) {
			return false;
		} else if (is_a($exception,$exceptionClassName)) {
			return $this;
		}
	}
	
	function __get($property) {
		if ($property === 'not') {
			$this->Negation = !$this->Negation;
			return $this;
		}
	}
	
	function withMessage($message) {
		$e = $this->LastException;
	 	if (!$e) {
	 		return false;
		}
		
	 	if (($this->Negation)?$e->getMessage() === $message:$e->getMessage() !== $message) {
	 		$this->LastMessage = $message;
			return false;
		}
		
		return true;
	}
	
	function getInfo($target, $negation, $exceptionClassName) {
		$info = parent::getInfo($target,$negation,$exceptionClassName);
		if ($negation) {
			$info .= 'throw but throw '.get_class($this->LastException);
		} else {
			if ($this->LastException) {
				if ($this->LastMessage) {
					$info .= 'to throw '.$exceptionClassName.' with message: '.
						$this->LastMessage.' but message is '.$this->LastException->getMessage();
				} else {
					$info .= 'to throw '.$exceptionClassName.' but throw '.get_class($this->LastException);
				}
			} else {
				$info .= 'to throw '.$exceptionClassName.' but nothing throw';
			}
		}
		
		return $info;
	}
	
	function getName() {
		return 'toThrow';
	}
}
?>