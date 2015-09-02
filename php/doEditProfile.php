<?php
session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	include "Statement.php";
	$postInput = new Statement($_POST);
	if ($postInput->checkIfEmptyPost()) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal/portal.php');
		return;
	}
	$postInput->sanitize();

	require( "access/accessDB.php" );
	$loggedInUserId = $_SESSION['loggedin_user_id'];

	$user_github = mysqli_escape_string( $conn, $postInput->getValue( 'user_github' ) );
	$user_linkedin = mysqli_escape_string( $conn, $postInput->getValue( 'user_linkedin' ) );
	$user_about = mysqli_escape_string( $conn, $postInput->getValue( 'user_about' ) );
	$user_occupation = mysqli_escape_string( $conn, $postInput->getValue( 'user_occupation' ) );
	$user_nation = mysqli_escape_string( $conn, $postInput->getValue( 'user_nation' ) );

	$sql = "REPLACE INTO `user_extra`(`user_id`, `user_github`, `user_linkedin`, `user_about`, `user_occupation`, `user_nation`)
		VALUES ( '$loggedInUserId','$user_github','$user_linkedin','$user_about','$user_occupation','$user_nation')";
	if ( $conn->query( $sql ) ) {
		$_SESSION['message'] = "You have updated your profile. Great!";
		header('Location: ' . '../portal/portal.php');
	} else {
		$_SESSION['error'] = "Looks like there was some error with your inputs. Please contact the administrator";
		header( 'Location: ' . 'portal/profile/myProfile.php' );
	}

}
