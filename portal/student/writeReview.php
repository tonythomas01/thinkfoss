<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../../signup.php');
	}


	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		include_once('../../php/Statement.php');
		$preparedSatement = new Statement( $_POST );

		if ( $preparedSatement->checkIfEmptyPost()) {
			$_SESSION['error'] = "Please make sure you add in all required details";
			header('Location: ' . '../portal.php');
			return;
		}
		$preparedSatement->sanitize();

		require_once( '../../php/access/accessDB.php' );
		require_once( '../../php/Course.php' );
		require_once( "../../php/Token.php" );
		require_once( "../../php/access/accessTokens.php" );

		$csrfToken = new Token( $csrfSecret );
		if( ! $csrfToken->validateCSRFToken( $preparedSatement->getValue('CSRFToken') ) ) {
			$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
			header( 'Location: '.'viewEnrolledCourses.php');
			return false;
		}

		$courseRaw = mysqli_real_escape_string($conn, $_POST['course-review']);
		$courseName = explode('-', $courseRaw);
		$course = Course::newFromId( $conn, $courseName[1] );
		$courseId = $courseName[1];

		if ( !$courseId ) {
			header( 'Location: viewEnrolledCourses.php');
			return false;
		}

		require_once( '../../php/User.php' );
		$user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );

	} else {
		header( 'Location: viewEnrolledCourses.php');
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
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-66359518-1', 'auto');
		ga('send', 'pageview');

	</script>

    <!--[endif]-->
</head>
<body background="black">
<?php include 'navigationstudent.php' ?>
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
		                    <div class='input-group-addon' >Join ThinkFOSS? <i class='fa fa-star'></i></div>
		                    <select class="form-control" name="join_thinkfoss">
			                    <option>Yes</option>
			                    <option>No</option>
		                    </select>
	                    </div>
	                    <br><br>
	                    <input type="hidden" name="course_id" value="<?php echo $courseId ?>" />
	                    <?php
	                        require_once( "../../php/Token.php" );
	                        require_once( "../../php/access/accessTokens.php" );
	                        $csrfToken = new Token( $csrfSecret );
	                    ?>
	                    <script src='https://www.google.com/recaptcha/api.js'></script>
	                    <div class='input-group'>
		                    <div class="g-recaptcha"  data-sitekey="6LcuGAwTAAAAALbkjHwyE3Q9l8vtBDh-rD8P8_aS"></div>
	                    </div>
	                    <input type="hidden" name="CSRFToken" value='<?php echo $csrfToken->getCSRFToken(); ?>'/>

                        <button type='submit' class='btn btn-primary btn-lg'>Submit</button>
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
<?php include '../../footer.html' ?>
</body>
</html>