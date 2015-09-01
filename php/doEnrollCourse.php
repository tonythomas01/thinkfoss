<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	include 'Statement.php';
	$preparedStatement = new Statement( $_POST );
	if ( $preparedStatement->checkIfEmptyPost( $_POST ) ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal.php');
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

	$preparedStatement->sanitize();
	$courseName = mysqli_real_escape_string( $conn, $preparedStatement->getValue('course' ) );
	$courseRaw = explode( '-', $courseName );
	$course = Course::newFromId( $conn, $courseRaw[1] );
	if ( $course ) {
		if ( $course->enrollUser( $conn, $loggedInUser ) ) {
			$_SESSION['message'] = "Congratulations! You have added the course to your cart!";
			header('Location: ' . '../portal/student/viewAllCourses.php');

		} else {
			$_SESSION['error'] = "You are already enrolled to that course";
			header('Location: ' . '../portal/student/viewAllCourses.php');
		}
	} else {
		$_SESSION['error'] = "Couldn't enroll you for that course. Please try again";
		header('Location: ' . '../portal/student/viewAllCourses.php');
	}

}