<?php

// X3 Mailer
// Routes between PHPMailer6 (PHP >= 5.5) and PHPMailer5 (PHP <= 5.4)

//use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function x3_mail($stmp){
	if (version_compare(PHP_VERSION, '5.5.0') >= 0) {
		require __DIR__ . '/extensions/PHPMailer6/src/Exception.php';
		require __DIR__ . '/extensions/PHPMailer6/src/PHPMailer.php';
		if($stmp) require __DIR__ . '/extensions/PHPMailer6/src/SMTP.php';
		return new PHPMailer\PHPMailer\PHPMailer;
	} else {
		require __DIR__ . '/extensions/PHPMailer5/PHPMailerAutoload.php';
		return new PHPMailer;
	}
}

?>