<?php
session_start();
if( isset( $_SESSION['loggedin_user'] ) ) {
	header( 'Location: portal/portal.php');
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
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

	<!-- Slider
	================================================== -->
	<link href="css/owl.carousel.css" rel="stylesheet" media="screen">
	<link href="css/owl.theme.css" rel="stylesheet" media="screen">

	<!-- Stylesheet
	================================================== -->
	<link rel="stylesheet" type="text/css"  href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link href="css/material/material-wfont.min.css" rel="stylesheet">

	<script type="text/javascript" src="js/modernizr.custom.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


	<script type="text/javascript" src="js/jquery.1.11.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();
		});

	</script>

</head>
<body>
<!-- Navigation
==========================================-->
<nav id="tf-menu" class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><i class="fa fa-home"></i> Think<span class="color">FOSS</span></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="index.php#tf-home" class="page-scroll">Home</a></li>
				<li><a href="index.php#tf-about" class="page-scroll">About</a></li>
				<li><a href="index.php#tf-team" class="page-scroll">Team</a></li>
				<li><a href="index.php#tf-services" class="page-scroll">Services</a></li>
				<li><a href="index.php#tf-contact" class="page-scroll">Contact</a></li>
				<li>
					<?php
					require_once('assets/php/Token.php');
					require_once('assets/php/access/accessTokens.php');

					if ( isset( $_SESSION['loggedin_user'] ) ) {
						$loggedinUser = $_SESSION['loggedin_user'];
						$csrfToken = new Token( $csrfSecret );
						echo "<li> <a>Hi <span style='color: red; font-weight: bold'>$loggedinUser</span></a></li>
                            <li>
                                <form class='form-inline' action = 'assets/php/doSignOut.php' method = 'post' >
                                <div class='form-group'>
                                    <input type='hidden' name='CSRFToken' value='"; echo $csrfToken->getCSRFToken(); echo "'/>
                                    <button type = 'submit' id = 'member-logout' class='btn btn-danger' ><i class='fa fa-sign-out' ></i ></button >
                                    </div>
                                </form>
                            </li>";
					} else {
						echo " <li style='padding-right: 10px'>
				<button type='button' class='btn btn-success btn-lg' data-toggle='modal' data-target='#login-modal'>
				  Login
						</button>
						</li>
                    ";
					}
					?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<?php
	$csrfToken = new Token( $csrfSecret );
?>
<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	<div class="modal-dialog" role="document"  style="width: 400px">
                                <div class="panel panel-default">
                                        <div class="panel-heading">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <div class="section-title" style="text-align: center">
                                                <h2><strong>Think<span style="color :orange">FOSS</span></strong></h2></div>
                                        <p style="text-align: center"> code | train | grow</p>

                                </div>
                                        <div class="panel-body">
                                        <form  action = 'assets/php/doSignIn.php' method = 'post' style="padding: 10px 10px 0px 10px;" >
                                                <div class='form-group'>
                                                        <label class='sr-only' for='username' > Email id </label >
                                                        <div class='input-group' >
                                                                <div class='input-group-addon'><i class='fa fa-user'></i ></div >
                                                                <input type = 'text' class='form-control' id = 'username' name = 'username' placeholder = ' Email id'>
                                                        </div> <br>
                                                        <label class='sr-only' for='password'> Password</label >
                                                        <div class='input-group'>
                                                                <div class='input-group-addon' ><i class='fa fa-eye' ></i ></div >
                                                                <input type = 'password' class='form-control' id = 'password' name = 'password' placeholder = ' Password'>
                                                        </div>
                                                        <input type='hidden' name='CSRFToken' value='<?php echo $csrfToken->getCSRFToken(); ?>'/>
                                                        <button type="submit" class="btn btn-success btn-raised btn-block">Sign in</button>

                                                </div>
                                        </form>
                                        </div>
                                        <div class="panel-footer">
                                <p style="text-align: center;">
                                        <a href='signup.php'> <button  class='btn btn-raised' style='background-color: #d0e9c6; padding-right: 10px; color:black; padding-left: 10px; margin-right: 10px'> SIGN UP </button></a>
                                        or login using

                                        <a href='assets/php/oauth/oauth2callback.php'> <button type='button' style="width: 50px; height:50px; border-radius: 25px;   padding: 10px 16px; " class='btn btn-material-deeporange btn-raised'><i class="fa fa-google-plus fa-2x"></i> </button></a>
                                        <a href='assets/php/oauth/oauth2callbackgithub.php?action=login'> <button type='button' style=" width: 50px; height:50px; border-radius: 25px; padding: 10px 16px;" class='btn btn-material-bluegrey btn-raised'><i class="fa fa-github fa-2x"></i> </button></a>

                                                </p>
                                </div>

                                </div>

	                </div>

</div>


<div id="tf-portal" class="text-center">
	<div class="overlay">
		<div class="container content">
			<div class="row">
		<?php
		if ( $_SESSION['message'] ) {
			$message = $_SESSION['message'];
			echo "<p class='alert-success'> $message</p>";
			unset( $_SESSION['message'] );
		}
		if ( $_SESSION['error'] ) {
			$errorMessage = $_SESSION['error'];
			echo "<p class='alert-warning'> $errorMessage </p>";
			unset( $_SESSION['error'] );
		}
		?>
		<div class="col-md-6" style="text-align: left;">
			<div class="section-title">
				<h2>Why Sign <strong>UP ?</strong></h2>
				<div class="clearfix"></div>
			</div>
			<ul class="user-list">
				<li>
					<span class="fa fa-check"></span>
					<strong>Enroll for courses</strong> - <em>Only registered users can eroll for courses </em>
				</li>
				<li>
					<span class="fa fa-check"></span>
					<strong>Offer courses</strong> - <em> Once registered, adding a new course is a piece of cake </em>
				</li>
				<li>
					<span class="fa fa-check"></span>
					<strong>Manage your payments</strong> - <em> The portal makes sure your money is safe</em>
				</li>
				<li>
					<span class="fa fa-check"></span>
					<strong>Request for solutions</strong> - <em> Your next solution is one login away </em>
				</li>

			</ul>
			<h3>Already a member ?</h3>
			<ul class="user-list">
				<li><span class="fa fa-sign-in"></span>
					<strong>Sign in </strong> to manage your preferences
				</li>
			</ul> <br><br>
		</div>

		<div class="col-md-6">
			<div class="section-title" style="text-align: left">
				<h2>Sign <strong>Up</strong></h2>
				<div class="clearfix"></div>
			</div> <br>
			<div>
				<form class='form-inline ' action='assets/php/doSignUp.php'  style="text-align: justify" method='post'>
					<div class='form-group well' >

						<label class='sr-only' for='user_first_name'>Your first name</label>
						<div class='input-group'>
							<div class='input-group-addon'><i class='fa fa-user'></i></div>
							<input required type='text'class='form-control' id='user_first_name' name='user_first_name' placeholder='First Name'>
						</div>
						<label class='sr-only' for='user_last_name'>Your last name</label>
						<div class='input-group'>
							<div class='input-group-addon'><i class='fa fa-user'></i></div>
							<input required type='text'class='form-control' id='user_last_name' name='user_last_name' placeholder='Last Name'>
						</div><br><br>
						<label class='sr-only' for='user_pass_once'>Password</label>
						<div class='input-group'>
							<div class='input-group-addon'><i class='fa fa-eye'></i> </div>
							<input required type='password'  class='form-control' id='user_pass_once' name='user_pass_once' placeholder='Password'>
						</div>
						<label class='sr-only' for='user_pass_again'>Again </label>
						<div class='input-group'>
							<div class='input-group-addon'><i class='fa fa-eye'></i></div>
							<input required type='password' class='form-control' id='user_pass_again' name='user_pass_again' placeholder='Password again'>
						</div>
						<br> <br>
						<label class='sr-only' for='user_email'>Your Email</label>
						<div class='input-group' >
							<div class='input-group-addon'><i class='fa fa-envelope'></i></div>
							<input required type='email'  class='form-control' id='user_email'  name='user_email' placeholder='Your email id'>
						</div>

						<div class='input-group'>
							<div class='input-group-addon'><i class='fa fa-venus-mars'></i></div>
							<select name='user-gender' class="form-control">
								<option>Male</option>
								<option>Female</option>
								<option>Other</option>
							</select>
						</div>

						<br><br>
						<div class='input-group'>
							<input type="checkbox" required name="terms"> I accept the  <a href="#"  data-container="body" data-toggle="popover"  data-placement="right" data-content="ThinkFOSS will
                        share your first name, last name and other public information with internal users for communication.
                        By signing up, you agree to behold our friendly space policy. ">
								terms and conditions of ThinkFOSS </a>
						</div>

						<br><br>
						<script src='https://www.google.com/recaptcha/api.js'></script>
						<div class='input-group'>
							<div class="g-recaptcha"  data-sitekey="6LcuGAwTAAAAALbkjHwyE3Q9l8vtBDh-rD8P8_aS"></div>
						</div>
						<?php
						$csrfToken = new Token( $csrfSecret );
						?>
						<input type="hidden" name="CSRFToken" value='<?php echo $csrfToken->getCSRFToken(); ?>'/>

						<button style='submit' class='btn btn-primary btn-lg'>Sign Up</button>

					</div>

				</form>
			</div>
			<div style="text-align: left">

				<h3>or login with </h3>
				<a href='assets/php/oauth/oauth2callback.php'> <button type='submit' class='btn btn-material-deeporange btn-lg'><i class="fa fa-google-plus"></i> </button></a>
				<a href='assets/php/oauth/oauth2callbackgithub.php?action=login'> <button type='submit' class='btn btn-material-bluegrey btn-lg'><i class="fa fa-github"></i> </button></a>
			</div>


		</div>
		</div>
	</div>


	</div>
</div>

<?php include 'footer.html';?>
</body>
</html>
