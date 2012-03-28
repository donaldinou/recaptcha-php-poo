<?php
// launch autoloader 
ReCaptchaAutoloader::register();

// check mbstring.func_overload
if (!function_exists('mcrypt_encrypt')) {
	throw new Exception('To use reCAPTCHA Mailhide, you need to have the mcrypt php module installed.');
}

namespace net\recaptcha\lib {
    
    /**
     * @brief reCAPTCHA class autoloader
     * @details reCAPTCHA class autoloader
     * 
     * @author Adrien Loyant <adrien.loyant@te-laval.fr>
     *
     * @date 2012-02-01
     * @version 1.0.0
     * @since 1.0.0
     * @copyright GNU Public License v.2
     *
     * @package net\recaptcha\interfaces
     */
    final class ReCaptchaAutoloader {
    
        /**
         * @brief Register function for autoloading
         * @details Register function for autoloading
         * 
         * @return void
         */
        public static function register() {
            return spl_autoload_register(array(__CLASS__, 'loader'));
        }
    
        /**
         * @brief The class loader function
         * @details The class loader function
         * 
         * @param string $name
         * @return void
         */
        public static function loader($name) {
            // class doesn't already exist | get ReCaptcha in name
            if ( !(class_exists($name)) && (strpos($name, 'ReCaptcha') !== false) ) {
                $path = strtolower(RECAPTCHA_ROOT.'php/'.$name.'.php');
                if ( file_exists($path) && is_readable($path) ) {
                    require_once($path);
                }
            }
        }
    }
    
}

?>