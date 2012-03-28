<?php
/**
 * @brief <em>reCAPTCHA</em> PHP POO library that handles calling <em>reCAPTCHA</em>
 * @details <em>reCAPTCHA</em> PHP POO library. It handles calling <em>reCAPTCHA</em>
 * NOTE : Some functions are Use to hold compatibility between old version
 * 
 * @author Adrien Loyant <adrien.loyant@te-laval.fr>
 * 
 * @date 2012-02-01
 * @version 1.0.0
 * @since 1.0.0
 * @copyright GNU Public License v.2
 * 
 * <a href="http://www.google.com/recaptcha">Homepage</a>
 * <a href="http://code.google.com/intl/fr/apis/recaptcha/">Documentation</a>
 * <a href="https://www.google.com/recaptcha/admin/create/">Get an API key</a>
 * <a href="http://groups.google.com/group/recaptcha/">Discussion group</a>
 * 
 * @todo define package for all subclasses
 */

// autoloader
if (!defined('RECAPTCHA_ROOT')) {
	define('RECAPTCHA_ROOT', __DIR__ . '/');
	require(RECAPTCHA_ROOT . 'php/recaptchaautoloader.php');
}

/**
 * @brief Gets the challenge HTML
 * @details Gets the challenge HTML (javascript and non-javascript version).
 * This is called from the browser, and the resulting <em>reCAPTCHA</em> HTML widget
 * is embedded within the HTML form it was called from.
 * 
 * @public
 * 
 * @param string $pubkey A public key for <em>reCAPTCHA</em>
 * @param string $error The error given by <em>reCAPTCHA</em> (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)
 * 
 * @return string - The HTML to be embedded in the user's form.
 * 
 * @deprecated Use reCaptcha object 
 * @see reCAPTCHA::createReCaptchaHTML
 */
function recaptcha_get_html ($pubkey, $error = null, $use_ssl = false) {
	$recaptcha = new ReCaptcha($pubkey);
	return $recaptcha->createReCaptchaHTML($error, array('use_ssl' => $use_ssl));
}


/**
 * @brief verify the user's answer
 * @details Calls an HTTP POST function to verify if the user's guess was correct
 * 
 * @public
 * 
 * @param string $privkey A private key for <em>reCAPTCHA</em>
 * @param string $remoteip The remote adress
 * @param string $challenge The challenge of <em>reCAPTCHA</em>
 * @param string $response The client response
 * @param array $extra_params an array of extra variables to post to the server
 * 
 * @return reCAPTCHAResponse
 * 
 * @deprecated Use reCaptcha object 
 * @see reCAPTCHA::checkAnswer
 */
function recaptcha_check_answer ($privkey, $remoteip, $challenge, $response, $extra_params = array()) {
	$recaptcha =  new ReCaptcha(null, $privkey);
	return $recaptcha->checkAnswer($remoteip, $challenge, $response, $extra_params);
}

/**
 * @brief Gets a sign up URL for <em>reCAPTCHA</em>
 * @details Gets a URL where the user can sign up for <em>reCAPTCHA</em>. If your application
 * has a configuration page where you enter a key, you should provide a link
 * using this function.
 * 
 * @public
 * 
 * @param string $domain The domain where the page is hosted
 * @param string $appname The name of your application
 * 
 * @return string
 * 
 * @deprecated Use reCaptcha object 
 * @see reCAPTCHA::getReCaptchaSignupUrl
 */
function recaptcha_get_signup_url ($domain = null, $appname = null) {
	return ReCaptchaObject::getReCaptchaSignupUrl($domain, $appname);
}

/**
 * @brief Gets the reCAPTCHA Mailhide url
 * @details Gets the reCAPTCHA Mailhide url for a given email, public key and private key
 * 
 * @public
 * 
 * @param string $pubkey A public key for <em>reCAPTCHA</em> Mail Hide
 * @param string $privkey A private key for <em>reCAPTCHA</em> Mail Hide
 * @param string $email The mail adress to hide
 * 
 * @return string
 * 
 * @deprecated Use reCaptcha object 
 * @see reCAPTCHA::createMailhideURL
 */
function recaptcha_mailhide_url($pubkey, $privkey, $email) {
	$recaptcha = new ReCaptchaMailHide($pubkey, $privkey, $email);
	return $recaptcha->createMailhideURL();
}

/**
 * @brief Gets html to display an email address
 * @details Gets html to display an email address given a public an private key.
 * to get a key, go <a href="http://www.google.com/recaptcha/mailhide/apikey">here</a>
 * 
 * @public
 * 
 * @param string $pubkey A public key for <em>reCAPTCHA</em> Mail Hide
 * @param string $privkey A private key for <em>reCAPTCHA</em> Mail Hide
 * @param string $email The mail adress to hide
 * 
 * @return string
 * 
 * @deprecated Use reCaptcha object 
 * @see reCAPTCHA::createReCaptchaHTML
 */
function recaptcha_mailhide_html($pubkey, $privkey, $email) {
	$recaptcha = new ReCaptchaMailHide($pubkey, $privkey, $email);
	return $recaptcha->createReCaptchaHTML();
}


?>