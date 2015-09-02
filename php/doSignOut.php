<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 26/8/15
 * Time: 10:55 PM
 */

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	print_r( $_POST );
	include "Statement.php";
	$postInput = new Statement( $_POST );
	if( $postInput->checkIfEmptyPost() ) {
		header('Location: ' . '../index.php');
		return;
	}
	require( "Token.php" );
	require( "access/accessTokens.php" );

	$csrfToken = new Token( $csrfSecret );
	$postInput->sanitize();

	if (!$csrfToken->validateCSRFToken($postInput->getValue('CSRFToken') ) ) {
		header('Location: ' . '../index.php');
		return false;
	} else {
		session_destroy();
		header('Location: ' . '../index.php');
	}
} else {
	header('Location: ' . '../index.php');
}