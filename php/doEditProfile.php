<?php
session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( "Statement.php" );
	$postInput = new Statement($_POST);

	require_once( "Token.php" );
	require_once( "access/accessTokens.php" );
	require_once( "access/captchaTokens.php" );
	require_once( "User.php" );

	if ( !$postInput->validateCaptchaResponse( $postInput->getValue('g-recaptcha-response' ), $captchaSecretKey ) ) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header( 'Location: '.'../portal/profile/myProfile.php');
		return false;
	}

	$postInput->sanitize();

	require_once( "access/accessDB.php" );
	$loggedInUserId = $_SESSION['loggedin_user_id'];

	$user_github = mysqli_escape_string( $conn, $postInput->getValue( 'user_github' ) );
	$user_linkedin = mysqli_escape_string( $conn, $postInput->getValue( 'user_linkedin' ) );
	$user_about = mysqli_escape_string( $conn, $postInput->getValue( 'user_about' ) );
	$user_occupation = mysqli_escape_string( $conn, $postInput->getValue( 'user_occupation' ) );
	$user_nation = mysqli_escape_string( $conn, $postInput->getValue( 'user_nation' ) );
	$user_dob = mysqli_escape_string( $conn, $postInput->getValue( 'user_dob' ) );
	$user_gender = mysqli_escape_string( $conn, $postInput->getValue( 'user_gender' ) );

	$sql = "REPLACE INTO `user_extra`(`user_id`, `user_github`, `user_linkedin`, `user_about`, `user_occupation`, `user_nation`)
		VALUES ( '$loggedInUserId','$user_github','$user_linkedin','$user_about','$user_occupation','$user_nation')";
	if ( $conn->query( $sql ) ) {
		if ( $user_dob ) {
			$sql = "UPDATE `user_details` SET `user_dob` = '$user_dob', `user_gender` = '$user_gender' WHERE `user_id` = '$loggedInUserId';";
			$conn->query( $sql );
			$user = User::newFromUserId( $loggedInUserId, $conn );
			$user->setValue( $conn, 'user_dob', $user_dob );
			$user->setValue( $conn, 'user_gender', $user_gender );
		}
		$_SESSION['message'] = "You have updated your profile. Great!";
		header('Location: ' . '../portal/portal.php');
	} else {
		$_SESSION['error'] = "Looks like there was some error with your inputs. Please contact the administrator";
		header( 'Location: ' . 'portal/profile/myProfile.php' );
	}

}
