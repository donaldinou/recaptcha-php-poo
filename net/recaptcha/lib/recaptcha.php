<?php 
namespace net\recaptcha\lib {
    
    use net\recaptcha\interfaces;
    
    /**
     * @brief reCAPTCHA Object to build the captcha
     * @details reCAPTCHA Object to build the captcha.
     * 
     * @author Adrien Loyant <adrien.loyant@te-laval.fr>
     *
     * @date 2012-02-01
     * @version 1.0.0
     * @since 1.0.0
     * @copyright GNU Public License v.2
     *
     * @package net\recaptcha\lib
     *
     * <a href="http://www.google.com/recaptcha/api">reCAPTCHA API</a>
     * <a href="https://www.google.com/recaptcha/api">reCAPTCHA SSL API</a>
     * <a href="http://www.google.com//recaptcha/api/verify">reCAPTCHA verify uri</a>
     */
    class reCAPTCHA extends reCAPTCHAObject implements ireCAPTCHA {
    
        /**
         * The recaptcha API server url
         * @var string
         */
        const RECAPTCHA_API_SERVER = 'http://www.google.com/recaptcha/api';
        /**
         * The recaptcha API server url in ssl
         * @var unknown_type
         */
        const RECAPTCHA_API_SECURE_SERVER = 'https://www.google.com/recaptcha/api';
        /**
         * The recaptcha verify server url
         * @var unknown_type
         */
        const RECAPTCHA_VERIFY_SERVER	  = 'www.google.com';
        /**
         * The recaptcha verify path for url
         * @var unknown_type
         */
        const RECAPTCHA_VERIFY_PATH		  = '/recaptcha/api/verify';
    
        /**
         * Constructor. Initialize vars.
         * @access public
         * @param string $publicKey[optional]
         * @param string $privateKey[optional]
         * @return void
         */
        public function __construct( $publicKey='', $privateKey='' ) {
            $this->publicKey = $publicKey;
            $this->privateKey = $privateKey;
        }
    
        /**
         * Submits an HTTP POST to a reCAPTCHA server
         * @access private
         * @param string $host
         * @param string $path
         * @param array $data
         * @param int port[optional]
         * @return array
         *
         * @todo rewrite this
         */
        private function httpPost($host, $path, $data, $port = 80) {
            $req = self::reCaptchaBuildQuery($data);
    
            $http_request  = 'POST '.$path.' HTTP/1.0'.PHP_EOL;
            $http_request .= 'Host: '.$host.PHP_EOL;
            $http_request .= 'Content-Type: application/x-www-form-urlencoded;'.PHP_EOL;
            $http_request .= 'Content-Length: ' . strlen($req) . PHP_EOL;
            $http_request .= 'User-Agent: reCAPTCHA/PHP'.PHP_EOL;
            $http_request .= PHP_EOL;
            $http_request .= $req;
    
            $response = '';
            if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
                throw new RuntimeException('Could not open socket');
            }
    
            fwrite($fs, $http_request);
            while ( !feof($fs) ) {
                $response .= fgets($fs, 1160); // One TCP-IP packet
            }
            fclose($fs);
    
            $response = explode(PHP_EOL.PHP_EOL, $response, 2);
            return $response;
        }
    
        /**
         * Create the HTML result for the object
         * @access public
         * @param string $errorMessage[optional]
         * @param array $options[optional]
         * 									currently options are:
         * 									<ul>
         * 										<li>use_ssl : false by default. Use it if you want to use ssl url</li>
         * 										<li>no_script: true by default. Use it if you want to generate noscript HTML Tag</li>
         * 									</ul>
         * @return string
         * @throws ReCaptchaException
         * @see iReCaptcha::createReCaptchaHTML()
         */
        public function createReCaptchaHTML($errorMessage=null, array $options=array( 'use_ssl' => false, 'no_script' => true )) {
            // throws exception if public key is false
            $this->checkPublicKeyConsistency();
    
            // init
            $result = '';
            $args = array( 'k' => $this->publicKey );
    
            // secured transaction or not
            $server = self::RECAPTCHA_API_SERVER;
            if (isset($options['use_ssl']) && $options['use_ssl']) {
                $server = self::RECAPTCHA_API_SECURE_SERVER;
            }
    
            // manage errors
            if (!is_null($errorMessage) && is_string($errorMessage)) {
                $args['error'] = $errorMessage;
            }
    
            // build query string
            $queryString = self::reCaptchaBuildQuery($args);
    
            // build result
            $result .= '<script type="text/javascript" src="'.$server.'/challenge?'.$queryString.'"></script>';
    
            // include no script or not
            if (!isset($options['no_script'])) {
                $options['no_script'] = true;
            }
            if ($options['no_script']) {
                $result .= '<noscript>';
                $result .= 		'<iframe src="'.$server.'/noscript?'.$queryString.'" height="300" width="500" frameborder="0"></iframe>';
                $result .= 		'<br />';
                $result .= 		'<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>';
                $result .= 		'<input type="hidden" name="recaptcha_response_field" value="manual_challenge" />';
                $result .= '</noscript>';
            }
    
            return $result;
        }
    
        /**
         * Return the response object to check if the user guess is correct
         * @access public
         * @param string $remoteAddr
         * @param string $challenge
         * @param string $response
         * @param array $extraParams[optional]
         * @return ReCaptchaResponse
         * @throws ReCaptchaException
         * @see iReCaptcha::checkAnswer()
         * @todo object for response and answer
         */
        public function checkAnswer( $remoteAddr, $challenge, $response, $extraParams=array() ) {
            // throws exception if private key is false
            $this->checkPrivateKeyConsistency();
    
            // init
            $result = new ReCaptchaResponse();
    
            // check remote consistency
            if (empty($remoteAddr)) {
                throw new ReCaptchaException('For security reasons, you must pass the remote ip to ReCaptcha');
            }
    
            //discard spam submissions
            if (empty($challenge) || empty($response)) {
                $result->is_valid = false;
                $result->error = ReCaptchaErrorEnum::INCORRECT_CAPTCHA_SOL;
            } else {
                $data = array(
                                'privatekey' => $this->privateKey,
                                'remoteip'	 => $remoteAddr,
                                'challenge'	 => $challenge,
                                'response'	 => $response
                );
                if (!empty($extra_params)) {
                    $data = array_merge($data, $extra_params);
                }
                $response = self::httpPost( self::RECAPTCHA_VERIFY_SERVER, self::RECAPTCHA_VERIFY_PATH, $data );
                $answers = explode( "\n", $response[1] ); // BUGFIX for PHP_EOL
                if (trim($answers[0])=='true') {
                    $result->is_valid = true;
                } else {
                    $result->is_valid = false;
                    $result->error = $answers[1];
                }
            }
    
            return $result;
        }
    
    }
    
}
?>