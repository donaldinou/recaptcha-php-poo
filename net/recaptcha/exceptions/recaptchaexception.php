<?php 
/**
 * 
 * Enter description here ...
 * @author aloyant
 * @todo define serialization with php.net/manual/language.oop5.magic.php#object.sleep or http://php.net/manual/class.serializable.php
 */
class ReCaptchaException extends RuntimeException {
	
	private static $serialVersionUID = '1L';
	
	public function __construct( $message ) {
		parent::__construct($message);
	}
}
?>