<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once('Statement.php');
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../../portal/portal.php');
		return;
	}
	require_once('Token.php');
	require_once('access/accessTokens.php');
	require_once("access/captchaTokens.php");
	if ( !$preparedPost->validateCaptchaResponse( $preparedPost->getValue('g-recaptcha-response' ), $captchaSecretKey ) ) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header( 'Location: '.'../../signup.php');
		return false;
	}

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $preparedPost->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try again";
		header( 'Location: '.'../../portal/portal.php' );
		return false;
	}
	require_once("access/accessDB.php");
	$preparedPost->sanitize();

	$course_id = mysqli_escape_string( $conn, base64_decode( $preparedPost->getValue('course_id') ) );

	$course_name = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_name' ) );
	$course_bio = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_bio' ) );
	$course_lang = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_lang' ) );
	$course_difficulty = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_difficulty' ) );
	$course_date_from = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_date_from' ) );
	$course_time_from = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_time_from' )  );
	$course_date_to = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_date_to' ) );
	$course_time_to = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_time_to' ) );
	$course_amount = mysqli_escape_string( $conn, $preparedPost->getValue( 'course_amount' ) );
	$current_user_id = $_SESSION['loggedin_user_id'];

	require_once('Course.php');
	$updateCourse = Course::newFromId( $conn, $course_id );
	if ( $updateCourse->UpdateDatabase( $conn, $course_name, $course_bio, $course_lang, $course_difficulty, $course_date_from,
		$course_time_from,$course_date_to, $course_time_to, $course_amount  ) ) {
		$_SESSION['message'] = "Updated course successfully!";
		header( 'Location: '.'../../portal/mentor/viewMyCourses.php' );

	} else {
		$_SESSION['error'] = "Cannot edit the course. Please try again";
		header( 'Location: '.'../../portal/mentor/viewMyCourses.php' );
	}

}