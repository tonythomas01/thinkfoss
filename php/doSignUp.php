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
	$postInput = prepare_statements( $_POST );


	$user_name = mysqli_escape_string( $conn, $postInput['user_name'] );
	if ( preg_match( "/^[a-zA-Z\s-]+$/i", $postInput['user_first_name'] ) == 0 ) {
		$_SESSION['error'] = "Error: The registration was not a success! Please enter first name";
		header( 'Location: '.'../signup.php');
		return false;
	}
	if( preg_match( "/^[a-zA-Z\s-]+$/i", $postInput['user_last_name'] ) == 0) {
		$_SESSION['error'] = "Error: The registration was not a success! Please enter valid last name";
		header( 'Location: '.'../signup.php');
		return false;
	}
	$user_email = mysqli_escape_string( $conn, $postInput['user_email'] );
	if ( !filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {
		$_SESSION['error'] = "Error: The registration was not a success! Please enter valid email id";
		header( 'Location: '.'../signup.php');
		return false;
	}
	$user_pass_once = mysqli_escape_string( $conn, $postInput['user_pass_once'] );

	if ( !checkIfAlreadyMember( $conn, $user_email ) ) {
		//User do not exist. Create a password, store it and send it as an email
		$user_pass_again = mysqli_escape_string( $conn, $postInput['user_pass_again'] );
		if ( $user_pass_once === $user_pass_again ) {
			$pass = substr( hash_hmac( 'sha512', $user_pass_once, $secret ), 0, 31 );
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

function addMember( $conn, $user_email, $pass, $postInput ) {
	$sql = "INSERT INTO `authorization`(`email_id`, `password_hash` ) VALUES ( '$user_email', '$pass' );";
	if( $conn->query( $sql ) ) {
		$user_first_name = mysqli_escape_string( $conn, $postInput['user_first_name'] );
		$user_last_name = mysqli_escape_string( $conn, $postInput['user_last_name'] );
		$user_dob = mysqli_escape_string( $conn,  $postInput['user_dob'] );
		$user_gender= mysqli_escape_string( $conn, $postInput['user-gender'] );

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

function prepare_statements( $postInput ) {
	foreach( $postInput as $key => $data ) {
		$data = trim( $data );
		$data = stripslashes( $data );
		$data = htmlspecialchars( $data );
		$postInput['key'] = $data;
	}
	return $postInput;
}
