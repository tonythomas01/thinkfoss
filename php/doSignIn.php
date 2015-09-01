<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 26/8/15
 * Time: 1:11 AM
 */
error_reporting(E_ALL);
session_start();
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if ( checkIfEmptyPost($_POST) ) {
		header('Location: ' . '../index.php');
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

	$preparedPost = prepare_statements( $_POST );

	$useremail = mysqli_escape_string( $conn,  $preparedPost['username'] );
	$password = mysqli_escape_string( $conn, $preparedPost['password'] );

	if ( checkIsMember( $conn, $useremail, $password, $secret ) ) {
		$userDetails = getUserDetails( $conn, $useremail );
		$_SESSION['loggedin_user'] = $userDetails['name'];
		$_SESSION['loggedin_user_email'] = $userDetails['email'];
		$_SESSION['loggedin_user_id'] = $userDetails['user_id'];
		header( 'Location: '.'../portal/portal.php');

	} else {
		$_SESSION['error'] = "Error: Invalid Username/Password entered. Please try again";
		header( 'Location: '.'../signup.php');
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

function getUserDetails( $conn, $emailId ) {
	$user = array();
	$selectUser = "SELECT `user_id`, `user_name`, `user_email` FROM `user_details` WHERE `user_email` = '$emailId';";
	$res = $conn->query( $selectUser );
	if( $res->num_rows > 0 ) {
		$user = array();
		while ( $loggedinData = $res->fetch_assoc() ) {
			$user['name'] = $loggedinData['user_name'];
			$user['email'] = $loggedinData['user_email'];
			$user['user_id'] = $loggedinData['user_id'];
		}

		return $user;
	}
	return false;

}
function checkIfEmptyPost( $input ) {
	foreach( $input as $key => $value ) {
		if ( $value === '' ) {
			return true;
		}
	}
	return false;
}

function prepare_statements( $postInput ) {
	foreach( $postInput as $key => $data ) {
		$data = trim( $data );
		$data = stripslashes( $data );
		$data = htmlspecialchars( $data );
		$postInput['key'] = $data;
	}
	return $postInput;
}
