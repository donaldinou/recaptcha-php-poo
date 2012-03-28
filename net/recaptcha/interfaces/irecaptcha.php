<?php 
namespace net\recaptcha\interfaces {
    
    /**
     * @brief Interface to define reCAPTCHA object methods
     * @details Interface to define reCAPTCHA object methods. Use this in case of factory or adapter pattern
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
    interface ireCAPTCHA {
    
        /**
         * @brief Create the HTML result for the object
         * @details Output the html result for <em>reCAPTCHA</em>.
         *
         * @param string $errorMessage The error message returned by <em>reCAPTCHA</em>
         * @param array $options array of options. You can use easily use it to add some parameters
         * @return string
         */
        public function createReCaptchaHTML( $errorMessage, array $options );
    
        /**
         * @brief Validates a <em>reCAPTCHA</em> challenge and response
         * @details Validates a <em>reCAPTCHA</em> challenge and response
         *
         * @param string $remoteAddr The server remote address
         * @param string $challenge the <em>reCAPTCHA</em> challenge
         * @param string $response the user <em>reCAPTCHA</em> answer
         * @return mixed
         */
        public function checkAnswer( $remoteAddr, $challenge, $response );
    
    }
    
}
?>