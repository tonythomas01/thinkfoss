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
require_once( '../../php/Token.php' );
require_once( '../../php/access/accessTokens.php' );
require_once( '../../php/Course.php' );
?>
<!-- Navigation
==========================================-->
<?php include 'navigationmentor.php' ?>

<div id="tf-portal" class="text-center">
        <div class="overlay" >
                <div class="portal">
                        <?php

                        if ( isset( $_SESSION['message'] ) ) {
                                $message = $_SESSION['message'];
                                echo "<p class='alert-success' style='text-align: center'> $message</p>";
                                unset( $_SESSION['message'] );
                        }
                        if ( isset( $_SESSION['error'] ) ) {
                                $errorMessage = $_SESSION['error'];
                                echo "<p class='alert-warning'> $errorMessage </p>";
                                unset( $_SESSION['error'] );
                        }

                        ?>

                        <div>
                                <h2 class="section-title"> My Courses</h2>
                        </div>
                        <br>
                        <div class="row" >
                                <?php
                                $loggedInUser = $_SESSION['loggedin_user_id'];

                                $sqlSelect = "SELECT `course_id`, `course_name`, `course_bio`, `course_lang`, `course_difficulty`, `course_date_from`,
		`course_time_from`, `course_date_to`, `course_time_to`, `course_fees` FROM `course_details` WHERE `course_id` IN
		( SELECT `course_id` FROM `course_mentor_map` WHERE `mentor_id` = '$loggedInUser' );";
                                $result = $conn->query( $sqlSelect );
                                if( $result->num_rows > 0 ) {
                                        while( $row = $result->fetch_assoc() ) {

                                                $courseId = $row['course_id'];

                                                $course = Course::newFromId( $conn, $courseId );

                                                $csrfToken = new Token( $courseId . $csrfSecret );
	                                        $csrftoken = $csrfToken->getCSRFToken();
                                                echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail" style="height: 280px">
                                <span style="text-aligin: right; float: right; color: black;">STATUS : ';
                                                if ( $course->isCourseApproved( $conn ) ) {
                                                        echo '<span style="color:green"><strong>Approved</strong></span>';
                                                } else {
                                                        echo '<span style="color:red">Pending</span>';
                                                }
                                                echo '</span>
                                   <div class="caption">
                                           <div class="panel panel-default">
                                                   <div class="panel-body" style="height: 160px">
                                                   <h1>' . $row['course_name'] . '</h1>
                                                   </div>
                                           <div class="panel-footer">

                                           <p><strong>Rate </strong>: '.  $row['course_fees'] . '
                                                <span style ="float: right"><span class="label label-primary" data-toggle="modal" onClick="getId( this.id )"  id="'; echo base64_encode( $course->getCourseId() ) . '_' . $csrftoken; echo '" data-target="#myModal" >Students enrolled : ' . $course->getNumberofStudentsEnrolled( $conn ) .'</span></button>
                                                </span></p>
                                                <p><strong>Language</strong>: '.  substr( $row['course_lang'], 0, 10 ) . '  <span style ="float: right"><strong>Difficulty</strong> : '.  $row['course_difficulty'] .'</span></p>
                                                ';

                                        $csrfTokenForEdits = new Token( $csrfSecret );
                                        echo '
                                        <form action="editMyCourse.php" method="post">
                                                    <input type="hidden" name="CSRFToken" value="'; echo $csrfTokenForEdits->getCSRFToken(); echo '"/>
                                                    <button style="position: absolute; left:20px; bottom:15px; padding: 10px" type="submit" class="btn btn-success" name="course"  value="course-' . $row['course_id'] . '" ><i class = "fa fa-pencil"></i></button>
                                        </form>
		                        <form action="../../php/doDeleteCourse.php" method="post">
		                                <input type="hidden" name="CSRFToken" value="';echo $csrfTokenForEdits->getCSRFToken(); echo '"/>
		                                <button type="submit" style="position: absolute; right:20px; bottom: 15px; padding: 10px" class="btn btn-danger" name="course" value="course-'.$row['course_id'].'" ><i class="fa fa-trash"></i></button>
                                        </form>

                                </div>
                            </div>
                             </div>
                             </div>
                             </div>

		        ';
                                        }
                                } else {
                                        echo '<p class="alert-warning">Looks like you have not added anything here yet. Please add in courses.</p>';

                                }

                                ?>

                        </div>
                </div>
        </div>
	<script>
		function getId( id ) {
			$( '.modal-body' ).load( "viewCourseMentees.php", {
				"courseid_token": id
			});
		}
	</script>

	<!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h2 class="modal-title" id="myModalLabel" style="color: black">Enrolled Users</h2>

                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                        </div>
                </div>
        </div>


        <?php include '../../footer.html' ?>
</body>
</html>