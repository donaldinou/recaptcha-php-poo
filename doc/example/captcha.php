<?php 
// You don't need this. It is used to display different built method  
$type = 'object';
if (isset($_GET['type']) && in_array($_GET['type'], array('procedural', 'object'))) {
	$type = $_GET['type'];
}
//

// include library
require_once('../recaptchalib.php');

// Initiliaze key. See readme for more informations
$publickey = '6LfBLc0SAAAAAMxF4W6GcT0MMdatKb9qU8bsD5Kp';
$privatekey = '6LfBLc0SAAAAADYEeRmydWsYGrs3koyaDTeXQcl5';
$resp = null;
$error = null;

// Create recaptcha object
$recaptcha =  new ReCaptcha($publickey, $privatekey);

// Was there a reCAPTCHA response?
if (isset($_POST['recaptcha_challenge_field']) && isset($_POST['recaptcha_response_field'])) {
	// init vars
	$remoteip = $_SERVER['REMOTE_ADDR'];
	$challenge = $_POST['recaptcha_challenge_field'];
	$response = $_POST['recaptcha_response_field'];
	$extra_params = array();
	
	/*
	// You can define here recaptcha object if you want to use it only with private key
	$recaptcha =  new ReCaptcha(null, $privatekey);
	*/
	$resp = $recaptcha->checkAnswer($remoteip, $challenge, $response, $extra_params);
	
	/*
	// Procedural version
	$resp = recaptcha_check_answer ($privatekey, $remoteip, $challenge, $response);
	*/

	if (!$resp->is_valid) {
		$error = $resp->error;	// Set the error code so that we can display it
	}
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ReCaptcha Example</title>
    </head>
    <body>
        <div>
            <?php if ($type == 'procedural') { ?>
            
	            <h3>Procedural version</h3>
	            <form action="" method="post" name="proceduralversion">
		            <?php echo recaptcha_get_html($publickey, $error); ?>
		            <br />
		            <input type="submit" value="submit" />
		        </form>
		        		        
            <?php } else { ?>
            	
                <h3>Object version</h3>
                <form action="" method="post" name="objectversion">
	        		<?php
	        			if (!isset($recaptcha)) { $recaptcha = new ReCaptcha($publickey); } // create $recaptcha object if we've used procedural version before.
	           			if (empty($recaptcha->publicKey)) { $recaptcha->publicKey = $publickey; } // set public key if you only have declared object with private key.
	          			echo $recaptcha->createReCaptchaHTML($error, array('use_ssl' => false)); // you also could define no_script option
	            	?>
                    <input type="submit" value="submit" />
                </form>
                
            <?php } ?>
            
            <?php if (isset($resp) && $resp->is_valid) { ?>
                <span>The Captcha is valid</span>
            <?php } ?>
        </div>
    </body>
</html>