<?php 
/**
 * Meta class
 * @abstract
 * @author Adrien Loyant <adrien.loyant@te-laval.fr>
 * 
 */
abstract class reCAPTCHAObject {
	
	/**
	 * ReCaptcah URL to create keys
	 * @var string
	 */
	const RECAPTCHA_CREATE_URL = 'https://www.google.com/recaptcha/admin/create';
	
	/**
	 * The private key
	 * @access protected
	 * @var static
	 */
	protected $privateKey;
	/**
	 * The public key
	 * @access protected
	 * @var string
	 */
	protected $publicKey;
	
	/**
	 * Check if both private and public keys are correct
	 * @access protected
	 * @return boolean true if keys are correct
	 * @throws ReCaptchaException
	 */
	protected function checkKeysConsistency() {
		if (empty($this->publicKey) || empty($this->privateKey)) {
			throw new ReCaptchaException('To use reCAPTCHA you must get an API key from <a href="'.static::RECAPTCHA_CREATE_URL.'">'.static::RECAPTCHA_CREATE_URL.'</a>');
		}
		if (!is_string($this->publicKey)) {
			throw new ReCaptchaException('The public API key provided is not correct');
		}
		if (!is_string($this->privateKey)) {
			throw new ReCaptchaException('The private API key provided is not correct');
		}
	}
	
	/**
	 * Check if the private key is correct
	 * @access protected
	 * @return boolean true if key is correct
	 * @throws ReCaptchaException
	 */
	protected function checkPrivateKeyConsistency() {
		if (empty($this->privateKey)) {
			throw new ReCaptchaException('To use reCAPTCHA you must get an API key from <a href="'.static::RECAPTCHA_CREATE_URL.'">'.static::RECAPTCHA_CREATE_URL.'</a>');
			return false;
		}
		if (!is_string($this->privateKey)) {
			throw new ReCaptchaException('The private API key provided is not correct');
			return false;
		}
		return true;
	}
	
	/**
	 * Check if the public key is correct
	 * @access protected
	 * @return boolean true if key is correct
	 * @throws ReCaptchaException
	 */
	protected function checkPublicKeyConsistency() {
		if (empty($this->publicKey)) {
			throw new ReCaptchaException('To use reCAPTCHA you must get an API key from <a href="'.static::RECAPTCHA_CREATE_URL.'">'.static::RECAPTCHA_CREATE_URL.'</a>');
			return false;
		}
		if (!is_string($this->publicKey)) {
			throw new ReCaptchaException('The public API key provided is not correct');
			return false;
		}
		return true;
	}
	
	/**
	 * This magic method is called each time a variable is referenced from the object
	 * @access public
	 * @param string $name
	 * @return mixed
	 */
	public function __get( $name ) {
		$result = null;
		if (isset($this->$name)) {
			$result = $this->$name;
		}
		return $result;
	}
	
	/**
	 * This magic method is called each time a variable is set in the object
	 * @access public
	 * @param tring $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set( $name, $value ) {
		switch ($name) {
			case 'privateKey':
				$this->privateKey = (string)$value;
			break;
			
			case 'publicKey':
				$this->publicKey = (string)$value;
			break;
			
			default:
				// Nothing to do
			break;
		}
	}
	
	/**
	 * Generate URL-encoded query string
	 * @static
	 * @access public
	 * @param mixed May be an array or object containing properties.
	 * @return string a URL-encoded string. 
	 * @link http://www.php.net/manual/en/function.http-build-query.php
	 */
	public static function reCaptchaBuildQuery( $formdata ) {
		$result = http_build_query($formdata);
		return $result;
	}
	
	/**
	 * Gets an URL where the user can sign up for reCAPTCHA.
	 * If your application has a configuration page where you enter a key, you should provide a link using this function.
	 * @static
	 * @access public
	 * @param string $domain The domain where the page is hosted
	 * @param string $appname The name of your application
	 * @return string
	 */
	public static function getReCaptchaSignupUrl($domain=null, $appName=null) {
		$args = static::reCaptchaBuildQuery(array('domains' => $domain, 'app' => $appName));
		$result = static::RECAPTCHA_CREATE_URL.'?'.$args;
		return $result;
	}
}
?>