<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( 'Statement.php' );
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal/cart/viewCart.php');
		return;
	}
	require_once( 'Token.php' );
	require_once( 'access/accessTokens.php' );
	require_once( "access/captchaTokens.php" );
	if ( !$preparedPost->validateCaptchaResponse( $preparedPost->getValue('g-recaptcha-response' ), $captchaSecretKey ) ) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header( 'Location: '.'../portal/cart/viewCart.php');
		return false;
	}
	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $preparedPost->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'../portal/cart/viewCart.php');
		return false;
	}
	require_once( "access/accessDB.php" );
	$loggedInUser = $_SESSION['loggedin_user_id'];
	$preparedPost->sanitize();

	require_once( 'Course.php' );
	$courseList =  $_POST[ 'checkout-item' ];
	if ( is_array( $courseList ) ) {
		foreach( $courseList as $course ) {
			$courseRaw = mysqli_real_escape_string( $conn, $course );
			$courseName = explode( '-', $courseRaw );
			$course = Course::newFromId( $conn, $courseName[1] );
			if ( $course ) {
				if ( $course->checkoutCourse( $conn, $loggedInUser ) ) {
					$_SESSION['message'] = "Congratulations! The checkout was successfull!";
					header('Location: ' . '../portal/student/viewAllCourses.php');
				}
			}
		}
	} else {
		$_SESSION['error'] = "Couldn't checkout that course. Please try again";
		header('Location: ' . '../portal/cart/viewCart.php');
	}

}