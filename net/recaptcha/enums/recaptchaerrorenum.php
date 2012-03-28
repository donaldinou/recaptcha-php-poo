<?php 
namespace net\recaptcha\enums {
    
    /**
     * @brief reCAPTCHA enumeration error
     * @details reCAPTCHA enumeration error
     * You can see documentation <a href="http://code.google.com/intl/fr-FR/apis/recaptcha/docs/verify.html">here</a>
     * This class will need to extends <a href="http://php.net/manual/fr/book.spl-types.php">SplEnum</a> soon
	 * It's a final class because there is no need to extends it; 
	 * 
     * @author Adrien Loyant <adrien.loyant@te-laval.fr>
     *
     * @date 2012-02-01
     * @version 1.0.0
     * @since 1.0.0
     * @copyright GNU Public License v.2
     *
     * @package net\recaptcha\enums
     */
    final class reCAPTCHAErrorEnum {
        
        /**
         * @brief default value of the enumeration
         * @details default value of the enumeration
         * 
         * @var string
         */
        const __default                 = self::INVALID_SITE_PUBLIC_KEY;
        
        /**
         * @brief Impossible to verify public key
         * @details Impossible to verify public key
         * 
         * @var string
         */
        const INVALID_SITE_PUBLIC_KEY	= 'invalid-site-public-key';
        
        /**
         * @brief We weren't able to verify the private key.
         * @details We weren't able to verify the private key.
         * <strong>Possible Solutions</strong>
         *     <ul>
         *         <li>Did you swap the public and private key? It is important to use the correct one</li>
         *         <li>Did you make sure to copy the entire key, with all hyphens and underscores, but without any spaces? 
         *             The key should be exactly 40 characters long.</li>
         *     </ul>
         * @var string
         */
        const INVALID_SITE_PRIVATE_KEY	= 'invalid-site-private-key';
        
        /**
         * @brief The challenge parameter of the verify script was incorrect.
         * @details The challenge parameter of the verify script was incorrect.
         * 
         * @var string
         */
        const INVALID_REQUEST_COOKIE	= 'invalid-request-cookie';
        
        /**
         * @brief The CAPTCHA solution was incorrect.
         * @details The CAPTCHA solution was incorrect.
         * 
         * @var string
         */
        const INCORRECT_CAPTCHA_SOL		= 'incorrect-captcha-sol';
        
        /**
         * @brief verify params are incorrect
         * @details verify params are incorrect
         * 
         * @var string
         */
        const VERIFY_PARAMS_INCORRECT	= 'verify-params-incorrect';
        
        /**
         * @brief reCAPTCHA never returns this error code. 
         * @details reCAPTCHA never returns this error code. 
         * A plugin should manually return this code in the unlikely event that it is unable to contact the reCAPTCHA verify server.
         * 
         * @var string
         */
        const RECAPTCHA_NOT_REACHABLE	= 'recaptcha-not-reachable';
    }
    
}
?>