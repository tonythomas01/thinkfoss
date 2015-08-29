<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if (checkIfEmptyPost($_POST)) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal.php');
		return;
	}
	include_once("connectToDb.php");
	$conn = new mysqli($servername, $username, $password);

	if ($conn->connect_error) {
		die("Connection failed");
	}

	if (!$conn->select_db($dbname)) {
		die("Database selection error");
	}


	$course_name = mysqli_escape_string( $conn, $_POST['course_name'] );
	$course_bio = mysqli_escape_string( $conn, $_POST['course_bio'] );
	$course_lang = mysqli_escape_string( $conn, $_POST['course_lang'] );
	$course_difficulty = mysqli_escape_string( $conn, $_POST['course_difficulty'] );
	$course_date_from = mysqli_escape_string( $conn, $_POST['course_date_from'] );
	$course_time_from = mysqli_escape_string( $conn, $_POST['course_time_from'] );
	$course_date_to = mysqli_escape_string( $conn, $_POST['course_date_to'] );
	$course_time_to = mysqli_escape_string( $conn, $_POST['course_time_to'] );
	$course_amount = mysqli_escape_string( $conn, $_POST['course_amount'] );
	$course_mentor = $_SESSION['loggedin_user_id'];

	include 'Course.php';
	$newCourse = Course::newFromDetails( $course_name, $course_bio, $course_lang, $course_difficulty, $course_date_from,
		$course_time_from, $course_date_to, $course_time_to, $course_amount, $course_mentor );

	if ( $newCourse->addToDatabase( $conn ) ) {
		$newCourse->addToMentorMap( $conn, $course_mentor );
		$_SESSION['message'] = "Success! New course added. Please wait for confirmation from admin";
		header( 'Location: '.'../portal/portal.php' );

	} else {
		$_SESSION['error'] = "Cannot add New course. Please try again";
		header( 'Location: '.'../portal/portal.php' );
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