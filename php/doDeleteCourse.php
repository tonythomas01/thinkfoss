<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( 'Statement.php' );
	$postInputs = new Statement( $_POST );
	if ( $postInputs->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal.php');
		return;
	}
	require_once( 'Token.php' );
	require_once( 'access/accessTokens.php' );

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $postInputs->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'../signup.php');
		return false;
	}

	require_once( 'access/accessDB.php' );
	$postInputs->sanitize();

	$loggedInUser = $_SESSION['loggedin_user_id'];

	require_once( 'Course.php' );
	$courseName = mysqli_real_escape_string( $conn, $postInputs->getValue( 'course' ) );
	$course = explode( '-', $courseName );
	$delCourse = Course::newFromId( $conn, $course[1] );
	if ( $delCourse->isOwner( $loggedInUser ) ) {
		if ( $delCourse->deleteFromDb( $conn ) ) {
			header('Location: ' . '../portal/mentor/viewMyCourses.php');
			$_SESSION['message'] = "The course has been deleted succesfully!";
			return;
		}
	}
	header('Location: ' . '../portal/mentor/viewMyCourses.php');
	$_SESSION['error'] = "We couldn't delete that course. Please contact one of the admins";

}