<?php

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( '../Statement.php' );
	$postInputs = new Statement( $_POST );
	if ( $postInputs->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../../portal/portal.php');
		return;
	}
	require_once( '../Token.php' );
	require_once( '../access/accessTokens.php' );

	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $postInputs->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'../../signup.php');
		return false;
	}

	require_once( '../access/accessDB.php' );
	$postInputs->sanitize();

	$loggedInUser = $_SESSION['loggedin_user_id'];

	require_once( '../Solution.php' );
	$solutionName = mysqli_real_escape_string( $conn, $postInputs->getValue( 'solution' ) );
	$solution = explode( '-', $solutionName );
	$delSolution = Solution::newFromId( $conn, $solution[1] );

	if ( $delSolution->isOwner( $loggedInUser ) ) {
		if ( $delSolution->deleteFromDb( $conn ) ) {
			header('Location: ' . '../../portal/solutions/mySolutionRequests.php');
			$_SESSION['message'] = "The solution request has been deleted successfully!";
			return;
		}
	}
		header('Location: ' . '../../portal/solutions/mySolutionRequests.php');
	$_SESSION['error'] = "We couldn't delete that course. Please contact one of the admins";

}