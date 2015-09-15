<?php include('Crypto.php')?>
<?php
	session_start();

	error_reporting(0);
	require_once( '../../access/ccavenueKeys.php');
	
	$workingKey= $working_key;		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

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
		$_SESSION['success'] = "Congrats, that transaction:  $order_id was a success.";
		header('Location: ' . '../../../portal/cart/viewCart.php');

	}
	else if($order_status==="Aborted")
	{
		$_SESSION['error'] = "Couldn't checkout that course. Please try again";
		header('Location: ' . '../../../portal/cart/viewCart.php');
	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";
?>
