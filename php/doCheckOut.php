<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( 'Statement.php' );
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../portal/cart/viewCart.php');
		return;
	}
	require_once( 'Token.php' );
	require_once( 'access/accessTokens.php' );
	require_once( "access/captchaTokens.php" );
	if ( !$preparedPost->validateCaptchaResponse( $preparedPost->getValue('g-recaptcha-response' ), $captchaSecretKey ) ) {
		$_SESSION['error'] = "Error: Invalid Captcha Entered. Please contact one of the admins, or try again";
		header( 'Location: '.'../portal/cart/viewCart.php');
		return false;
	}
	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $preparedPost->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'../portal/cart/viewCart.php');
		return false;
	}
	require_once( "access/accessDB.php" );
	$loggedInUser = $_SESSION['loggedin_user_id'];
	$preparedPost->sanitize();

	require_once( 'Course.php' );
	require_once( 'User.php' );

	$checkingOutUser = User::newFromUserId( $loggedInUser, $conn );

	require_once( 'access/mailgunAPIKeys.php' );
	$courseList =  $_POST[ 'checkout-item' ];



	if ( is_array( $courseList ) ) {
		foreach( $courseList as $course ) {
			$courseRaw = mysqli_real_escape_string( $conn, $course );
			$courseName = explode( '-', $courseRaw );
			$course = Course::newFromId( $conn, $courseName[1] );
			if ( $course ) {
				require_once( 'access/ccavenueKeys.php');
				include('vendor/cc_avenue_kit/Crypto.php');

				$merchentData = array(
						'merchant_id' => $merchant_id,
						'order_id' => rand(),
						'currency' => 'INR',
						'amount' => $course->getValue( 'course_fees' ),
						'language' => 'en',
						'redirect_url' => 'http://beta.thinkfoss.com/portal/cart/viewCart.php',
						'cancel_url' => 'http://beta.thinkfoss.com/portal/cart/viewCart.php'
				);


				$merchant_data = '';

				foreach ( $merchentData as $key => $value){
					$merchant_data.=$key.'='.$value.'&';
				}

				$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

				echo '
				<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">';
				echo "<input type=hidden name=encRequest value=$encrypted_data>";
				echo "<input type=hidden name=access_code value=$access_code>";

				echo '<script language="javascript">document.redirect.submit();</script>';


//					if ($course->checkoutCourse($conn, $loggedInUser)) {
//						$course->notifyMentor($conn, $mailgunAPIKey, $mailgunDomain);
//						$_SESSION['message'] = "Congratulations! The checkout was successful!";
//						header('Location: ' . '../portal/student/viewAllCourses.php');
//					}

			}
		}
	} else {
		$_SESSION['error'] = "Couldn't checkout that course. Please try again";
		header('Location: ' . '../portal/cart/viewCart.php');
	}

}