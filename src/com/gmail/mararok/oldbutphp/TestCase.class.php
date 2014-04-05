<?
namespace com\gmail\mararok\butphp;

class TestCase {
	public $Data;
	public $each;
	public $before;
	public $after;
	
	public $TestMatchers;
	public $CurrentExpect;
	public $CurrentResults;
	public $Reporter;
	
	function __construct($reporter) {
		$this->TestMatchers = new Matchers;
		$this->CurrentExpect = 0;
		$this->CurrentResults = array();
		$this->Reporter = $reporter;
	}
	
	function setData($data) {
		$this->Data = $data;
		$this->each =& $data['each'];
		$callback = function() {};
		$this->before = (key_exists('beforeEach',$data))?$data['beforeEach']:$callback;
		$this->after = (key_exists('afterEach',$data))?$data['afterEach']:$callback;
	}
	
	function __get($propertyName) {
		switch ($propertyName) {
			case 'need':
				return NeedHelper::get();
			break;
		}
	} 
	
	function beforeEach() {
		$this->before->__invoke($this->each);
	}
	
	function afterEach() {
		$this->after->__invoke($this->each);
	}
	
	function describe($desc) {
		$this->CurrentResults['desc'] = $desc;
	}
	
	function expect($exp) {
		$lastLog = $this->TestMatchers->log;
		if ($lastLog) {
			$this->logFailure($lastLog);
		}
		$this->TestMatchers->newExpect($this->CurrentExpect++,$exp);
		
		return $this->TestMatchers;
	}
	
	function exec($data) {
		$this->setData($data);
		$this->Reporter->caseStarted(array(
			'name'=>$this->Data['name'],
			'desc'=>(key_exists('desc',$this->Data))?$this->Data['desc']:'', 
			'total'=>count($this->Data['tests'])
		));
		
		$this->testing();
		$this->Reporter->caseDone();
	}
	
	function testing() {
		try {
			while (list($testName,$testFunction) = each($this->Data['tests'])) {
				$this->test($testName,$testFunction);
			}
		} catch (\Exception $e) {
			$this->logError('Unexpected error: ('.$e->getMessage() .') near excepted '. $this->CurrentExpect,$e->getTrace());
			$this->Reporter->testDone($this->CurrentResults);
			$this->testing();	
		}	
	}
	
	function test($testName, $testFunction) {
		$this->CurrentExpect = 0;
		$this->CurrentResults = array();
		$testFunction = $testFunction->bindTo($this);
		$this->Reporter->testStarted(array('name'=>$testName));
		$this->beforeEach();
			$testFunction($this->each);
		$this->afterEach();
		
		$lastLog = $this->TestMatchers->log;
		if ($lastLog) {
			$this->logFailure($lastLog);
		}
		
		$this->Reporter->testDone($this->CurrentResults);
	}
	
	function logFailure($log) {
		$this->CurrentResults['failed'] = true;
		if (!key_exists('exps',$this->CurrentResults)) {
			$this->CurrentResults['exps'] = array();
		}
		
		$this->CurrentResults['exps'][] = $log;
	}
	
	function logError($name,$stack) {
		$this->CurrentResults['failed'] = true;
		$len = count($stack);
		$curr;
		for ($i=0;$i < $len;++$i) {
			$curr =& $stack[$i];
			$stack[$i] = 
				'file: '.$curr['file'].
				' line: '.$curr['line'].
				' func: '.$curr['function'];
				//' args: '.implode(',',$curr['args']);
		}
		
		$this->CurrentResults['error'] = array('name'=>$name,'stack'=>$stack);
	}
}
?>