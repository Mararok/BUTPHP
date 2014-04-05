<?
namespace com\gmail\mararok\butphp;

class NeedHelper {
	private static $Instance;

	static function get() {
		if (self::$Instance === null){
			self::$Instance = new NeedHelper();
		}
		
		return self::$Instance;
	}
	
	function __get($needType) {
		switch ($needType) {
			case 'MockObject':
				return new MockObject();
				
			case 'MockFile':
				return new MockFile();
				
			case 'PropertiesSpy':
				return new PropertiesSpy();
		}
	} 
	
}
?>