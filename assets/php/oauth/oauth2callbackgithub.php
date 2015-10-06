<?php
session_start();
require_once( '../access/githubOAUTH.php' );
$authorizeURL = 'https://github.com/login/oauth/authorize';
$tokenURL = 'https://github.com/login/oauth/access_token';
$apiURLBase = 'https://api.github.com/';

if ( get('action') == 'login' ) {
	// Generate a random hash and store in the session for security
	$_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
	unset($_SESSION['access_token']);
	$params = array(
		'client_id' => OAUTH2_CLIENT_ID,
		'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
		'scope' => 'user',
		'state' => $_SESSION['state']
	);
	// Redirect the user to Github's authorization page
	header('Location: ' . $authorizeURL . '?' . http_build_query($params) );
	die();
}

if( get('code') ) {
	if ( !get('state') || $_SESSION['state'] != get('state') ) {
		header('Location: ' . $_SERVER['PHP_SELF']);
		die();
	}
	// Exchange the auth code for a token
	$token = apiRequest( $tokenURL, array(
		'client_id' => OAUTH2_CLIENT_ID,
		'client_secret' => OAUTH2_CLIENT_SECRET,
		'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
		'state' => $_SESSION['state'],
		'code' => get('code')
	));
	$_SESSION['access_token'] = $token->access_token;

	header('Location: ' . $_SERVER['PHP_SELF']);
}

if( session('access_token') ) {
	require_once('../User.php');
	require_once('../access/accessDB.php');
	require_once('../access/accessTokens.php');

	$user = apiRequest( $apiURLBase . 'user' );

	if ( !$user->email ) {
		$_SESSION['error'] = "Error: Looks like you dont have a public email id. Please use other signup options";
		header( 'Location: '.'../../../signup.php');
		return false;
	}

	$oauthUser = User::newFromGithubAuth( $user );
	if ( $oauthUser->isExistingMember( $conn ) ) {
		$_SESSION['loggedin_user'] = $user->name;
		$_SESSION['loggedin_user_email'] = $oauthUser->getValue( 'user_email' );
		$_SESSION['loggedin_user_id'] = $oauthUser->getUserFreshId( $conn );
		header( 'Location: '.'../../../portal/portal.php');

	} else {
		//Add to authorization and user table
		$newPassword = bin2hex( openssl_random_pseudo_bytes(4) );
		$pass = substr( hash_hmac( 'sha512', $newPassword, $passwordSecret ), 0, 31 );
		if ( !$oauthUser->setPassword( $conn, $pass ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../../signup.php');
			return false;
		}

		if ( !$oauthUser->addToDatabase( $conn ) ) {
			$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
			header( 'Location: '.'../../../signup.php');
			return false;
		}
		require_once( '../access/mailgunAPIKeys.php' );
		require_once( '../vendor/mailgun-php/vendor/autoload.php' );

		$oauthUser->sendWelcomeEmail( $newPassword, $mailgunAPIKey, $mailgunDomain );

		$_SESSION['loggedin_user'] = $user->name;
		$_SESSION['loggedin_user_email'] = $oauthUser->getValue( 'user_email' );
		$_SESSION['loggedin_user_id'] = $oauthUser->getUserFreshId( $conn );
		header( 'Location: '.'../../../portal/portal.php');
	}

} else {
	$_SESSION['error'] = "Error: Unknown error occurred. Please contact one of the admins";
	header( 'Location: '.'../../../signup.php');
}

function apiRequest( $url, $post=FALSE, $headers=array() ) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	if($post)
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	$headers[] = 'Accept: application/json';
	$headers[] = 'User-Agent: ThinkFOSS Portal';
	if(session('access_token'))
		$headers[] = 'Authorization: Bearer ' . session('access_token');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	return json_decode($response);
}
function get( $key, $default=NULL ) {
	return array_key_exists( $key, $_GET ) ? $_GET[$key] : $default;
}
function session( $key, $default=NULL ) {
	return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}


