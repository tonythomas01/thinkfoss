<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	include 'Statement.php';
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal/cart/viewCart.php');
		return;
	}
	include_once("connectToDb.php");
	$conn = new mysqli( $servername, $username, $password );

	if ( $conn->connect_error ) {
		$_SESSION['error'] = "Sorry. We had an error processing your request. Please contact one of the admins";
		header('Location: ' . '../portal/cart/viewCart.php');
	}

	if ( !$conn->select_db($dbname) ) {
		$_SESSION['error'] = "Sorry. We had an error processing your request. Please contact one of the admins";
		header('Location: ' . '../portal/cart/viewCart.php');
	}

	$loggedInUser = $_SESSION['loggedin_user_id'];
	$preparedPost->sanitize();

	include 'Course.php';
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