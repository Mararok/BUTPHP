<?
namespace com\gmail\mararok\butphp;
class Suite {
	public $Path;
	public $Parent;
	public $Reporter;
	public $Data;
	public $CaseProcessor;
	
	function __construct($path, $parent, $reporter, $data) {
		$this->Path = $path.'/';
		$this->Parent = $parent;
		$this->Reporter = $reporter;
		$this->Data = $data;
		$this->CaseProcessor = new TestCase($reporter); 
	}
	
	function exec() {
		if ($this->Parent === null) {
			$this->Reporter->reportStarted();
		}
		$this->Reporter->suiteStarted(array(
			'name'=>$this->Data['name'],
			'desc'=>(key_exists('desc',$this->Data))?$this->Data['desc']:''
		));

		if (key_exists('suites',$this->Data)) {
			$this->execSuites();
		}
		
		if (key_exists('cases',$this->Data)) {
			$this->execCases();
		}
		
		$this->done();
	}
	
	function execSuites() {
		$suites =& $this->Data['suites'];
		$len = count($suites);
		$suite;
		for ($i = 0; $i < $len;++$i) {
			$data = @include($this->Path.$suites[$i].'/main.suite.php');
			if ($data) {
				$suite = new Suite($this->Path.$suites[$i],$this,$this->Reporter,$data);
				$suite->exec();
			} else {
				$this->Reporter->reportEmptySuite($suites[$i]);
			}
		}
	}
	
	function execCases() {
		$cases =& $this->Data['cases'];
		$len = count($cases);
    $data;
		for ($i = 0; $i < $len;++$i) {
			$data = @include($this->Path.$cases[$i].'.case.php');
			if ($data) {
				$this->CaseProcessor->exec($data);
			} else {
				$this->Reporter->reportEmptyCase($cases[$i]);
			}
		}
	}
	
	function done() {
		$this->Reporter->suiteDone();
		if (!$this->Parent) {
			$this->Reporter->reportDone();
		}
	}
}
	
?>
