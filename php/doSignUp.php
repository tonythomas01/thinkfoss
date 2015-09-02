<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 25/8/15
 * Time: 3:34 PM
 */

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( "Statement.php" );
	$postInput = new Statement( $_POST );
	if ( $postInput->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all require_onced details";
		header( 'Location: '.'../portal.php' );
		return;
	}
	$postInput->sanitize();

	require_once( "access/accessDB.php" );
	require_once( "access/accessTokens.php" );
	require_once( "Token.php" );

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $postInput->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try again";
		header( 'Location: '.'../signup.php');
		return false;
	}

	$user_name = mysqli_escape_string( $conn, $postInput->getValue( 'user_name') );
	if ( !$postInput->isValidName( $postInput->getValue( 'user_first_name' ) ) ){
		$_SESSION['error'] = "Error: The registration was not a success! Please enter first name";
		header( 'Location: '.'../signup.php');
		return false;
	}
	if( !$postInput->isValidName( $postInput->getValue( 'user_last_name' ) ) ) {
		$_SESSION['error'] = "Error: The registration was not a success! Please enter valid last name";
		header( 'Location: '.'../signup.php');
		return false;
	}

	if( !$postInput->isValidEmail( $postInput->getValue( 'user_email') ) ) {
		$_SESSION['error'] = "Error: The registration was not a success! Please enter valid email id";
		header( 'Location: '.'../signup.php');
		return false;
	}

	$user_email = mysqli_escape_string( $conn, $postInput->getValue( 'user_email' ) );
	$user_pass_once = mysqli_escape_string( $conn, $postInput->getValue( 'user_pass_once' ) );

	if ( !checkIfAlreadyMember( $conn, $user_email ) ) {
		//User do not exist. Create a password, store it and send it as an email
		$user_pass_again = mysqli_escape_string( $conn, $postInput->getValue( 'user_pass_again' ) );
		if ( $user_pass_once === $user_pass_again ) {
			$pass = substr( hash_hmac( 'sha512', $user_pass_once, $passwordSecret ), 0, 31 );
			if ( addMember( $conn, $user_email, $pass, $postInput ) ) {
				$_SESSION['message'] = "The registration is successful. Please use the login feature to Sign-In";
				header('Location: ' . '../signup.php');
			}
		}
	} else {
		$_SESSION['error'] = "The user is already a member of this website. Please try logging in";
		header( 'Location: '.'../signup.php');
	}


}

function checkIfAlreadyMember( $conn, $user_email ) {
	$sql = "SELECT * FROM `authorization` WHERE `email_id` = '$user_email';";
	if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
		return true;
	}
	return false;
}

function addMember( $conn, $user_email, $pass, Statement $postInput ) {
	$sql = "INSERT INTO `authorization`(`email_id`, `password_hash` ) VALUES ( '$user_email', '$pass' );";
	if( $conn->query( $sql ) ) {
		$user_first_name = mysqli_escape_string( $conn, $postInput->getValue( 'user_first_name' ) );
		$user_last_name = mysqli_escape_string( $conn, $postInput->getValue( 'user_last_name') );
		$user_dob = mysqli_escape_string( $conn,  $postInput->getValue( 'user_dob' ) );
		if( !$postInput->isValidName( $postInput->getValue('user_gender') ) ) {
			$_SESSION['error'] = "Error: The registration was not a success! Please enter valid inputs";
			header( 'Location: '.'../signup.php');
			return false;
		}
		$user_gender= mysqli_escape_string( $conn, $postInput->getValue( 'user-gender' ) );

		//User successfully inserted now enter data to user db
		$sqlInsertuserDetails = "INSERT INTO `user_details`(`user_id`, `user_first_name`, `user_last_name`,
 			`user_email`, `user_dob`, `user_gender`) VALUES
		('','$user_first_name', '$user_last_name', '$user_email', '$user_dob','$user_gender' );";

		if ( $conn->query( $sqlInsertuserDetails ) ) {
			return true;
		}
	} else {
		return false;
	}
}

function sendEmail( $userEmail ) {
	return true;
}