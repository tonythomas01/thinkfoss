<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 25/8/15
 * Time: 3:34 PM
 */

session_start();
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once("../Statement.php");
	$postInput = new Statement( $_POST );
	if ( $postInput->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all require_once details";
		header( 'Location: '.'../../../forgotPassword.php' );
		return;
	}
	$postInput->sanitize();

	require_once("../access/accessDB.php");
	require_once("../access/accessTokens.php");
	require_once("../Token.php");
	require_once("../access/captchaTokens.php");
	if ( !$postInput->validateCaptchaResponse( $postInput->getValue('g-recaptcha-response' ), $captchaSecretKey ) ) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header( 'Location: '.'../../../forgotPassword.php');
		return false;
	}

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $postInput->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try again";
		header( 'Location: '.'../../../forgotPassword.php');
		return false;
	}

	if( !$postInput->isValidEmail( $postInput->getValue( 'user_email') ) ) {
		$_SESSION['error'] = "Error: The password reset was not a success! Please enter valid email id";
		header( 'Location: '.'../../../forgotPassword.php');
		return false;
	}

	$user_email = mysqli_escape_string( $conn, $postInput->getValue( 'user_email' ) );

	require_once("../User.php");
	$user = User::newFromEmailId( $user_email, $conn );
	if ( $user ) {
		$newPassword = bin2hex( openssl_random_pseudo_bytes(4) );
		$pass = substr( hash_hmac( 'sha512', $newPassword, $passwordSecret ), 0, 31 );
		if ( !$user->updatePassword( $conn, $pass ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../../forgotPassword.php');
			return false;
		}

		require_once( '../access/mailgunAPIKeys.php' );
		require_once( '../vendor/mailgun-php/vendor/autoload.php' );

		$user->sendPasswordResetEmail( $newPassword, $mailgunAPIKey, $mailgunDomain );

		$_SESSION['message'] = "You will receive an email with a new password if your details are found in our Database";
		header('Location: ' . '../../../signup.php');
		return true;



	}
	$_SESSION['message'] = "You will receive an email with a new password if your details are found in our Database";
	header('Location: ' . '../../../signup.php');
	return false;


}