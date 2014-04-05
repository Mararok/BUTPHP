<?php
/** @file
 * @author Andrzej Mararok Wasiak (mararok@gmail.com)
 */
 
namespace com\gmail\mararok\butphp\result;

class EnexpectedResult {
	private $matchMessage;
	private $sourceName;
	private $lineNumber;
	
	public function __construct($matchMessage, $stackPosition) {
		$this->matchMessage = $matchMessage;
		$this->setDataFromStackPosition($stackPosition);
	}	

	private function setDataFromStackPosition($stackPosition) {
		$this->sourceName = $stackPosition['file'];
		$this->lineNumber = $stackPosition['line'];
	}

	public function getMatchMessage() {
		return $this->matchMessage;
	}
	
	public function getSourceName() {
		return $this->sourceName;
	}
	
	public function getLineNumber() {
		return $this->lineNumber;
	}
}
?>