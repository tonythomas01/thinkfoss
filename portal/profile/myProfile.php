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
<body>
<?php
	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	$user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );
	$user->getExtra( $conn );
?>
<?php include 'navigationProfile.php' ?>

<div id="tf-portal" class="text-center">
    <div class="overlay">
        <div class="portal">
	        <?php
		        if ( isset( $_SESSION['error'] ) ) {
		        $errorMessage = $_SESSION['error'];
		        echo "<p class='alert-warning' style='text-align: center'> $errorMessage </p>";
		        unset( $_SESSION['error'] );
	        }
	        ?>

            <div class='col-xs-6'>
                <br>
	            <form class='form-inline' action='../../assets/php/doEditProfile.php'  style="text-align: justify" method='post'>
		            <div class='form-group well'>
			            <label class='sr-only' for='user_first_name'>First Name</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-user'></i></div>
				            <input  type='text'class='form-control' id='user_first_name' name='user_first_name' placeholder='First Name' value="<?php echo $user->getValue('user_first_name')?>">
			            </div>

			            <label class='sr-only' for='user_last_name'>Last Name</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-user'></i></div>
				            <input  type='text'class='form-control' id='user_last_name' name='user_last_name' placeholder='Last Name' value="<?php echo $user->getValue('user_last_name')?>">
			            </div>
			            <br><br>

			            <label class='sr-only' for='user_github'>Github profile</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-github'></i></div>
				            <input  type='text'class='form-control' id='user_github' name='user_github' placeholder='Github profile' value="<?php echo $user->getValue('user_github')?>">
			            </div>
			            <label class='sr-only' for='user_linkedin'>Linkedin profile</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-linkedin'></i></div>
				            <input  type='text'class='form-control' id='user_linkedin' name='user_linkedin' placeholder='Linkedin profile' value="<?php echo $user->getValue('user_linkedin')?>">
			            </div> <br><br>

			            <label class='sr-only' for='user_about'>About me</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-magic'></i></div>
				            <textarea  rows='4' cols='100' class='form-control' id='user_about'  name='user_about' placeholder='Few words about your technical work with Open Source or general'> <?php echo $user->getValue('user_about'); ?> </textarea>

			            </div> <br><br>
			            <label class='sr-only' for='user_occupation'>What I do</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-road'></i></div>
				            <input  type='text'class='form-control' id='user_occupation' name='user_occupation' placeholder='What I do' value="<?php echo $user->getValue('user_occupation'); ?>" >
			            </div>

			            <label class='sr-only' for='user_nation'>Nation</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-map-marker'></i></div>
				            <input  type='text'class='form-control' id='user_nation' name='user_nation' placeholder='Nationality' value="<?php echo $user->getValue('user_nation'); ?>">
			            </div>

			            <br><br>
			            <label class='sr-only' for='user_dob'>BirthDay</label>
			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-birthday-cake'></i></div>
				            <input  type='date' class='form-control' id='user_dob'  name='user_dob' value="<?php echo $user->getValue('user_dob'); ?>" placeholder='Birthday'>
			            </div>

			            <div class='input-group'>
				            <div class='input-group-addon'><i class='fa fa-venus-mars'></i></div>
				            <select name='user_gender' class="form-control" >
					            <option <?php if ( $user->getValue('user_gender') == 'Male' ) { echo 'selected'; }?>>Male</option>
					            <option <?php if ( $user->getValue('user_gender') == 'Female' ) { echo 'selected'; }?> >Female</option>
					            <option <?php if ( $user->getValue('user_gender') == 'Other' ) { echo 'selected'; }?>>Other</option>
				            </select>
			            </div>

			            <br><br>

			            <script src='https://www.google.com/recaptcha/api.js'></script>
			            <div class='input-group'>
				            <div class="g-recaptcha"  data-sitekey="6LcuGAwTAAAAALbkjHwyE3Q9l8vtBDh-rD8P8_aS"></div>
			            </div>
			            <br>

			            <div class="g-recaptcha" data-sitekey="6LcuGAwTAAAAALbkjHwyE3Q9l8vtBDh-rD8P8_aS"></div> <br>
			            <button type='submit' class='btn btn-block btn-primary'>Update</button>

		            </div>
	            </form>

            </div>

            <div class='col-xs-6'>
                <h1 class="section-title"> My Profile</h1>
                <p class='intro'>Adding in more details to your profile makes sure that you get better reviewed by the
	                administration team, and better chances of getting your course selected and shown up!  </p> <hr>
	            <p>We collect only the minimum information, and if you want to tell us something more, please contact
	            one of our admins.</p>
	        </div>
	    </div>
	</div>
<?php include_once'../../footer.html'; ?>
</body>

</body>
</html>