<?php include('Crypto.php')?>
<?php
	session_start();

	error_reporting(0);
	require_once( '../../access/ccavenueKeys.php');

	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt( $encResponse,$working_key );		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);

	$order_id = 0;

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if( $i == 0 ) {
			$order_id = $information[1];
		}
		if($i==3)	$order_status=$information[1];
	}

	if($order_status==="Success")
	{
		require_once( '../../Order.php' );
		require_once( '../../Course.php' );
		require_once( '../../access/accessDB.php' );
		require_once( '../../access/mailgunAPIKeys.php' );

		$order = Order::newOrderFromId( $conn, $order_id );
		$order->checkoutOrder( $conn );

		$courseId = $order->getValue( 'courseId' );
		$course = Course::newFromId( $conn, $courseId );

		$course->notifyMentor( $conn, $mailgunAPIKey, $mailgunDomain);

		$_SESSION['success'] = "Congrats, that transaction:  $order_id was a success.";
		header('Location: ' . '../../../portal/student/viewEnrolledCourses.php');

	}
	else if($order_status==="Aborted")
	{
		$_SESSION['error'] = "Couldn't checkout that course: $order_id. Please try again";
		header('Location: ' . '../../../portal/cart/viewCart.php');
	
	}
	else if($order_status==="Failure")
	{
		$_SESSION['error'] = "Couldn't checkout that course: $order_id. Please try again";
		header('Location: ' . '../../../portal/cart/viewCart.php');
	}
	else
	{
		$_SESSION['error'] = "Security error detected. Please contact one of the admins";
		header('Location: ' . '../../../portal/cart/viewCart.php');
	
	}
?>
