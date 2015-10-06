<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once('Statement.php');
	$postInputs = new Statement( $_POST );
	if ( $postInputs->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../../portal/portal.php');
		return;
	}
	require_once("access/accessTokens.php");
	require_once("Token.php");

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $postInputs->getValue( 'csrf_token' ) ) ) {
		return false;
	}

	require_once('access/accessDB.php');
	$postInputs->sanitize();

	$loggedInUser = $_SESSION[ 'loggedin_user_id' ];

	require_once('Course.php');
	$courseName = mysqli_real_escape_string( $conn, $postInputs->getValue( 'course_id' ) );
	$course = explode( '-', $courseName );
	$delCourse = Course::newFromId( $conn, $course[1] );
	$delCourse->removeFromCart( $conn, $loggedInUser );

}