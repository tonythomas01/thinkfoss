<?php
session_start();
if ( !isset( $_SESSION['loggedin_user'] ) ) {
	header( 'Location: ../../signup.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ThinkFOSS - code | train | grow</title>
	<meta name="msvalidate.01" content="AACA4869B9C746F7F151D39BF5D19CB2" />
	<meta name="description" content=" ThinkFOSS aims at providing Open Source training and solutions to Individuals, Schools, Universities and Industries in need. ThinkFOSS is a collection of Open Source enthusiasts and entrepreneurs who are ready to spend their time spreading FOSS technologies">
	<meta name="keywords" content="thinkfoss, fossatamrita, training, open source, open source solutions">
	<meta name="author" content="thinkfoss.com">

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="../../img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../../img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../../img/apple-touch-icon-114x114.png">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css"  href="../../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../fonts/font-awesome/css/font-awesome.css">


	<!-- Stylesheet
	================================================== -->
	<link rel="stylesheet" type="text/css"  href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../css/responsive.css">

	<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>

	<script type="text/javascript" src="../../js/modernizr.custom.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<!-- Latest compiled and minified CSS -->


	<!-- jQuery library -->
	<script src="../../js/jquery.1.11.1.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="../../js/bootstrap.min.js"></script>

	<!--[endif]-->
</head>
<body>

<?php
	require_once( '../../php/access/accessDB.php' );
	require_once( '../../php/User.php');
	$user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );
	include( '../../php/Token.php' );
	include( '../../php/access/accessTokens.php' );

        if ( !$user->checkIfPrivelaged( $conn ) ) {
	        header( 'Location: ../../portal/portal.php');
        }

?>
<!-- Navigation
==========================================-->
<?php include 'navigationadmin.php' ?>

<div id="tf-portal" class="text-center">
	<div class="overlay" >
		<div class="portal">
			<?php

			if ( $_SESSION['message'] ) {
				$message = $_SESSION['message'];
				echo "<p class='alert-success' style='text-align: center'> $message</p>";
				unset( $_SESSION['message'] );
			} else if ( $_SESSION['error'] ) {
				$errorMessage = $_SESSION['error'];
				echo "<p class='alert-warning'> $errorMessage </p>";
				unset( $_SESSION['error'] );
			}

			?>

			<div>
				<h2 class="section-title">Course Administration</h2>
			</div>
			<br>
			<form action="../../php/doAdminControl.php" method="post">
			<table class="table table-hover table-bordered well" style="color:black">
				<thead>
				<th>Course Name</th>
				<th>Description</th>
				<th>Language</th>
				<th>Difficulty</th>
				<th>From Date</th>
				<th>From Time</th>
				<th>To Date</th>
				<th>To Time</th>
				<th>Fees</th>
				<th>Approve</th>
				</thead>
				<tbody>


				<?php
				$loggedInUser = $_SESSION['loggedin_user_id'];

				$sqlSelect = "SELECT `course_id`, `course_name`, `course_bio`, `course_lang`, `course_difficulty`, `course_date_from`,
		`course_time_from`, `course_date_to`, `course_time_to`, `course_fees`, `course_approved` FROM `course_details` WHERE `course_approved` = 0; ";
				$result = $conn->query( $sqlSelect );
				if( $result->num_rows > 0 ) {
					while( $row = $result->fetch_assoc() ) {
						$csrfToken = new Token( $csrfSecret );
						echo '<tr> <td>'. $row['course_name']. '</td>
		        <td> '. $row['course_bio']. '</td>
		        <td> '. $row['course_lang']. '</td>
		        <td> '. $row['course_difficulty']. '</td>
		        <td> '. $row['course_date_from']. '</td>
		        <td> '. $row['course_time_from']. '</td>
		        <td> '. $row['course_date_to']. '</td>
		        <td> '. $row['course_time_to']. '</td>
		        <td> '. $row['course_fees']. '</td>
		        <td> <input type="radio" name="course-future[]" value="course-approve-'.$row['course_id'].'" /> Yes
		        <input type="radio" name="course-future[]" value="course-remove-'.$row['course_id'].'" />No</td>
		        ';
					}
				}

				?>
				</tbody>
			</table>
			<input type="hidden" name="CSRFToken" value='<?php echo $csrfToken->getCSRFToken(); ?>'/>
			<button type="submit" class="btn btn-success"  > <i class="fa fa-check"></i> OK </button>

			</form>

		</div>
	</div>
</div>
<?php include '../../footer.html' ?>
</body>
</html>