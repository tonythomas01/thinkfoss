<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if (checkIfEmptyPost($_POST)) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal/portal.php');
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

	$cf_course_id = mysqli_escape_string( $conn, $_POST['course_id'] );
	$cf_mentor_score = mysqli_escape_string( $conn, $_POST['mentor_score'] );
	$cf_portal_score = mysqli_escape_string( $conn, $_POST['portal_score'] );
	$cf_payment_score = mysqli_escape_string( $conn, $_POST['payment_score'] );
	$cf_general_review = mysqli_escape_string( $conn, $_POST['general_review'] );
	$cf_improve_review = mysqli_escape_string( $conn, $_POST['improve_review'] );
	$cf_recommend = mysqli_escape_string( $conn, $_POST['recommend'] );
	$cf_join_thinkfoss = mysqli_escape_string( $conn, $_POST['join_thinkfoss'] );

	$sqlInsert = "INSERT INTO `course_feedback`(`cf_user_id`, `cf_course_id`, `cf_mentor_score`, `cf_portal_score`,
		 `cf_payment_score`, `cf_general_review`, `cf_improve_review`, `cf_recommend`, `cf_join_thinkfoss`) VALUES
		  ('$loggedInUser','$cf_course_id','$cf_mentor_score','$cf_portal_score','$cf_payment_score','$cf_general_review',
		  '$cf_improve_review','$cf_recommend','$cf_join_thinkfoss')";

	if ( $conn->query( $sqlInsert ) ) {
		$_SESSION['message'] = "Thank You! You have successfully submitted your review. We are grateful for it!";
		header('Location: ' . '../portal/student/viewEnrolledCourses.php');
	} else {
		$_SESSION['erro'] = "There was a problem mangaing your review. Please contact one of the admins";
		header('Location: ' . '../portal/student/viewEnrolledCourses.php');
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