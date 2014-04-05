<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\matcher;

class MatcherFactory  {	
	private static $standardEqualsComarator;
	private static $standardGreaterThanComarator;
	private static $standardLessThanComarator;
	
	public function newToBeNullMatcher($current) {
		return $this->newToBeMatcher($current,null);
	}
	
	public function newToBeFalseMatcher($current) {
		return $this->newToBeMatcher($current,false);
	}
	
	public function newToBeTrueMatcher($current) {
		return $this->newToBeMatcher($current,true);
	}
	
	public function newToBeEqualsMatcher($current, $expected, \Closure $comaprator = null) {
		if ($comaprator === null) {
			$comaprator = MatcherFactory::$standardEqualsComaprator;
		}
		
		return $this->newToBeComapredMatcher($current,$expected,$comparator);
	}
	
	public function newToBeGreaterThanMatcher($current, $expected, \Closure $comaprator = null) {
		if ($comaprator === null) {
			$comaprator = MatcherFactory::$standardGreaterThanComaprator;
		}
		
		return $this->newToBeComapredMatcher($current,$expected,$comparator);
	}
	
	public function newToBeLessThanMatcher($current, $expected, \Closure $comaprator = null) {
		if ($comaprator === null) {
			$comaprator = MatcherFactory::$standardLessThanComaprator;
		}
		
		return $this->newToBeComapredMatcher($current,$expected,$comparator);
	}
	
	public function newToBeMatcher($current, $expected) {
		return new ToBeMatcher($current,$expected);
	} 
	
	public function newToBeComapredMatcher($current, $expected, \Closure $comparator) {
		return new ToBeMatcher($current,$expected,$comparator);
	}
}

MatcherFactory::$standardEqualsComaprator = function($current, $expected) {
		return $current === $expected;
};

MatcherFactory::$standardGreaterThanComaprator = function($current, $expected) {
		return $current > $expected;
};

MatcherFactory::$standardLessThanComaprator = function($current, $expected) {
		return $current < $expected;
};

?>