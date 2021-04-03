<?php
define('WP_USE_THEMES', false);
require('../../../wp-load.php');

$recaptchaSecret = get_option( 'wickedcf_settings' )['recaptcha_secret'];

$name    = sanitize_text_field( $_POST['wickedcf_name'] );
$email   = sanitize_email( $_POST['wickedcf_email'] );
$phone   = sanitize_text_field( $_POST['wickedcf_phone'] );
$message = sanitize_text_field( $_POST['wickedcf_message'] );

require_once 'autoload.php';

$errors = [];

$recaptcha = new \ReCaptcha\ReCaptcha( $recaptchaSecret );

if( empty( $recaptchaSecret ) ){
	array_push( $errors, 'no_keys' );
}

$resp = $recaptcha->setExpectedHostname( $_SERVER['SERVER_NAME'] )
                  ->setExpectedAction( 'submit' )
                  ->setScoreThreshold( 0.5 )
                  ->verify( $_POST['recaptchaToken'], $_SERVER['REMOTE_ADDR'] );
if( !$resp->isSuccess() ){
    array_push( $errors, 'recaptcha_failed' );
}



if( !$name ) {
	array_push( $errors, 'no_name' );
}

if( !$email && !$phone ) {
	array_push( $errors, 'no_email_or_phone' );
}

if( !$message ) {
	array_push( $errors, 'no_message' );
}

if( $email && !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
	array_push( $errors, 'invalid_email' );
}

$mail_content = "<h2>Contact form submission</h2><dl><dt>Name:</dt><dd>" . $name . "</dd><dt>Email:</dt><dd>" . $email . "</dd><dt>Phone:</dt><dd>" . $phone . "</dd><dt>Message:</dt><dd>" . $message . "</dd></dl><p><small>This email was sent via the " . get_bloginfo( 'title' ) . " contact form. " . date( 'g:i a, jS M Y' ) . "</small></p>";

$mail_headers = 'From: edadams101@gmail.com' . "\r\n" .
    'Content-Type: text/html; charset=UTF-8';

if( !empty( $errors ) ){
	$response = array(
		'success' => false,
		'errors' => $errors
	);
} else {
	$response = array(
		'success' => true
	);

	wp_mail( 'edadams101@gmail.com', 'Contact form submission', $mail_content, $mail_headers );
}

header('Content-Type: application/json');

echo json_encode( $response );
?>