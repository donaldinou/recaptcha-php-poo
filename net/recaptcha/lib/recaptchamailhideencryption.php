<?php 
/**
 * Enter description here ...
 * @author TE
 * @abstract
 * @link http://code.google.com/intl/fr-FR/apis/recaptcha/docs/mailhideapi.html
 */
abstract class ReCaptchaMailHideEncryption {
	
	/**
	 * Mode use for the encryption
	 * @var int
	 */
	const MODE = MCRYPT_MODE_CBC;
	/**
	 * Cupher use for the encryption
	 * @var int
	 */
	const CIPHER = MCRYPT_RIJNDAEL_128;

	/**
	 * 
	 * Enter description here ...
	 * @param string $str
	 * @param int $block_size
	 */
	public static function pad_string($str, $block_size=16) {
		$strlen = strlen($str);
		$numpad = $block_size - ($strlen % $block_size);
		$result = str_pad($str, $strlen+$numpad, chr($numpad), STR_PAD_RIGHT);
		return $result;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $data
	 * @param unknown_type $key
	 * @param unknown_type $base64
	 * @throws ReCaptchaException
	 */
	public static function encrypt( $data, $key, $base64=true, $block_size=16 ) {
		$key = pack('H*', $key);
		if (!function_exists('mcrypt_encrypt')) {
			throw new ReCaptchaException('To use reCAPTCHA Mailhide, you need to have the mcrypt php module installed.');
		}
		$iv = str_pad('', $block_size, "\0", STR_PAD_RIGHT); // \0 equal null
		$result = mcrypt_encrypt(self::CIPHER, $key, self::pad_string($data, $block_size), self::MODE, $iv);
		if ($base64) {
			$result = strtr(base64_encode($result), '+/', '-_');
		}
		return $result;
	}

}
?>