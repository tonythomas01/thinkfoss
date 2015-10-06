<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once('Statement.php');
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../../portal/admin/adminPanel.php');
		return;
	}
	require_once('Token.php');
	require_once('access/accessTokens.php');
	require_once("access/captchaTokens.php");

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $preparedPost->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'../portal/admin/adminPanel.php');
		return false;
	}
	require_once("access/accessDB.php");
	$loggedInUser = $_SESSION['loggedin_user_id'];
	$preparedPost->sanitize();

	require_once('Course.php');
	$courseList =  $_POST[ 'course-future' ];
	require_once( 'access/mailgunAPIKeys.php' );
	if ( is_array( $courseList ) ) {
		foreach( $courseList as $course ) {
			$courseRaw = mysqli_real_escape_string( $conn, $course );
			$courseName = explode( '-', $courseRaw );
			$course = Course::newFromId( $conn, $courseName[2] );
			if ( $course && $courseName[1] == "approve" ) {
				$course->approveCourseByAdmin( $conn, $loggedInUser );
				$course->sendCourseApprovedEmail( $conn, $mailgunAPIKey, $mailgunDomain );
			} else if ( $course && $courseName[1] == "remove" ){
				$course->removeCourseByAdmin( $conn, $loggedInUser );
			}
		}
		$_SESSION['message'] = "Requested activity done, master";
		header('Location: ' . '../../portal/admin/adminPanel.php' );
	} else {
		$_SESSION['error'] = "That didnt work. Please try again";
		header('Location: ' . '../../portal/admin/adminPanel.php' );
	}

}