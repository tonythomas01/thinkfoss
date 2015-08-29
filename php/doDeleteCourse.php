<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if (checkIfEmptyPost($_POST)) {
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
	$courseName = mysqli_real_escape_string( $conn, $_POST['course'] );
	$course = explode('-', $courseName );
	$delCourse = Course::newFromId( $conn, $course[1] );
	if ( $delCourse->isOwner( $loggedInUser ) ) {
		if ( $delCourse->deleteFromDb( $conn ) ) {
			header('Location: ' . '../portal/mentor/viewMyCourses.php');
			$_SESSION['message'] = "The course has been deleted succesfully!";
			return;
		}
	}
	header('Location: ' . '../portal/mentor/viewMyCourses.php');
	$_SESSION['error'] = "We couldnt delete that course. Please contact one of the admins";

}

function checkIfEmptyPost( $input ) {
	foreach( $input as $key => $value ) {
		if ( $value === '' ) {
			return true;
		}
	}
	return false;
}