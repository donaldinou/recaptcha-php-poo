<?php 
/**
 * A ReCaptchaResponse is returned from recaptcha_check_answer()
 * @author TE
 * @todo clone etc...
 * @see http://code.google.com/p/recaptcha/
 */
class ReCaptchaResponse {
	
	protected $isValid;
	protected $error;
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct() {
		$this->isValid = false;
		$this->error = ReCaptchaErrorEnum::VERIFY_PARAMS_INCORRECT;
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function __get( $name ) {
		switch ($name) {
			case 'valid':
			case 'is_valid': // historical case value
				return $this->isValid;
			break;
			
			default:
				if (isset($this->$name)) {
					return $this->$name;
				}
			break;
		}
	}
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set( $name, $value ) {
		switch ($name) {
			case 'valid':
			case 'is_valid': // historical case value
				$this->isValid = (string)$value;
			break;
			
			default:
				if (isset($this->$name)) {
					$this->$name = $value;
				}
			break;
		}
	}
	
}
?>