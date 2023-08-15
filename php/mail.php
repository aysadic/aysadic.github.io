<?php

/*--------------------------------------------------

	Name: 			Contact Form
	Written by: 	Harnish Design
	Website: 		http://www.harnishdesign.net

----------------------------------------------------*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';


/* --------------------------------------------
  // Receiver's Email
--------------------------------------------- */

$toEmail = "contact@ayberksadic.com"; // Replace Your Email Address


/* --------------------------------------------
  // Sender's Email
--------------------------------------------- */

$fromEmail = "form@ayberksadic.com";  // Replace Company's Email Address (preferably currently used Domain Name)
$fromName = "Contact Form"; // Replace Company Name


/* --------------------------------------------
  // reCaptcha Secret
  --------------------------------------------- */

// Add this only if you want to use Google reCaptcha with your Contact Forms.
$recaptcha_secret = '6LeScN4aAAAAAIJ4QZqfD7nAEGPfbnIlHYt9ySgZ'; // Your Google reCaptcha Secret


/* --------------------------------------------
  // Subject
--------------------------------------------- */
$subject = "Form Response from Your Website"; // Your Subject


if (isset($_POST['name'])) {

/*-------------------------------------------------
	PHPMailer Initialization
---------------------------------------------------*/

$mail = new PHPMailer(true);

/* Add your SMTP Codes after this Line */
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.yandex.com';
$mail->SMTPAuth = true;
$mail->Username = "form@ayberksadic.com";
$mail->Password = "iayyxudldbpvhxdc";
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// End of SMTP

if (filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {

	$mail->AddAddress($toEmail);
	$mail->setFrom($fromEmail, $fromName);
	$mail->addReplyTo($_POST['email'], $_POST['name']);

	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	
	$mail->Subject = $subject . ' [' . $_POST['name'] . ']';

	$mail->Body = '<table align="center" border="0" cellpadding="0" cellspacing="20" height="100%" width="100%">
						<tr>
							<td align="center" valign="top">
								<table width="600" bgcolor="#f8f6fe" cellpadding="7" style="font-size:16px; padding:30px; line-height: 28px;">
									<tr>
										<td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Name:</strong></td>
										<td>' . $_POST['name'] . '</td>
									</tr>
									<tr>
										<td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Email:</strong></td>
										<td>' . $_POST['email'] . '</td>
									</tr>
									<tr>
										<td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Message:</strong></td>
										<td>' . $_POST['form-message'] . '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>';
	
	/*-------------------------------------------------
		reCaptcha
	---------------------------------------------------*/
	$message = array(
		'recaptcha_invalid' => 'Captcha not Validated! Please Try Again!',
		'recaptcha_error' => 'Captcha not Submitted! Please Try Again.'
	);
	$message_form = !empty($_POST['message']) ? $_POST['message'] : array();
	$message['recaptcha_invalid'] = !empty($message_form['recaptcha_invalid']) ? $message_form['recaptcha_invalid'] : $message['recaptcha_invalid'];
	$message['recaptcha_error'] = !empty($message_form['recaptcha_error']) ? $message_form['recaptcha_error'] : $message['recaptcha_error'];

	if (isset($_POST['g-recaptcha-response'])) {
		$recaptcha_data = array(
			'secret' => $recaptcha_secret,
			'response' => $_POST['g-recaptcha-response']
		);

		$recap_verify = curl_init();
		curl_setopt($recap_verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($recap_verify, CURLOPT_POST, true);
		curl_setopt($recap_verify, CURLOPT_POSTFIELDS, http_build_query($recaptcha_data));
		curl_setopt($recap_verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($recap_verify, CURLOPT_RETURNTRANSFER, true);
		$recap_response = curl_exec($recap_verify);
		$g_response = json_decode($recap_response);

		if ($g_response->success !== true) {
			echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> ' . $message['recaptcha_invalid'] . '<button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
			exit;
		}
	}

	$forcerecap = (!empty($_POST['force_recaptcha']) && $_POST['force_recaptcha'] != 'false' ) ? true : false;
	if (isset($g_response->action) && $g_response->action == 'contact') {
		if (isset($g_response->success) && $g_response->success == true && $g_response->action == 'contact') {
			
		} else if ($forcerecap) {
			if (!isset($_POST['g-recaptcha-response'])) {
				echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> ' . $message['recaptcha_error'] . '<button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
				exit;
			}
		} else {
			echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> ' . $message['recaptcha_error'] . '<button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
			exit;
		}
	}
	//----- reCaptcha End -----//

	$success = "Thank you for contacting me. I will be in touch with you very soon."; // Success Message

	try {
		$resp = $mail->send();
		echo json_encode(array('response' => 'success', 'Message' => '<div class="alert alert-success alert-dismissible fade show text-3 text-left"><i class="fa fa-check-circle"></i> ' . $success . ' <button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
		exit;
	} catch (Exception $e) {
		echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> Message could not be sent: ' . $e->errorMessage() . '<button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
		exit;
	} catch (\Exception $e) {
		echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> Message could not be sent: ' . $e->getMessage() . '<button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
		exit;
	}
} else {
	echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> There is a invalid <strong>Receivers Email</strong> address! <button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
	exit;
}
} else {
    echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-3 text-left"><i class="fa fa-times-circle"></i> There is a problem with the document! <button type="button" class="close font-weight-500 mt-1" data-dismiss="alert">&times;</button></div>'));
    exit;
}
?>