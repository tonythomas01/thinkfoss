<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if (checkIfEmptyPost($_POST)) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal/cart/viewCart.php');
		return;
	}
	include_once("connectToDb.php");
	$conn = new mysqli( $servername, $username, $password );

	if ($conn->connect_error) {
		die("Connection failed");
	}

	if (!$conn->select_db($dbname)) {
		die("Database selection error");
	}

	$loggedInUser = $_SESSION['loggedin_user_id'];

	include 'Course.php';
	$courseList =  $_POST['checkout-item'];
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

function checkIfEmptyPost( $input ) {
	foreach( $input as $key => $value ) {
		if ( $value === '' ) {
			return true;
		}
	}
	return false;
}