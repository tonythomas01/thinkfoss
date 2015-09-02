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
	require_once( 'Statement.php' );
	$postInput = new Statement( $_POST );
	if ( $postInput->checkIfEmptyPost() ) {
		header('Location: ' . '../index.php');
		return;
	}
	require_once( "access/accessDB.php" );
	require_once( "access/accessTokens.php" );
	require_once( "Token.php" );

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $postInput->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try again";
		header( 'Location: '.'../signup.php');
		return false;
	}

	$postInput->sanitize();

	$useremail = mysqli_escape_string( $conn,  $postInput->getValue( 'username' ) );
	$password = mysqli_escape_string( $conn, $postInput->getValue( 'password' ) );

	if ( checkIsMember( $conn, $useremail, $password, $passwordSecret ) ) {
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

function checkIsMember( $conn, $useremail, $password, $passwordSecret ) {
	$hashedPass = substr( hash_hmac( 'sha512', $password, $passwordSecret ), 0, 31 );
	$sql = "SELECT * FROM `authorization` WHERE `email_id` = '$useremail' AND `password_hash` = '$hashedPass';";
	if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
		return true;
	}
	return false;
}

function getUserDetails( $conn, $emailId ) {
	$selectUser = "SELECT `user_id`, `user_first_name`,`user_last_name`, `user_email` FROM `user_details` WHERE `user_email` = '$emailId';";
	$res = $conn->query( $selectUser );
	if( $res->num_rows > 0 ) {
		$user = array();
		while ( $loggedinData = $res->fetch_assoc() ) {
			$user['name'] = $loggedinData['user_first_name']. ''. $loggedinData['user_last_name'];
			$user['email'] = $loggedinData['user_email'];
			$user['user_id'] = $loggedinData['user_id'];
		}

		return $user;
	}
	return false;

}