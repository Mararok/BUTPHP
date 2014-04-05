<?
namespace com\gmail\mararok\butphp;

class MockFileException extends \Exception {
	function __construct($message) {
		parent::__construct($message);
	}
}

class MockFile {
	private $File;
	private $Filename;
	private $Valid = false;
	
	function name($filename) {
		$this->Filename = $filename;
		$this->File = new SplFileObject($filename,'w');
		return $this;
	}
	
	function content($content) {
		if ($this->File) {
			$this->File->fwrite($content);
			$this->File->fflush();
			$this->File = null;
			$this->Valid = true;
		} else {
			throw new MockFileException('File dont have name, isnt opened');
		}
	}
	
	function __get($property) {
		switch ($property) {
			case 'where':
				return $this;
			case 'and': 
				return $this;
			case 'content': 
				if ($this->Valid) {
					$this->File = new SplFileObject($this->Filename,'r');
					$content = array();
					foreach ($this->File as $line) {
						$content[] = $line;
					}
					$this->File = null;
					return $content;
				} else {
					throw new MockFileException('File is not valid');
				}
		}
	}
}
?>
