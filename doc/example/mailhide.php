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
$publickey = '01EziFmQ6uXPniBbGUd9831g==';
$privatekey = '29da1875574394e3fb922dde9d1ea637';
$mail = 'johndoe@example.com';
$name = 'John Doe';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ReCaptcha mail hide Example</title>
    </head>
    <body>
        <div>
            <?php if ($type == 'procedural') { ?>
            
	            <h3>Procedural version</h3>
	            
	            <span>The Mailhide version of <?php echo $mail; ?> is :</span><br />
		        <span><?php echo recaptcha_mailhide_html($publickey, $privatekey, $mail); ?></span>
		        <br />
                <br />
		        <span>The url for the email is :</span><br />
		        <span><?php echo recaptcha_mailhide_url($publickey, $privatekey, $mail); ?></span>
	        
            <?php } else { ?>
            
	            <h3>Object version</h3>
	            
	            <span>The Mailhide version of <?php echo $mail; ?> is :</span><br />
	            <span>
	                <?php $recaptcha = new ReCaptchaMailHide($publickey, $privatekey, $mail);
	                      echo $recaptcha->createReCaptchaHTML(); ?>
	            </span>
	            <br />
                <br />
                <span>The Mailhide version of <?php echo $mail; ?> with the name <?php echo $name; ?> is :</span><br />
                <span>
                    <?php 
                    	  $recaptcha = new ReCaptchaMailHide($publickey, $privatekey, $mail);
                    	  $recaptcha->setName($name);
                          echo $recaptcha->createReCaptchaHTML();
                    ?>
                </span>
                <br />
                <br />
	            <span>The url for the email is :</span><br />
	            <span><?php echo $recaptcha->createMailhideURL(); ?></span>
            
            <?php } ?>
        </div>
    </body>
</html>