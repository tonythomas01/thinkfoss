<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../../signup.php');
	}

	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	$user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );
	require_once('../../assets/php/access/accessTokens.php');
	require_once('../../assets/php/Token.php');
	$csrfToken = new Token( $csrfSecret );
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
	<script>
		$(function() {
			$( "#solution_deadline_estimated" ).datepicker();

		});
	</script>

	<link rel="stylesheet" href="../../css/jquery-ui.css">
	<script src="../../js/jquery-ui.js"></script>


</head>
<body>
<?php include 'navigationSolutions.php' ?>

<div id="tf-portal">
    <div class="overlay">
            <div class="container" style="padding-top: 7%; text-align: left; padding-bottom: 5%">
            <div class="row">

            <div class='col-md-8'>
                <form class='form-inline' action='../../assets/php/actions/doCreateSolution.php' method='post'>
                    <div class='form-group well'>

                        <label class='sr-only' for='course_name'>I want</label>
                        <div class='input-group' >
                            <div class='input-group-addon'> I want</div>
                            <input required  type='text' size='100%' class='form-control' id='solution_name' name='solution_name' placeholder=' Give a name for your solution'>
                        </div>
                        <h3 style="color: black">Platform</h3>

                        <div class='input-group'>
                            <div class='input-group-addon' ><i class='fa fa-bomb'></i></div>
                            <select class="form-control" name="solution_platform">
                                <option>Web</option>
                                <option>Mobile</option>
                                <option>Web + Mobile</option>
                            </select>
                        </div>
                        <label class='sr-only' for='solution_framework'>Backend</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class="fa fa-language">*</i> </div>
	                        <select class="form-control" name="solution_framework" placeholder='Framework'>
		                        <option>PHP</option>
		                        <option>Python-Django</option>
		                        <option>Android</option>
		                        <option>Node-JS</option>
		                        <option>Static-Page</option>
		                        <option selected>Other</option>
	                        </select>
                        </div>
                        <label class='sr-only' for='solution_date_to'>Solution Contact</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class="fa fa-phone"></i> </div>
                            <input required type='text' class='form-control' id='solution_contact' name='solution_contact' placeholder='Contact Number'>
                        </div>
                        <h3 style="color: black">Delivery</h3>

                        <label class='sr-only' for='solution_deadline_estimated'>Estimated Delivery</label>
                        <div class='input-group'>
                            <div class='input-group-addon'>Deadline </div>
                            <input required type='text' class='form-control' id='solution_deadline_estimated' name='solution_deadline_estimated' placeholder='Deadline Date'>
                        </div>

                        <label class='sr-only' for='solution_amount'>Amount</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-rupee'></i> </div>
                            <input required type='number' class='form-control' id='solution_amount'  name='solution_amount' placeholder='Expected budget'>
                        </div>
                        <h3 style="color: black">Description</h3>

                        <label class='sr-only' for='solution_bio'> Short Bio</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-book'></i></div>
                            <textarea required rows='4' cols='100' class='form-control' id='solution_bio'  name='solution_bio' placeholder='Short description on your need.'></textarea>
                        </div>
                        <br><br>

                        <script src='https://www.google.com/recaptcha/api.js'></script>
                        <div class='input-group'>
                            <div class="g-recaptcha"  data-sitekey="6LcuGAwTAAAAALbkjHwyE3Q9l8vtBDh-rD8P8_aS"></div>
                        </div>
                        <input type='hidden' name='CSRFToken' value='<?php echo $csrfToken->getCSRFToken(); ?>'/>
                        <button type='submit' class='btn tf-btn-grey  btn-lg'>Create <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </form>


            </div>

            <div class='col-md-4'>
                <h1 class="section-title"> Add a solution</h1>
                <p class='intro'> Great! Add in the details of your new solution, and we will contact you in the latest with a quote. If
                    some fields looks greek to you, just leave it and submit<br><br>
                <h2>Notes</h2>
                <ul class='mentor-list'>
                    <li>
                        <span class='fa fa-check'></span>
                        <strong>* Framework Specifications : </strong> Eg: PHP, NodeJS, Python, Django, Android etc
                    </li>
                    <li>
                        <span class='fa fa-check'></span>
                        <strong>Wait for confirmation email</strong>
                    </li>
                    <li>
                        <span class='fa fa-phone'></span>
                        <strong>Stuck ? Contact one of us</strong>
                    </li>

                </ul><br>
            </div>


            </div>


        </div>
        </div>

            </div>
<?php include '../../footer.html' ?>
</body>
</html>