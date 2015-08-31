<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../../signup.php');
	}


	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		if ( checkIfEmptyPost( $_POST ) ) {
			$_SESSION['error'] = "Please make sure you add in all required details";
			header('Location: ' . '../portal.php');
			return;
		}
		include_once("../../php/connectToDb.php");
		$conn = new mysqli($servername, $username, $password);

		if ($conn->connect_error) {
			die("Connection failed");
		}

		if (!$conn->select_db($dbname)) {
			die("Database selection error");
		}
		include '../../php/Course.php';
		$courseRaw = mysqli_real_escape_string($conn, $_POST['course-review']);
		$courseName = explode('-', $courseRaw);
		$course = Course::newFromId( $conn, $courseName[1] );
		$courseId = $courseName[1];

		if ( !$courseId ) {
			header( 'Location: viewEnrolledCourses.php');
		}
	}

        function checkIfEmptyPost( $input ) {
                foreach( $input as $key => $value ) {
	                if ( $value === '' ) {
		                return true;
	                }
                }
                return false;
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
<body background="black">
<?php include 'navigationstudent.html' ?>

<div id="tf-portal" class="text-center">
    <div class="overlay">
        <div class="portal">

            <div class='col-xs-6'>
                <br>
                <form class='form-inline' action='../../php/doProcessReview.php' method='post'>
                    <div class='form-group well'>
	                    <div class='input-group'>
		                    <div class='input-group-addon' >Mentor <i class='fa fa-star'></i></div>
		                    <select class="form-control" name="mentor_score">
			                    <option>1</option>
			                    <option>2</option>
			                    <option>3</option>
			                    <option>4</option>
			                    <option>5</option>
		                    </select>
	                    </div>
	                    <div class='input-group'>
		                    <div class='input-group-addon' >Portal <i class='fa fa-star'></i></div>
		                    <select class="form-control" name="portal_score">
			                    <option>1</option>
			                    <option>2</option>
			                    <option>3</option>
			                    <option>4</option>
			                    <option>5</option>
		                    </select>
	                    </div>
	                    <div class='input-group'>
		                    <div class='input-group-addon' >Payment <i class='fa fa-star'></i></div>
		                    <select class="form-control" name="payment_score">
			                    <option>1</option>
			                    <option>2</option>
			                    <option>3</option>
			                    <option>4</option>
			                    <option>5</option>
		                    </select>
	                    </div>

	                    <br><br>
                        <label class='sr-only' for='course_bio'>Review</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-book'></i></div>
                            <textarea required rows='4' cols='100' class='form-control' id='general_review'  name='general_review' placeholder='General feedback about the course and mentor'></textarea>
                        </div>

                        <br><br>
	                    <div class='input-group'>
		                    <div class='input-group-addon'><i class='fa fa-book'></i></div>
		                    <textarea required rows='4' cols='100' class='form-control' id='improve_review'  name='improve_review' placeholder='How can we improve it ?'></textarea>
	                    </div>

	                    <br><br>
	                    <div class='input-group'>
		                    <div class='input-group-addon' >Recommendable  <i class='fa fa-star'></i></div>
		                    <select class="form-control" name="recommend">
			                    <option>Yes</option>
			                    <option>No</option>
		                    </select>
	                    </div>

	                    <div class='input-group'>
		                    <div class='input-group-addon' >I want to Join ThinkFOSS  <i class='fa fa-star'></i></div>
		                    <select class="form-control" name="join_thinkfoss">
			                    <option>Yes</option>
			                    <option>No</option>
		                    </select>
	                    </div>
	                    <br><br>
	                    <input type="hidden" name="course_id" value="<?php echo $courseId ?>" />

                        <button type='submit' class='btn btn-primary'>Submit</button>
                    </div>
                </form>

            </div>

            <div class='col-xs-6'>
                <h1 class="section-title"> Write a review</h1>
                <p class='intro'> Wow ! Your reviews make sure that we maintain the quality of ThinkFOSS. Please be honest, and avoid vandalism <br><br>
	            <div class='input-group'>
		            <div class='input-group-addon'>Course reviewed</div>
		            <input required  type='text' size='100%' class='form-control' disabled id='reviewed_course' name='reviewed_course' value="<?php echo $course->getCourseName(); ?>">
                         </div>


                </div>

            </div>

        </div>
</div>
<?php include '../footer.html' ?>
</body>
</html>