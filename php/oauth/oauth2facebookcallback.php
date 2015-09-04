<?php
require_once '../vendor/oauth2-facebook/vendor/autoload.php';
require_once( '../access/facebookOAUTH.php' );

session_start();

$provider = new League\OAuth2\Client\Provider\Facebook([
	'clientId'          => $clientId,
	'clientSecret'      => $clientSecret,
	'redirectUri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
	'graphApiVersion'   => 'v2.4',
]);


if (!isset($_GET['code'])) {
	$authUrl = $provider->getAuthorizationUrl([
		'scope' => ['email'],
	]);

	$_SESSION['oauth2state'] = $provider->getState();
	header('Location: ' . $authUrl );

	exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
	unset($_SESSION['oauth2state']);
	echo 'Invalid state.';
	exit;
}
// Try to get an access token (using the authorization code grant)
$token = $provider->getAccessToken('authorization_code', [
	'code' => $_GET['code']
]);

// Optional: Now you have a token you can look up a users profile data
try {
	// We got an access token, let's now get the user's details
	$user = $provider->getResourceOwner($token);

	require_once( '../User.php' );
	require_once('../access/accessDB.php');
	require_once('../access/accessTokens.php');

	$oauthUser = User::newFromFacebookOAuth( $user->toArray() );

	if ( $oauthUser->isExistingMember( $conn ) ) {
		$_SESSION['loggedin_user'] = $oauthUser->getValue('user_first_name') . ' ' . $oauthUser->getValue( 'user_last_name');
		$_SESSION['loggedin_user_email'] = $oauthUser->getValue( 'user_email' );
		$_SESSION['loggedin_user_id'] = $oauthUser->getUserFreshId( $conn );
		header( 'Location: '.'../../portal/portal.php');

	} else {
		//Add to authorization and user table
		$newPassword = bin2hex( openssl_random_pseudo_bytes(4) );
		$pass = substr( hash_hmac( 'sha512', $newPassword, $passwordSecret ), 0, 31 );
		if ( !$oauthUser->setPassword( $conn, $pass ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../signup.php');
			return false;
		}

		if ( !$oauthUser->addToDatabase( $conn ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../signup.php');
			return false;
		}

		require_once( '../access/mailgunAPIKeys.php' );
		require_once( '../vendor/mailgun-php/vendor/autoload.php' );

		$oauthUser->sendWelcomeEmail( $newPassword, $mailgunAPIKey, $mailgunDomain );
		$_SESSION['loggedin_user'] = $oauthUser->getValue('user_first_name') . ' ' . $oauthUser->getValue( 'user_last_name');
		$_SESSION['loggedin_user_email'] = $oauthUser->getValue( 'user_email' );
		$_SESSION['loggedin_user_id'] = $oauthUser->getUserFreshId( $conn );
		header( 'Location: '.'../../portal/portal.php');
	}

} catch (Exception $e) {
	$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
	header( 'Location: '.'../../signup.php');
}