<?php
	session_start();
	if ( !$_SERVER['REQUEST_METHOD'] == 'GET' ) {
		header( 'Location: viewAllCourses.php');
		return false;
	}

	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	require_once('../../assets/php/Statement.php');

	$preparedPost = new Statement( $_GET );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../student/viewAllCourses.php');
		return;
	}

	if ( isset( $_SESSION['loggedin_user'] ) ) {
		$user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );
		$loggedInUser = $_SESSION['loggedin_user_id'];
	}

	require_once('../../assets/php/Course.php');
	require_once('../../assets/php/User.php');

	$preparedPost->sanitize();

	$courseName = $preparedPost->getValue( 'course' );
	$courseRaw = explode( '-', $courseName );
	$course = Course::newFromId( $conn, $courseRaw[1] );
	$mentorId =  $course->getValue( 'course_mentor' );
	$mentor = User::newFromUserId( $mentorId, $conn );
	$mentor->getExtra( $conn );
	$reviews = $course->getReviews( $conn );

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

	<link href="../../css/material/ripples.min.css" rel="stylesheet">

	<link href="../../css/material/flipper.css" rel="stylesheet">
	<link href="../../css/material/material-wfont.min.css" rel="stylesheet">

	<!--[endif]-->
</head>
<body >
<!-- Navigation
==========================================-->
<?php include 'navigationstudent.php' ?>

<div id="tf-portal" class="text-center">
	<div class="overlay">
		<div class="portal" >
			<?php
			if ( isset( $_SESSION['message'] ) ) {
				$message = $_SESSION['message'];
				echo "<p class='alert-success' style='text-align: center'> $message</p>";
				unset( $_SESSION['message'] );
			} else if ( isset ( $_SESSION['error'] ) ) {
				$errorMessage = $_SESSION['error'];
				echo "<p class='alert-warning' style='text-align: center'> $errorMessage </p>";
				unset( $_SESSION['error'] );
			}
			?>

			<div>
				<h2><?php $courseIdTag = 'course-' . $course->getCourseId();

					echo $course->getCourseName(). " <small>Active : <i class='fa fa-check' ></i>";
					if ( isset( $user ) ) {
						if ($course->isEnrolled($loggedInUser, $conn)) {
							echo " Enrolled : <span style='color: green; font-weight: bold'> Yes</span> </small>";
							echo '<small><span style="text-align: right; float: right;">
								 <form action="writeReview.php" method="post">
								<input type="hidden" name="CSRFToken" value="';
							echo $csrfToken->getCSRFToken();
							echo '"/>
							<button class="btn btn-info" type="submit" name="course-review"
							id="review"   value="';
							echo $courseIdTag;
							echo '"><i class="fa fa-pencil-square" > Review</i></button>
								</form>
							</span></small></h2>';


						} else if ($course->needsCheckout($loggedInUser, $conn)) {
							echo " Enrolled : <span style='color: red; font-weight: bold'> NEEDS CHECKOUT</span> </small>";
							echo '<small><span style="text-align: right; float: right;">
								<a href="../cart/viewCart.php"> <button type="button"  class="btn btn-danger" name="course" value="course-' . $row['course_id'] . '" > <i class="fa fa-star" style="color:gold" ></i> Checkout </button></a>
								</span></small></h2>';
						} else {
							echo " Enrolled : <span style='color: red; font-weight: bold'> No</span> </small>";
							echo '<small><span style="text-align: right; float: right;">
								<form action="../../assets/php/doEnrollCourse.php" method="post">
								<input type="hidden" name="CSRFToken" value="';
							echo $csrfToken->getCSRFToken();
							echo '"/>
								<button class="btn btn-success" type="submit" name="course" value="';
							echo $courseIdTag;
							echo '">Add <i class="fa fa-shopping-cart"></i></button>
								</form>
							</span></small></h2>';
						}
					} else {
						echo " Enrolled : <span style='color: red; font-weight: bold'> No</span> </small>";
						echo '<small><span style="text-align: right; float: right;">
								<form action="../../assets/php/doEnrollCourse.php" method="post">
								<input type="hidden" name="CSRFToken" value="';
						echo '"/>
								<button class="btn btn-success" type="submit" name="course" value="';
						echo $courseIdTag;
						echo '">Add <i class="fa fa-shopping-cart"></i></button>
								</form>
							</span></small></h2>';
					}

					?>

 				<hr>
			</div>

			<div class="row">
				<div class="col-md-8 well">
					<div class="panel panel-default panel-default">
					<div class="panel-heading" style="text-align: center">
						<div class="panel-title">
							<p style="font-size: large"><?php echo $course->getValue('course_bio') ?></p>
						</div>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
						   <tr>
							   <td>Language</td>
							   <td><?php echo $course->getValue('course_lang') ?></td>
						   </tr>
						<tr>
							<td>Difficulty</td>
							<td><?php echo $course->getValue('course_difficulty') ?></td>
						</tr>
						<tr>
							<td>Fee</td>
							<td><?php echo $course->getValue('course_fees') ?></td>

						</tr>
						<tr>
							<td>From</td>
							<td><?php echo $course->getValue('course_date_from') . ' : ' . $course->getValue('course_time_from'); ?></td>
						</tr>
							<tr>
								<td>To</td>
								<td><?php echo $course->getValue('course_date_to' ) . ' : ' . $course->getValue('course_time_to'); ?></td>
							</tr>
						</table>
						<div class="panel-footer panel-default">
							<h5>Reviews </h5>
							<hr>
							<?php
								if ( !empty( $reviews ) ) {
									foreach( $reviews as $review ) {
										$revuser = User::newFromUserId( $review['user_id'], $conn );
										echo 'Recommended :' . $review['recommend'] .
											'<span style="text-align:right; float : right;"> User: ' . $revuser->getValue('user_first_name')  .' ' . $revuser->getValue('user_last_name') . ' </span>';
										echo '<h5>Review : </h5>' . $review['general_review'];
										echo '<hr>';

									}
								} else {
									echo 'No reviews yet.';
								}
							?>
							</div>
						</div>
						</div>

				</div>
				<div class="col-md-3">

					<div class="panel panel-default panel-primary">
						<div class="panel-heading" style="text-align: center">
							<div class="panel-title">
								<h2>MENTOR</h2> <br>
								<i class="fa fa-user fa-4x"></i> <br>
								<?php echo $mentor->getValue('user_first_name') . ' ' . $mentor->getValue('user_last_name'); ?>

							</div>
						</div>
						<div class="panel-body">
							<table class="table table-bordered">
								<tr>
									<td><i class="fa fa-github"></i> Github</td>
									<td><?php echo $mentor->getValue( 'user_github'); ?></td>
								</tr>
								<tr>
									<td><i class="fa fa-linkedin"></i>  Linkedin</td>
									<td><?php echo $mentor->getValue( 'user_linkedin'); ?></td>
								</tr>
								<tr>
									<td><i class="fa fa-globe"></i>  Nationality</td>
									<td><?php echo $mentor->getValue( 'user_nation'); ?></td>
								</tr>
							</table>
						</div>
						<div class="panel-footer"><p style="color: black"><?php echo $mentor->getValue( 'user_about'); ?></p></div>

					</div>
				</div>

			</div>


		</div>
	</div>
</div>

<script src="../../js/material/ripples.min.js"></script>
<script src="../../js/material/material.min.js"></script>


<?php include '../../footer.html' ?>
</body>
</html>