<?
namespace com\gmail\mararok\butphp;

class Reporter {
	public static $EMPTY = -1;
	public static $SUITE = 0;
	public static $CASE = 1;
	public static $TEST = 2;
	
	public $CurrentParent; 
	public $TopResults;
	public $Failures;
	
	public $Report;
	public $StartTime;
	
	public $FullName;
	public $NameLevel;
	
	function __construct() {
		$this->CurrentParent = $this->TopResults = null;
		
		$this->Failures = array();
		$this->StartTime = 0;
		$this->FullName = array();
		$this->NameLevel = 0;
		
		$this->Report = array(
			'totalSuites'=>0,
			'totalCases'=>0,
			'totalTests'=>0,
			'time'=>0,
			'failures'=>null,
			'results'=>null
		);
	}
	
	function reportStarted() {
		$this->StartTime = $this->getTime();
		$this->CurrentParent = $this->TopResults = new ResultsNode(array('name'=>'__EMPTY__'),self::$EMPTY,null);
	}
	
	function reportDone() {
		if ($this->CurrentParent !== $this->TopResults) {
			throw new \Exception('[Reporter.ReportDone] not closed '.
				$this->CurrentParent->Results['start']['name']);
		}
		
		$this->Report['time'] = $this->calcTime($this->StartTime);
	}
	
	function suiteStarted($result) {
		$type = $this->CurrentParent->results['type'];
		if ($type !== self::$SUITE && $type !== self::$EMPTY) {
			throw new \Exception('[Reporter.suiteStarted] '.
				$this->CurrentParent->Results['start']['name'].
				' is not a suite or is first suite');
		}
		
		$this->onStarted($result,self::$SUITE);
		++$this->Report['totalSuites'];
	}
	
	function suiteDone($result = false) {
		if ($this->CurrentParent === $this->TopResults) {
			return;
		}
		
		$this->done($result);
	}
	
	function caseStarted($result) {
		if ($this->CurrentParent->results['type'] !== self::$SUITE) {
			throw new \Exception('[Reporter.caseStarted] '.$this->CurrentParent->results['start']['name'].' is not a suite');
		}
		
		$this->onStarted($result,self::$CASE);
		++$this->Report['totalCases'];
	}
	
	function caseDone($result = false) {
		if ($this->CurrentParent->results['type'] !== self::$CASE) {
			throw new \Exception('[Reporter.caseDone] '.$this->CurrentParent->results['start']['name'].' is not a case');
		}
		
		$this->done($result);
	}
	
	function testStarted($result) {
		if ($this->CurrentParent->results['type'] !== self::$CASE) {
			throw new \Exception('[Reporter.testStarted] '.$this->CurrentParent->results['start']['name'].' is not a test case');
		}
		
		$this->onStarted($result,self::$TEST);
		++$this->Report['totalTests'];
	}
	
	function testDone($result) {
		if ($type = $this->CurrentParent->results['type'] !== self::$TEST) {
			throw new \Exception('[Reporter.testDone] '.$this->CurrentParent->start['name'].' is not a test');
		}
		
		$current = $this->CurrentParent;
		$this->done($result);
		
		if (key_exists('failed', $result)) {
			$current->results['end']['fullname'] = join($this->FullName,' < ');
			$this->Failures[] = $current->getResults();
			$this->setFailed($current);
		}
	}
	
	function reportEmptyCase($name) {
		$this->caseStarted(array('name'=>'__EMPTY__ '.$name));
		$this->caseDone(array('failed'=>true));
		$this->setFailed($this->CurrentParent);
	}
	
	function reportEmptySuite($name) {
		$this->suiteStarted(array('name'=>'__EMPTY__ '.$name));
		$this->suiteDone(array('failed'=>true));
		$this->setFailed($this->CurrentParent);
	}
	
	function setFailed($current) {
		$current->results['end']['failed'] = true;
		if ($current->parent->results['end']['failed']) {
			return;
		}
		
		$current = $current->parent;
		do {
			$current->results['end']['failed'] = true;
			$current = $current->parent;
		} while($current !== $this->TopResults);
	}
	
	function calcTime($start) {
		return ($this->getTime() - $start)/1000;
	}
	
	function getTime() {
		return round(microtime(true)*1000);
	}
	
	function onStarted($result,$type) {
		$this->CurrentParent = $this->CurrentParent->addChild($result,$type);
		$this->CurrentParent->startTime = $this->getTime();
		$this->FullName[$this->NameLevel++] = $result['name'];
	}
	
	function done($result) {
		$this->CurrentParent->results['end'] = ($result)?$result:$this->CurrentParent->results['end'];
		$this->CurrentParent->results['time'] = $this->calcTime($this->CurrentParent->startTime);
		$this->CurrentParent = $this->CurrentParent->parent;
		--$this->NameLevel;
	}
	
	function getReport() {
		$this->Report['results'] = $this->CurrentParent->getResults();
		$this->Report['failures'] = $this->Failures;
		
		return json_encode($this->Report);
	}
}
?>

