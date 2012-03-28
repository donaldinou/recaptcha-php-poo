<?php 
class ReCaptchaMailHide extends ReCaptchaObject {
	
	const RECAPTCHA_CREATE_URL = 'http://www.google.com/recaptcha/mailhide/apikey';
	
	const RECAPTCHA_VERIFY_URL = 'http://www.google.com/recaptcha/mailhide';
	
	private $email;
	
	private $name;
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $publicKey
	 * @param string $privateKey
	 * @param string $email
	 */
	public function __construct( $publicKey, $privateKey, $email ) {
		$this->publicKey = (string)$publicKey;
		$this->privateKey = (string)$privateKey;
		$this->email = (string)$email;
		$this->checkKeysConsistency();
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @throws ReCaptchaException
	 */
	protected function checkEmailConsistency() {
		if (empty($this->email)) {
			throw new ReCaptchaException('The email address must not be empty!');
		}
	}
	
	/**
	 * gets the parts of the email to expose to the user.
	 * eg, given johndoe@example.com return ["john", "example.com"].
	 * the email is then displayed as john...@example.com
	 */
	private function splitMailAddress() {
		$arr = explode('@', $this->email);
		$len = strlen($arr[0]);
		if ($len<5) {
			$arr[0] = substr($arr[0], 0, 1);
		}
		elseif ($len<7) {
			$arr[0] = substr($arr[0], 0, 3);
		}
		else {
			$arr[0] = substr($arr[0], 0, 4);
		}
		return $arr;
	}
	
	/**
	 * gets the reCAPTCHA Mailhide url for a given email, public key and private key
	 */
	public function createMailhideURL() {
		$c = ReCaptchaMailHideEncryption::encrypt($this->email, $this->privateKey);
		$args = self::reCaptchaBuildQuery(array( 'k' => $this->publicKey, 'c' => $c ));
		$result = self::RECAPTCHA_VERIFY_URL.'/d?'.$args;
		return $result;
	}
	
	/**
	 * Gets html to display an email address given a public an private key.
	 * to get a key, go to:
	 *
	 * http://www.google.com/recaptcha/mailhide/apikey
	 */
	public function createReCaptchaHTML() {
		$result = '';
		$url = $this->createMailhideURL();
		
		$name = $this->name;
		if (empty($this->name)) {
			$emailparts = $this->splitMailAddress();
			$name = '...';
			$result .= $emailparts[0];
		}
		
		$result .= '<a href="'.htmlentities($url).'"';
		$result .= 		'onclick="window.open(\''.htmlentities($url).'\', \'\', \'toolbar=0,scrollbars=0,location=0,statusbar=0, menubar=0,resizable=0,width=500,height=300\'); return false;"';
		$result .= 		'title="Reveal this e-mail address">';
		$result .=		$name;
		$result .= '</a>';
		
		if (empty($this->name)) {
			$result .= '@'.$emailparts[1];
		}
		
		return $result;
	}
	
	public function setName( $value ) {
		$this->name = (string)$value;
	}
	
	public function __get( $name ) {
		$result = null;
		switch ($name) {
			case 'Email': // code convention
				$result = $this->email;
			break;
			
			case 'Name': // code convention
				$result = $this->name;
			break;
			
			default:
				if (isset($this->$name)) {
					$result = $this->$name;
				}
			break;
		}
		return $result;
	}
}
?>