<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once('../Statement.php');
	$preparedPost = new Statement($_POST);
	if ($preparedPost->checkIfEmptyPost()) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../../portal/portal.php');
		return;
	}
	require_once('../Token.php');
	require_once('../access/accessTokens.php');
	require_once("../access/captchaTokens.php");
	if (!$preparedPost->validateCaptchaResponse($preparedPost->getValue('g-recaptcha-response'), $captchaSecretKey)) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header('Location: ' . '../../signup.php');
		return false;
	}

	$csrfToken = new Token($csrfSecret);
	if (!$csrfToken->validateCSRFToken($preparedPost->getValue('CSRFToken'))) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try again";
		header('Location: ' . '../../portal/portal.php');
		return false;
	}
	require_once("../access/accessDB.php");
	$preparedPost->sanitize();

	$solution_name = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_name' ) );
	$solution_platform = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_platform' ) );
	$solution_framework = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_framework' ) );
	$solution_contact = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_contact' ) );
	$solution_date_estimated = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_deadline_estimated' ) );
	$solution_amount = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_amount' ) );
	$solution_bio = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_bio' ) );
	$solution_request_user_id = $_SESSION['loggedin_user_id'] ? : false;

	require_once("../Solution.php");

	$solution = Solution::newFromDetails( $solution_name, $solution_platform, $solution_framework, $solution_contact,
		$solution_date_estimated, $solution_amount, $solution_bio, $solution_request_user_id );

	if ( $solution->addToDatabase( $conn ) ) {
		$_SESSION['message'] = "Success! You have submitted your solution request. Please wait for confirmation from admin";
		require_once( '../access/mailgunAPIKeys.php' );
		$solution->sendSolutionCreatedEmail( $conn, $solution_request_user_id, $mailgunAPIKey, $mailgunDomain );
		header( 'Location: '.'../../portal/portal.php' );
		return true;
	} else {
		$_SESSION['error'] = "Error : An unknown error occured. Please contact one of the admins ";
		header( 'Location: '.'../../portal/solutions/newSolutionRequest.php' );
		return false;
	}


}



