<?
namespace com\gmail\mararok\butphp;
	
class MatchersExecption extends \Exception {
	function __construct($message) {
		parent::__construct($message);
	}
}

class Matchers {
	
	private $CurrentExpect;
	private $MatchLog;
	private $Target;
	private $Negation;
	
	private $Matchers;
	
   function __construct() {
      $this->CurrentExpect = -1;
			$this->MatchLog = '';
      $this->Negation = false;
			$this->Matchers = array();
			$this->loadStdMatchers();
   }
   
	 function loadStdMatchers() {
	 	$this->addMatcher(new Matchers\toBe());
		
		$this->addMatcher(new Matchers\toBeTrue());
	 	$this->addMatcher(new Matchers\toBeFalse());
		
		$this->addMatcher(new Matchers\toBeNull());
		$this->addMatcher(new Matchers\toBeDefined());
		
		$this->addMatcher(new Matchers\toBeInstanceOf());
		
		$this->addMatcher(new Matchers\toBeEqual());
		$this->addMatcher(new Matchers\toBeGreaterThan());
		$this->addMatcher(new Matchers\toBeLessThan());
		
		$this->addMatcher(new Matchers\toThrow());
	 }
	 
	 function addMatcher(Matcher $matcher) {
	 	$this->Matchers[$matcher->getName()] = $matcher;
	 }
	 
   function __get($propertyName) {
      switch ($propertyName) {
         case 'not':
            $this->Negation = !$this->Negation;
            return $this;
         case 'log':
            $l = $this->MatchLog;
            $this->MatchLog = '';
            return $l;
      }
   } 
   
	 // @TODO this is bugged need support more arguments.
	 function __call($matcherName,$args) {
	 	if (isset($this->Matchers[$matcherName])) {
	 		$matcher = $this->Matchers[$matcherName];
			$exp = (isset($args[0]))?$args[0]:null;
			$matched = $matcher->match($this->Target,$this->Negation,$exp);
	 		if (!$matched) {
	 			$this->logFailure($matcher->getInfo($this->Target,$this->Negation,$exp));
	 		} else if ($matched === $matcher) {
	 			return $matcher; 
	 		}
	 	} else {
			throw new MatchersExecption('matcher '.$matcherName.' not exists');
		}
	 }
   
   function newExpect($expectIndex, $exp) {
      $this->CurrentExpect = '<b>('.$expectIndex.') Expected</b> ';
      $this->Target = $exp;
      $this->Negation = false;
			$this->ExceptionObject = null;
   }
   
   function logFailure($log) {
		$this->MatchLog = $this->CurrentExpect.$log;
   }
 
}

?>
