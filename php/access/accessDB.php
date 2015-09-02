<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 25/8/15
 * Time: 3:54 PM
 */

$servername = "localhost";
$username = "root";
$password = "toor";
$dbname = "thinkfoss";

$conn = new mysqli( $servername, $username, $password );

if ( $conn->connect_error ) {
	$_SESSION['error'] = "Sorry. We had an error processing your request. Please contact one of the admins";
	header('Location: ' . '../../portal/cart/viewCart.php');
}

if ( !$conn->select_db($dbname) ) {
	$_SESSION['error'] = "Sorry. We had an error processing your request. Please contact one of the admins";
	header('Location: ' . '../../portal/cart/viewCart.php');
}