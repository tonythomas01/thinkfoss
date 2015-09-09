<?php
require_once '../vendor/google-api-php-client-master/autoload.php';

session_start();


$client = new Google_Client();
$client->setAuthConfigFile('../access/client_secret.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/php/oauth/oauth2callback.php');
$client->addScope( Google_Service_Plus::USERINFO_EMAIL );
$client->addScope( Google_Service_Plus::PLUS_ME );

if (!isset($_GET['code'])) {
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
	require_once('../User.php');
	require_once('../access/accessDB.php');
	require_once('../access/accessTokens.php');

	$client->authenticate( $_GET['code'] );
	$oauthUser = new Google_Service_Oauth2( $client );

	$user = User::newFromGoogleOauth( $oauthUser->userinfo->get() );

	if ( $user->isExistingMember( $conn ) ) {
		$_SESSION['loggedin_user'] = $user->getValue( 'user_first_name' ) . ' ' . $user->getValue('user_last_name');
		$_SESSION['loggedin_user_email'] = $user->getValue( 'user_email' );
		$_SESSION['loggedin_user_id'] = $user->getUserFreshId( $conn );
		header( 'Location: '.'../../portal/portal.php');
	} else {
		//Add to authorization and user table
		$newPassword = bin2hex( openssl_random_pseudo_bytes(4) );
		$pass = substr( hash_hmac( 'sha512', $newPassword, $passwordSecret ), 0, 31 );
		if ( !$user->setPassword( $conn, $pass ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../signup.php');
			return false;
		}

		if ( !$user->addToDatabase( $conn ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../signup.php');
			return false;
		}
		require_once( '../access/mailgunAPIKeys.php' );
		require_once( '../vendor/mailgun-php/vendor/autoload.php' );

		$user->sendWelcomeEmail( $newPassword, $mailgunAPIKey, $mailgunDomain );

		$_SESSION['loggedin_user'] = $user->getValue( 'user_first_name' ) . ' ' . $user->getValue('user_last_name');
		$_SESSION['loggedin_user_email'] = $user->getValue( 'user_email' );
		$_SESSION['loggedin_user_id'] = $user->getUserFreshId( $conn );
		header( 'Location: '.'../../portal/portal.php');
	}
}


