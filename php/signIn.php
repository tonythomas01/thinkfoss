<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 26/8/15
 * Time: 1:11 AM
 */
session_start();
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if (checkIfEmptyPost($_POST)) {
		header('Location: ' . '../index.html');
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

	print_r( $_POST );
	$useremail = mysqli_escape_string( $conn, $_POST['username']);
	$password = mysqli_escape_string( $conn, $_POST['password']);

	if ( checkIsMember( $conn, $mentor_email, $mentor_pass_once, $secret ) ) {
		$userDetails = getUserDetails( $useremail, $password );
		$_SESSION['loggedin-user'] = $mentor_email;
		header( 'Location: '.'../portal.php');

	}

}

function checkIsMember( $conn, $useremail, $password, $secret ) {
	$hashedPass = substr( hash_hmac( 'sha512', $password, $secret ), 0, 31 );
	$sql = "SELECT * FROM `authorization` WHERE `email_id` = '$useremail' AND `password_hash` = '$hashedPass';";
	if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
		return true;
	}
	return false;
}

function getUserDetails( $emailId, $hashedPass ) {
	$user = array();
	$sql = "SELECT `mentor` FROM `authorization` WHERE `email_id` = '$useremail' AND `password_hash` = '$password';";
	if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
		return true;
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
