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
<nav id="tf-menu" class="navbar navbar-default navbar-fixed-top" >
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php" style="font-size: 30px">Think<span class="color">FOSS</span></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#tf-testimonials" class="page-scroll">Testimonials</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Involve <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#tf-courses" class="page-scroll">Learn</a></li>
						<li><a href="#tf-mentor" class="page-scroll">Mentor</a></li>

					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#tf-team" class="page-scroll">Team</a></li>
						<li><a href="#tf-services" class="page-scroll">Services</a></li>
						<li><a href="http://blog.thinkfoss.com" target="_blank" class="page-scroll">Blog</a></li>
						<li><a href="#tf-about" class="page-scroll">About Us</a></li>
						<li><a href="#tf-contact" class="page-scroll">Contact</a></li>

					</ul>
				</li>
				<?php
				if ( isset( $_SESSION['loggedin_user'] ) ) {
					$loggedinUser = $_SESSION['loggedin_user'];
					echo '<li style="padding-top: 1.5%;">
                                        <div class="btn-group">
                                        <div class="btn tf-btn-grey" href="portal/profile/myProfile.php"><i class="fa fa-user fa-fw"></i>'; echo  $loggedinUser; echo '</div>
                                                  <a class="btn tf-btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <span class="fa fa-caret-down"></span></a>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="portal/portal.php" ><i class="fa fa-laptop fa-fw"></i> Portal</a></li>
                                                    <li><a href="portal/profile/myProfile.php" ><i class="fa fa-pencil fa-fw"></i> Edit Profile</a></li>
                                                    <li class="divider"></li>
                                                     <form action = "assets/php/doSignOut.php" method="post">
                                                     <input type="hidden" name="CSRFToken" value='; echo $csrfToken->getCSRFToken(); echo '></input>
                                                        <li><button class="btn btn-link btn-block" type="submit" style="text-decoration: none" href="#" ><i class="fa fa-sign-out fa-fw"></i> Sign Out</button></li>
                                                     </form>
                                                  </ul>
                                        </div></li>
                                        ';
				} else {

					echo'<li style="padding-top: 1.5%;">
                                        <div class="btn-group">
                                                  <div class="btn tf-btn-grey" data-toggle="modal" data-target="#login-modal" href="#"><i class="fa fa-user fa-fw"></i> Login</div>
                                                  <a class="btn tf-btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <span class="fa fa-caret-down"></span></a>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="#"  data-toggle="modal" data-target="#login-modal" ><i class="fa fa-sign-in fa-fw"></i> Login</a></li>
                                                    <li><a href="signup.php"><i class="fa fa-user-plus fa-fw"></i> Sign Up</a></li>
                                                  </ul>
                                                </div></li>
                                        ';
				}
				?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<?php
require_once( 'assets/php/Token.php' );
require_once( 'assets/php/access/accessTokens.php');
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
				<p style="text-align: center"> < code | train | grow ></p>

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
						<input type='hidden' name='CSRFToken' value='<?php echo $csrfToken->getCSRFToken(); ?>'/><br>

						<button type="submit" class="btn tf-btn-grey btn-raised btn-block btn-lg">Sign in <i class="fa fa-arrow-circle-right"></i></button>

					</div>
				</form>
			</div>
			<div class="panel-footer">
				<p style="text-align: center;">
					<a href='signup.php'> <button  class='btn btn-raised tf-btn' style='padding-right: 10px; color:black; padding-left: 10px; margin-right: 10px'> SIGN UP <i class="fa fa-arrow-circle-right"></i> </button></a>
					or login using

					<a href='assets/php/oauth/oauth2callback.php'> <button type='button' style="width: 50px; height:50px; border-radius: 25px;   padding: 10px 16px; " class='btn tf-btn btn-raised'><i class="fa fa-google-plus fa-2x"></i> </button></a>
					<a href='assets/php/oauth/oauth2callbackgithub.php?action=login'> <button type='button' style=" width: 50px; height:50px; border-radius: 25px; padding: 10px 16px;" class='btn tf-btn btn-raised'><i class="fa fa-github fa-2x"></i> </button></a><br>
					<a href="forgotPassword.php"> Forgot Passowrd ?</a>
				</p>
			</div>

		</div>

	</div>

</div>


<div id="tf-portal" class="text-center">
	<div class="overlay">
		<div class="container" style="padding-top: 10%">
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

				<div style="text-align: center">
					<div class="row">
					<h1 style="text-align: center">Forgot <strong>Password</strong></h1><br>

						<form class='form-inline ' action='assets/php/actions/doResetPassword.php'  style="color: black" method='post'>
							<div class='form-group well' >

								<label class='sr-only' for='user_email'>Your Email</label>
								<div class='input-group' >
									<div class='input-group-addon'><i class='fa fa-envelope'></i></div>
									<input required type='email' size="40%" class='form-control' id='user_email'  name='user_email' placeholder='Your email id'>
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
								<input type="hidden" name="CSRFToken" value='<?php echo $csrfToken->getCSRFToken(); ?>'/> <br><br>

								<button style='submit' class='btn tf-btn-grey btn-lg'>Reset Password <i class="fa fa-arrow-circle-right"></i> </button>

							</div>

						</form>
					</div>

				</div>
				</div>
			</div>
		</div>



<?php include 'footer.html';?>
</body>
</html>
