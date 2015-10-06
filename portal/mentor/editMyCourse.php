<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../../signup.php');
	}

	if ( !$_SERVER['REQUEST_METHOD'] == 'POST' ) {
		header( 'Location: viewMyCourses.php');
		return false;
	}

	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	$loggedInUser = $_SESSION['loggedin_user_id'];


	require_once('../../assets/php/Statement.php');
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . 'viewMyCourses.php');
		return;
	}
	require_once('../../assets/php/Token.php');
	require_once('../../assets/php/access/accessTokens.php');
	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $preparedPost->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'viewMyCourses.php');
		return false;
	}


	require_once('../../assets/php/Course.php');
	require_once('../../assets/php/User.php');
	$preparedPost->sanitize();

	$courseName = mysqli_real_escape_string( $conn, $preparedPost->getValue( 'course' ) );
	$courseRaw = explode( '-', $courseName );
	$course = Course::newFromId( $conn, $courseRaw[1] );
	$mentorId =  $course->getValue( 'course_mentor' );

	$mentor = User::newFromUserId( $mentorId, $conn );

	if ( $mentorId !== $loggedInUser ) {
		$_SESSION['error'] = "You are not supposed to edit in that page";
		header('Location: ' . 'viewMyCourses.php');
		return;
	}

	$user = User::newFromUserId( $loggedInUser, $conn );

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
<?php include 'navigationmentor.php' ?>


<div id="tf-portal" class="text-center">
	<div class="overlay">
		<div class="portal" >
			<?php
			if ( $_SESSION['message'] ) {
				$message = $_SESSION['message'];
				echo "<p class='alert-success' style='text-align: center'> $message</p>";
				unset( $_SESSION['message'] );
			} else if ( $_SESSION['error'] ) {
				$errorMessage = $_SESSION['error'];
				echo "<p class='alert-warning' style='text-align: center'> $errorMessage </p>";
				unset( $_SESSION['error'] );
			}
			?>

			<div>
				<h2><?php $courseIdTag = 'course-' . $course->getCourseId();

					echo $course->getCourseName(). " <small>Active : <i class='fa fa-check' ></i>";
					?>

 				<hr>
			</div>

			<div class="row">
				<div class="col-md-6">
					<form class='form-inline' action='../../assets/php/doUpdateCourse.php' method='post'>
						<div class='form-group well'>
							<label class='sr-only' for='course_name'>Course Name</label>
							<div class='input-group' >
								<div class='input-group-addon'>Course Name</div>
								<input required  type='text' size='70%' class='form-control'
								       id='course_name' name='course_name' placeholder='Give a stylish name for your course'
									value ="<?php echo $course->getValue('course_name'); ?>">
							</div>
							<br><br>

							<label class='sr-only' for='course_bio'>Short Bio</label>
							<div class='input-group'>
								<div class='input-group-addon'><i class='fa fa-book'></i></div>
								<textarea required rows='4' cols='82' class='form-control' id='course_bio'  name='course_bio' placeholder='Short description on the course.'> <?php echo $course->getValue('course_bio'); ?></textarea>
							</div>

							<br><br>
							<label class='sr-only' for='course_lang'>Language</label>
							<div class='input-group'>
								<div class='input-group-addon'><i class="fa fa-language"></i> </div>
								<input required type='text' class='form-control' id='course_lang' name='course_lang' placeholder='Language Preferred' value="<?php echo $course->getValue('course_lang'); ?>">
							</div>

							<div class='input-group'>
								<?php $cours_difficulty = $course->getValue('course_difficulty'); ?>
								<div class='input-group-addon' ><i class='fa fa-bomb'></i></div>
								<select class="form-control" name="course_difficulty">
									<option <?php if ( $cours_difficulty == 'Beginner' ) { echo 'selected'; } ?> >Beginner</option>
									<option <?php if ( $cours_difficulty == 'Intermediate' ) { echo 'selected'; }?> >Intermediate</option>
									<option <?php if ( $cours_difficulty == 'Advanced' ) { echo 'selected'; } ?> >Advanced</option>
								</select>
							</div>
							<br><br>

							<label class='sr-only' for='course_date_to'>Date from</label>
							<div class='input-group'>
								<div class='input-group-addon'><strong>From</strong></div>
								<input required type='date' class='form-control' id='course_date_from' name='course_date_from' placeholder='Available Date' value="<?php echo $course->getValue('course_date_from'); ?>">
							</div>
							<label class='sr-only' for='course_date_to'>Time from</label>
							<div class='input-group'>
								<div class='input-group-addon'><i class='fa fa-clock-o'></i></div>
								<input required type='time' class='form-control' id='course_time_from' name='course_time_from' placeholder='Available Time' value="<?php echo $course->getValue('course_time_from'); ?>">
							</>
							</div>

							<br><br>

							<label class='sr-only' for='course_date_to'>Date To</label>
							<div class='input-group'>
								<div class='input-group-addon'><strong>To &nbsp; &nbsp;&nbsp;</strong></div>
								<input required type='date' class='form-control' id='course_date_to' name='course_date_to' placeholder='Available Date' value="<?php echo $course->getValue('course_date_to'); ?>">
							</>
							</div>
							<label class='sr-only' for='course_time_to'>Time to</label>
							<div class='input-group'>
								<div class='input-group-addon'><i class='fa fa-clock-o'></i></div>
								<input required type='time'  class='form-control' id='course_time_to' name='course_time_to' placeholder='Available Time' value="<?php echo $course->getValue('course_time_to'); ?>">
							</>
							</div> <br><br>
							<label class='sr-only' for='course_amount'>Amount</label>
							<div class='input-group'>
								<div class='input-group-addon'><i class='fa fa-rupee'></i> </div>
								<input required type='number' class='form-control' id='course_amount'  name='course_amount' placeholder='Charge' value="<?php echo $course->getValue('course_fees'); ?>">
							</>
							</div>
							<br><br>
							<script src='https://www.google.com/recaptcha/api.js'></script>
							<div class='input-group'>
								<div class="g-recaptcha"  data-sitekey="6LcuGAwTAAAAALbkjHwyE3Q9l8vtBDh-rD8P8_aS"></div>
							</div> <br><br>
							<input type='hidden' name='CSRFToken' value='<?php echo $csrfToken->getCSRFToken(); ?>'/>
							<input type='hidden' name='course_id' value='<?php echo base64_encode( $course->getValue('course_id' ) )?>'/>
							<button type='submit' class='btn btn-primary  btn-lg'>Update</button>
						</div>
					</form>

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