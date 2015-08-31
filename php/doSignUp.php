<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 25/8/15
 * Time: 3:34 PM
 */

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if ( checkIfEmptyPost( $_POST ) ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header( 'Location: '.'../portal.php' );
		return;
	}
	include_once( "connectToDb.php" );
	$conn = new mysqli( $servername, $username, $password );

	if ( $conn->connect_error ){
		die( "Connection failed");
	}

	if ( !$conn->select_db( $dbname ) ) {
		die( "Database selection error" );
	}


	$user_name = mysqli_escape_string( $conn, $_POST['user_name'] );
	$user_email = mysqli_escape_string( $conn, $_POST['user_email']);
	$user_pass_once = mysqli_escape_string( $conn, $_POST['user_pass_once']);

	if ( !checkIfAlreadyMember( $conn, $user_email ) ) {
		//User do not exist. Create a password, store it and send it as an email
		$user_pass_again = mysqli_escape_string( $conn, $_POST['user_pass_again']);
		if ( $user_pass_once === $user_pass_again ) {
			$pass = substr( hash_hmac( 'sha512', $user_pass_once, $secret ), 0, 31 );
			if ( addMember( $conn, $user_email, $pass ) ) {
				$_SESSION['message'] = "The registration is successful. Please use the login feature to Sign-In";
				header('Location: ' . '../signup.php');
			}
		}
	} else {
		$_SESSION['error'] = "The user is already a member of this website. Please try logging in";
		header( 'Location: '.'../signup.php');
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


function checkIfAlreadyMember( $conn, $user_email ) {
	$sql = "SELECT * FROM `authorization` WHERE `email_id` = '$user_email';";
	if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
		return true;
	}
	return false;
}

function addMember( $conn, $user_email, $pass ) {
	$sql = "INSERT INTO `authorization`(`email_id`, `password_hash` ) VALUES ( '$user_email', '$pass' );";
	if( $conn->query( $sql ) ) {
		$user_name = mysqli_escape_string( $conn, $_POST['user_name'] );
		$user_dob = mysqli_escape_string( $conn, $_POST['user_dob'] );
		$user_gender= mysqli_escape_string( $conn, $_POST['user-gender'] );

		//User successfully inserted now enter data to user db
		$sqlInsertuserDetails = "INSERT INTO `user_details`(`user_id`, `user_name`, `user_email`, `user_dob`, `user_gender`) VALUES
		('','$user_name','$user_email', '$user_dob','$user_gender' );";

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
