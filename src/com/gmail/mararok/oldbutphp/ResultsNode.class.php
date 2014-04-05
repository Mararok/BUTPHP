<?
namespace com\gmail\mararok\butphp;

class ResultsNode {
	public $results;
	public $parent;
	public $startTime;
	public $children;
	
	function __construct($startResult, $type, $parent = null) {
		$this->results = array(
		'type'=>$type,
		'start'=>$startResult,
		'end'=>array('failed'=>false),
		'time'=>0,
		'children'=>array()
		);

		$this->parent = $parent;
		$this->startTime = 0;
		$this->children = array();
	}
	
	function addChild($startResult, $type) {
		$child = new ResultsNode($startResult,$type,$this);
		$this->children[] = $child;
		return $child;
	}
	
	function getResults() {
		$len = count($this->children);
		for ($i = 0; $i < $len; ++$i) {
			$this->results['children'][] = $this->children[$i]->getResults();
		}
		
		return $this->results;
	}
}
?>