<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once('../Statement.php');
	$preparedPost = new Statement($_POST);
	if ($preparedPost->checkIfEmptyPost()) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../../../portal/portal.php');
		return;
	}
	require_once('../Token.php');
	require_once('../access/accessTokens.php');
	require_once("../access/captchaTokens.php");
	if (!$preparedPost->validateCaptchaResponse($preparedPost->getValue('g-recaptcha-response'), $captchaSecretKey)) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header('Location: ' . '../../../signup.php');
		return false;
	}

	$csrfToken = new Token($csrfSecret);
	if (!$csrfToken->validateCSRFToken($preparedPost->getValue('CSRFToken'))) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try again";
		header('Location: ' . '../../../portal/portal.php');
		return false;
	}
	require_once("../access/accessDB.php");
	require_once("../User.php");
	$preparedPost->sanitize();
	$loggedinUserId = $_SESSION['loggedin_user_id'];

	$updatingUser = User::newFromUserId( $loggedinUserId, $conn );

	$solutionId  = mysqli_escape_string( $conn, base64_decode( $preparedPost->getValue('solution_id') ) );

	require_once("../Solution.php");
	$solution = Solution::newFromId( $conn, $solutionId );

	if ( !$solution->isOwner( $loggedinUserId ) && !$updatingUser->checkIfPrivelaged( $conn ) ){
		$_SESSION['error'] = "Error : You are not supposed to edit that one.";
		header( 'Location: '.'../../../portal/solutions/mySolutionRequests.php' );
		return false;
	}

	$solution_name = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_name' ) );
	$solution_platform = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_platform' ) );
	$solution_framework = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_framework' ) );
	$solution_contact = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_contact' ) );
	$solution_date_estimated = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_deadline_estimated' ) );
	$solution_amount = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_amount' ) );
	$solution_bio = mysqli_escape_string( $conn, $preparedPost->getValue( 'solution_bio' ) );
	$solution_request_user_id = $_SESSION['loggedin_user_id'] ? : false;



	if ( $solution->updateDb( $conn, $solution_name, $solution_platform, $solution_framework, $solution_contact,
		$solution_date_estimated, $solution_amount, $solution_bio ) ) {
		$_SESSION['message'] = "Success! You have updated your solution request";
		header( 'Location: '.'../../../portal/solutions/mySolutionRequests.php' );
		return true;
	} else {
		$_SESSION['error'] = "Error : An unknown error occured. Please contact one of the admins ";
		header( 'Location: '.'../../../portal/ssolutions/mySolutionRequests.php' );
		return false;
	}


}



