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
		header( 'Location: '.'../index.html' );
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


	$mentor_name = mysqli_escape_string( $conn, $_POST['mentor_name'] );
	$mentor_email = mysqli_escape_string( $conn, $_POST['mentor_email']);
	$mentor_pass_once = mysqli_escape_string( $conn, $_POST['mentor_pass_once']);

	if ( !checkIfAlreadyMember( $conn, $mentor_email ) ) {
		//User do not exist. Create a password, store it and send it as an email
		$mentor_pass_again = mysqli_escape_string( $conn, $_POST['mentor_pass_again']);
		if ( $mentor_pass_once === $mentor_pass_again ) {
			$pass = substr( hash_hmac( 'sha512', $mentor_pass_again, $secret ), 0, 31 );
			if ( addMember( $conn, $mentor_email, $pass, $_POST ) ) {
				$_SESSION['message'] = "The registration is successful. Please use the login feature to Sign-In";
				header('Location: ' . '../portal.php');
			}
		}
	} else {
		$_SESSION['error'] = "The user is already a member of this website. Please try logging in";
		header( 'Location: '.'../portal.php');
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


function checkIfAlreadyMember( $conn, $mentor_email ) {
	$sql = "SELECT * FROM `authorization` WHERE `email_id` = '$mentor_email';";
	if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
		return true;
	}
	return false;
}

function addMember( $conn, $mentorEmail, $pass, $postData ) {
	$sql = "INSERT INTO `authorization`(`email_id`, `password_hash`, `mentor` ) VALUES ( '$mentorEmail', '$pass', 1 );";
	if( $conn->query( $sql ) ) {
		$mentor_name = mysqli_escape_string( $conn, $_POST['mentor_name'] );
		$mentor_github = mysqli_escape_string( $conn, $_POST['mentor_github'] );
		$mentor_linkedin= mysqli_escape_string( $conn, $_POST['mentor_linkedin'] );
		$mentor_bio= mysqli_escape_string( $conn, $_POST['mentor_bio'] );

		//User successfully inserted now enter data to mentor db
		$sqlInsertMentorDetails = "INSERT INTO `mentor_details`(`mentor_id`, `mentor_name`, `mentor_email`,`mentor_github`, `mentor_linkedin`, `mentor_bio`)
		VALUES ('','$mentor_name','$mentorEmail', '$mentor_github','$mentor_linkedin','$mentor_bio' );";

		if ( $conn->query( $sqlInsertMentorDetails ) ) {
			return true;
		}

		$_SESSION['loggedin_user'] = $mentor_name;
	} else {
		return false;
	}
}

function sendEmail( $userEmail ) {
	return true;
}
