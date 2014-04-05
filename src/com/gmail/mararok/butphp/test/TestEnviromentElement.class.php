<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\test;
use com\gmail\mararok\butphp as butphp;
use butphp\need as need;
use butphp\matcher as matcher;

class TestEnviromentElement extends TestElement {
	private $needHelper;
	private $matcherFactory;
	
	private $context;
	private $current;
	private $expectMode = false;
	private $negationMode = false;
	
	public function __construct($name) {
		parent::__construct($name);
	}	
	
	public function setNeedHelper($newNeedHelper) {
		$this->needHelper = $newNeedHelper;
	} 
	
	public function setMatcherFactory($newMatcherFactory) {
		$this->matcherFactory = $newMatcherFactory;
	}
	
	public function executeTest($test,result\TestEnviromentResult $result) {
		$result->onStart();
			try {
				$context->{$test}();
				
			} catch (TestIgnoredException $e) {
				
			} catch (BadMethodCallException $e) {
				 // no method;
			} catch (Exception $e) {
				
			}
		$result->onEnd();
	}
	
	public function expect($current) {
		if ($this->isInExpectMode()) {
			// @TODO handle that is error; cant execute expect(...)->expect(...)
		}
		$this->current = $current;
		return this;
	}
	
	public function toBe($expected) {
		$this->match($this->matcherFactory->newToBeMatcher($this->current,$expected));
		return this;
	}
	
	public function not() {
		$this->negationMode = !$this->negationMode;
		return this;
	}
	
	private function match(matcher\Matcher $matcher) {
		$message = null;
		if ($this->negation) {
			if (!$matcher->matchNegation()) {
				$message = $matcher->getMatchNegationMessage();
			}
		} else {
			if (!$matcher->match()) {
				$message = $matcher->getMatchMessage();
			}
		}
		
		$negation = false;
		if ($message != null) {
			/*$exception  = new \Exception();
			$pos = $exception->getStackTrace()[0];
			for (StackTraceElement ste : exception.getStackTrace()) {
				if (ste.getClassName() == context.getClass().getName()) {
					pos = ste;
					break;
				}
			}*/
			results.addUnexceptedResults(message,pos);
		}
	}
	
	private function isInExpectMode() {
		return $this->expectMode;
	}
	

	
}
?>