<?php
	session_start();
	if (!isset($_SESSION['loggedin_user'])) {
		header('Location: ../../signup.php');
	}
	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	$user = User::newFromUserId($_SESSION['loggedin_user_id'], $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<!--[if IE]>
	<meta http-equiv="x-ua-compatible" content="IE=9"/><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ThinkFOSS - code | train | grow</title>
	<meta name="msvalidate.01" content="AACA4869B9C746F7F151D39BF5D19CB2"/>
	<meta name="description"
	      content=" ThinkFOSS aims at providing Open Source training and solutions to Individuals, Schools, Universities and Industries in need. ThinkFOSS is a collection of Open Source enthusiasts and entrepreneurs who are ready to spend their time spreading FOSS technologies">
	<meta name="keywords" content="thinkfoss, fossatamrita, training, open source, open source solutions">
	<meta name="author" content="thinkfoss.com">

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="../../img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../../img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../../img/apple-touch-icon-114x114.png">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../fonts/font-awesome/css/font-awesome.css">


	<!-- Stylesheet
	================================================== -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
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


	<!--[endif]-->
</head>
<body style="background-color: #f5f5f5">
<?php
	include 'navigationstudent.php'
?>

<div class="tf-portal" class="text-center">
	<div class="overlay">
		<div class="portal">
			<?php
			if ( isset( $_SESSION['message'] ) ) {
				$message = $_SESSION['message'];
				echo "<p class='alert-success' style='text-align: center'> $message</p>";
				unset($_SESSION['message']);
			} else if ( isset( $_SESSION['error'] ) ) {
				$errorMessage = $_SESSION['error'];
				echo "<p class='alert-warning' style='text-align: center'> $errorMessage </p>";
				unset($_SESSION['error']);
			}
			?>

			<div style="padding-bottom: 10px; text-align: center">
				<h2 class="section-title"> Available Courses</h2>
			</div>
			<br>

			<div class="row" >

				<?php
				require_once('../../assets/php/Token.php');
				require_once('../../assets/php/access/accessTokens.php');
				$loggedInUser = $_SESSION['loggedin_user_id'];

				$sqlSelect = "SELECT course_details.`course_id`, course_details.`course_name`,
		          course_details.`course_difficulty`, course_details.`course_fees`,
		          course_details.`course_approved`, user_details.`user_first_name`,
		          user_details.`user_last_name` FROM `course_details`
		          INNER JOIN `course_mentor_map` ON course_details.course_id = course_mentor_map.course_id
		          INNER JOIN `user_details` ON course_mentor_map.mentor_id = user_details.user_id AND course_details.course_approved = 1";

				$result = $conn->query($sqlSelect);

				include '../../assets/php/Course.php';

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$csrfToken = new Token($csrfSecret);
					$course = Course::newFromId($conn, $row['course_id']);
					$courseName = $course->getCourseName();
					$courseId = $course->getCourseId();
					echo "
        				<a href='course.php?name=$courseName&course=course-$courseId'>";
        				echo '
        				<div class="col-md-3">
                				<div class="thumbnail" style="height: 270px">
                                                        <div class="caption">
                                                        <div class="panel panel-default" style="background-color: transparent">
						 	 <div class="panel-body" style="height: 150px;">
				                                        <h3 style="line-height: 40px; text-align: center">'; echo strlen( $courseName ) > 60 ? substr( $courseName, 0, 60 ) . '..'  : $courseName; echo '</h3> </div>
								';
					if ( $course->isEnrolled( $loggedInUser, $conn ) ) {
						echo '<div class="panel-footer" style="height: 90px; background-color: #fcac45">';
					} else {
						echo '<div class="panel-footer" style="height: 90px;">';
					} echo '


			                                                <table class="table" id="course-listing-table" >
			                                                <col width="20px">
			                                                <tbody>
											<tr>
			                                                		<td>
			                                                		<i class="fa fa-group"></i>
											</td>
											<td>
											'. $row['user_first_name']. ' '  . $row['user_last_name'];
											if ( $course->isEnrolled( $loggedInUser, $conn ) ) {
												echo '<span class="label label-success" style="float:right; font-size:13px"><i class="fa fa-check"></i> Enrolled</span>';
											} else {
												echo '<span class="label label-primary" style="float:right; font-size:13px"><i class="fa fa-plus"></i>  Buy </span>';
											} echo '
											</td>
											</tr>
											<tr>
												<td> <i class="fa fa-rupee"> </td>
												<td> '.  $row['course_fees'] .'
												<i class=" fa fa-user" style="float: right;"> '; echo $course->getNumberofStudentsEnrolled( $conn ); echo '</i>
												</td>

											</tr>

									</tbody>

									</table>

				                                        <figcaption class="mask" style="text-align:center;">
				                                        <form action="course.php" method="get">
										<input type="hidden" name="name" value="'; echo $course->getCourseName(); echo '"/>
										<button class="btn tf-btn-grey btn-lg"  name="course" value="course-' . $row['course_id'] . '"  style="opacity: 0.7" href="#">
  										<i class="fa fa-search-plus fa-2x pull-left"></i>More</button>
				                                        </form>
				                                        </figcaption>

							</div>

							</div>
                                                        </div>


                       					</div>


                                        </div>
                                        </a>

	                        ';
				}
			}else {
				echo "<p>No courses available. Sorry </p>";
			}
				?>
			</div>
		</div>
		</div>

		<script src="../../js/material/ripples.min.js"></script>
		<script src="../../js/material/material.min.js"></script>

		<?php include '../../footer.html' ?>
</body>
</html>