<?php
session_start();
require_once('assets/php/Token.php');
require_once('assets/php/access/accessTokens.php');
$csrfToken = new Token( $csrfSecret );
require_once('assets/php/access/accessDB.php');
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
        <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-66359518-1', 'auto');
                ga('send', 'pageview');

        </script>
        <link href="css/material/material-wfont.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation
==========================================-->
<nav id="tf-menu" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
                                <li><a href="#tf-home" class="page-scroll">Home</a></li>
                                <li><a href="#tf-about" class="page-scroll">About</a></li>
                                <li><a href="#tf-team" class="page-scroll">Team</a></li>
                                <li><a href="#tf-services" class="page-scroll">Services</a></li>
                                <li><a href="#tf-testimonials" class="page-scroll">Testimonials</a></li>
                                <li><a href="#tf-mentor" class="page-scroll">Involve</a></li>
                                <li><a href="#tf-contact" class="page-scroll">Contact</a></li>
                                <?php
                                if ( isset( $_SESSION['loggedin_user'] ) ) {
                                        $loggedinUser = $_SESSION['loggedin_user'];
                                        echo "
                                            <li><a> Hi <span style=' font-weight: bold'>$loggedinUser</span></a></li>
                                            <li>
                                            <form class='form-inline' action = 'assets/php/doSignOut.php' method = 'post' >
                                            <div class='form-group'>
                                                <a href='portal/portal.php'><button style='padding: 10px 10px 10px 10px;' type = 'button'  id = 'member-portal' class='btn btn-primary btn-success' ><i class='fa fa-laptop' ></i > Portal</button ></a>
                                                <input type='hidden' name='CSRFToken' value='"; echo $csrfToken->getCSRFToken(); echo "'/>
                                                <button type = 'submit' id = 'member-logout' style='padding: 10px 10px 10px 10px; margin-right: 10px' class='btn btn-danger' ><i class='fa fa-sign-out' ></i ></button >
                                            </div>
                                        </form>
                                </li>";
                                        } else {
	                                        echo "<li>

                                                <div>
                                                <button type='button' class='btn btn-raised' data-toggle='modal' data-target='#login-modal' style='background-color: gold; color: black; padding-right: 10px; padding-left: 10px'>Login</button>
                                                <a href='signup.php'> <button  class='btn btn-raised' style='background-color: #d0e9c6; padding-right: 10px; color:black; padding-left: 10px; margin-right: 10px'> SIGN UP </button></a>
                                                </div>

                                                </li>
                            ";
                                }
                                ?>
                        </ul>
                </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
</nav>

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



<!-- Home Page
==========================================-->
<div id="tf-home" class="text-center">
        <div class="overlay">
                <div class="content">
                        <h1>Welcome to <strong>Think<span class="color">FOSS</span></strong></h1>
                        <p class="lead"><strong>< code | train | grow ></strong></p>
                </div>
                <div class="row">
                        <div class="col-md-4">
                                <i style="font-size: 500%; color: seashell" class="fa fa-graduation-cap"></i>
                                <h3> I got skills & want to earn<br> some <span style="color: gold"><i class="fa fa-rupee"></i> </span>  out of it!</h3>
                                <a href="#tf-mentor" class="page-scroll">
                                        <button class="btn tf-btn btn-primary btn-lg" ><strong>I got skills</strong></button></a>

                        </div>
                        <div class="col-md-4" style="border: dashed gold; padding: 1%">
                                <i style="font-size: 500%; color: gold" class="fa fa-star"></i>
                                <h3> I am looking for solutions!<br> Build me one</h3>
                                <a href="#tf-task" class="page-scroll">
                                        <button class="btn tf-btn btn-primary btn-lg" style="background-color: gold" ><strong><span style="color: black";>Solutions</span></strong></button></a>
                        </div>
                        <div class="col-md-4" >
                                <i style="font-size: 500%; color: seashell" class="fa fa-child"></i>
                                <h3> I am looking for skills!<br> Help me find them</h3>
                                <a href="#student" class="page-scroll">
                                        <button class="btn tf-btn btn-primary btn-lg" ><strong>I want skills</strong></button></a>
                        </div>

                        <div class="container">
                        <div id="owl-home" class="owl-carousel owl-theme">
                                        <?php
                                        $statement = "SELECT `course_name`, `course_id`, `course_bio` FROM `course_details` WHERE `course_approved` = true";
                                        if ( $res = $conn->query( $statement ) ) {
                                                foreach( $res as $row ) {
                                                        $courseName = $row['course_name'];
                                                        $courseId = $row['course_id'];
                                                        echo "
                                                <div class='panel' id='course-panel-home'>
                                                <div class='panel-heading' style='text-align: center' >
                                                 <i style='color: gold; position: fixed; right :80px; left: 80px;' class='fa fa-rocket fa-2x'></i>
                                                </div>
                                                <div class='panel-body'>
                                                <a href='portal/student/course.php?name=$courseName&course=course-$courseId'
                                                target='_blank' style='color: white;'> <h2 style='text-transform: capitalize'>$courseName</h2></a>
                                                </div>
                                                </div>";

                                                }
                                        }
                                        ?>

                        </div>
                        </div>

                </div>
        </div>
</div>

<nav style="padding-top: 15px; " class="navbar navbar-fixed-bottom" >
        <div class="container">
                <div class="pull-left fnav">
                        <p style="color: white">NO RIGHTS RESERVED. GPL v3.0. Designed and Maintained by <a href="http://foss.amrita.ac.in" target="_blank">FOSS@Amrita</a>. Bugs ? Please report at our <a href="http://phab.thinkfoss.com" target="_blank">Phabricator</a></p>
                </div>
                <div class="pull-right fnav">
                        <ul class="footer-social">
                                <li><a href="http://www.thinkfoss.com/index.php#tf-contact" target="_blank"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="http://facebook.com/thinkfoss" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://plus.google.com/102089872995784319229/about" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="https://twitter.com/thinkfoss" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                </div>
        </div>
</nav>


<!-- About Us Page
==========================================-->
<div id="tf-about">
        <div class="container">
                <div class="row">
                        <div class="col-md-6">
                                <img src="img/thinkfosslogo.png" class="img-responsive">
                        </div>
                        <div class="col-md-6">
                                <div class="about-text">
                                        <div class="section-title">
                                                <h4>About us</h4>
                                                <h2>HOW We <strong>EVOLVED</strong></h2>
                                                <hr>
                                                <div class="clearfix"></div>
                                        </div>
                                        <p class="intro">When mentors and students of <a href="http://amritafoss.in" target="_blank">FOSS@Amrita</a> thought of scaling up their
                                                presence, starting a company was the best option. Today, we are a group of developers, programmers and designers with 250+
                                                upstream commits in less than 2 years, and still growing up. ThinkFOSS is an outcome of powerful minds and responsive
                                                Computers. </p>
                                        <ul class="about-list">
                                                <li>
                                                        <span class="fa fa-dot-circle-o"></span>
                                                        <strong>Mission</strong> - <em>To deliver the best training and technology available</em>
                                                </li>
                                                <li>
                                                        <span class="fa fa-dot-circle-o"></span>
                                                        <strong>Expertise</strong> - <em>Training, Solutions and Maintenance of Open Source products</em>
                                                </li>
                                                <li>
                                                        <span class="fa fa-dot-circle-o"></span>
                                                        <strong>Clients</strong> - <em>Anybody thinking of taking a step into Open Source Development</em>
                                                </li>
	                                        <li>
		                                        <span class="fa fa-dot-circle-o"></span>
		                                        <strong>Vision</strong> - <em>Make India Open Source</em>
	                                        </li>
                                        </ul>
                                </div>

                                <a type="button" target="_blank" href="http://blog.thinkfoss.com" class="btn btn-lg btn-success">Visit Blog</a>
                        </div>
                </div>
        </div>
</div>

<!-- Team Page
==========================================-->
<div id="tf-team" class="text-center">
        <div class="overlay">
                <div class="container">
                        <div class="section-title center">
                                <h2>Meet <strong>our team</strong></h2>
                                <div class="line">
                                        <hr>
                                </div>
                        </div>

                        <div id="team" class="owl-carousel owl-theme row">
                                <div class="item">
                                        <div class="thumbnail">
                                                <img src="img/team/Tony_Thomas.jpg" alt="Tony Thomas" class="img-circle team-img">
                                                <div class="caption">
                                                        <h3>Tony Thomas</h3>
                                                        <p>CTO & Co-Founder</p>
                                                        <p>Random Open Source guy and Wikimedian who thinks<br> FOSS is the best</p>
                                                        <p>
                                                        <a href="https://in.linkedin.com/in/tonythomas01" target="_blank"><i class="fa fa-linkedin"></i></a> &nbsp
                                                        <a href="https://github.com/tonythomas01" target="_blank"><i class="fa fa-github"></i></a>  &nbsp
                                                        <a href="http://blog.tttwrites.in" target="_blank"> <i class="fa fa-rss"></i></a> &nbsp
                                                        <a href="https://twitter.com/01tonythomas" target="_blank"> <i class="fa fa-twitter"></i></a> &nbsp
                                                        <a href="https://www.facebook.com/01tonythomas" target="_blank"> <i class="fa fa-facebook"></i></a>
                                                        </p>
                                                </div>
                                        </div>
                                </div>

                                <div class="item">
                                        <div class="thumbnail">
                                                <img src="img/team/tinaj.jpg" alt="Tina Johnson" class="img-circle team-img">
                                                <div class="caption">
                                                        <h3>Tina Johnson</h3>
                                                        <p>Co-Founder</p>
                                                        <p>Google Summer of Code student with various commits to Mediawiki and Linux Kernel</p>
                                                        <p>
                                                                <a href="https://in.linkedin.com/pub/tina-johnson/70/22b/14b" target="_blank"><i class="fa fa-linkedin"></i></a> &nbsp
                                                                <a href="https://github.com/tinajohnson" target="_blank"><i class="fa fa-github"></i></a>  &nbsp
                                                                <a href="http://tinaj1234.wordpress.com" target="_blank"> <i class="fa fa-rss"></i></a> &nbsp
                                                                <a href="https://twitter.com/tinajohnson1234" target="_blank"> <i class="fa fa-twitter"></i></a> &nbsp
                                                        </p>
                                                </div>
                                        </div>
                                </div>

                                <div class="item">
                                        <div class="thumbnail">
                                                <img src="img/team/bithin_alangot.jpg" alt="Bithin Alangot" class="img-circle team-img">
                                                <div class="caption">
                                                        <h3>Bithin Alangot</h3>
                                                        <p>Advisor</p>
                                                        <p>PhD research scholar in Cyber Security Systems & Networks and <br> Mentor of <a href="http://foss.amrita.ac.in" target="_blank">FOSS@Amrita</a>  </p>
                                                </div>
                                        </div>
                                </div>

                                <div class="item">
                                        <div class="thumbnail">
                                                <img src="img/team/vipinp.jpg" alt="Vipin Pavithran" class="img-circle team-img">
                                                <div class="caption">
                                                        <h3>Vipin Pavithran</h3>
                                                        <p>Chief Mentor, <a href="http://foss.amrita.ac.in" target="_blank">FOSS@Amrita</a></p>
                                                        <p>Assistant professor at Amrita Cyber Security with 10+ years experience in Software Industry</p>
                                                </div>
                                        </div>
                                </div>

                                <div class="item">
                                        <div class="thumbnail">
                                                <img src="img/team/sakshi.jpg" alt="Sakshi Bansal" class="img-circle team-img">
                                                <div class="caption">
                                                        <h3>Sakshi Bansal</h3>
                                                        <p>Systems and Operations</p>
                                                        <p><a href="http://foss.amrita.ac.in" target="_blank">FOSS@Amrita</a> student, currently spending her time working with various upstream projects</p>
	                                                <p>
		                                                <a href="https://in.linkedin.com/in/sakshi-bansal" target="_blank"><i class="fa fa-linkedin"></i></a> &nbsp
		                                                <a href="https://github.com/sakshi-bansal" target="_blank"><i class="fa fa-github"></i></a>  &nbsp
		                                                <a href="http://sakshiii.wordpress.com/" target="_blank"> <i class="fa fa-rss"></i></a> &nbsp
		                                                <a href="https://twitter.com/sakshibansall" target="_blank"> <i class="fa fa-twitter"></i></a> &nbsp
	                                                </p>
                                                </div>
                                        </div>
                                </div>



                        </div>

                </div>
        </div>
</div>

<!-- Services Section
==========================================-->
<div id="tf-services" class="text-center">
        <div class="overlay">
                <div class="container">
                        <div class="section-title center">
                                <h2>Take a look at <strong>our services</strong></h2>
                                <div class="line">
                                        <hr>
                                </div>
                                <div class="clearfix"></div>
                                <small><em>We provide you with the best Open Source service and training at the modest price</em></small>
                        </div>
                        <div class="space"></div>
                        <div id="service" class="owl-carousel owl-theme">
                                <div class="service">
                                        <i class="fa fa-child"></i>
                                        <h4><strong>School Training</strong></h4>
                                        <p>Training in Linux & various Open Source techniques at <strong>School</strong>
                                                level to make students contribute to Open Source projects</p>
                                </div>

                                <div class="service">
                                        <i class="fa fa-cubes   "></i>
                                        <h4><strong>University Training</strong></h4>
                                        <p>Training in Open Source tools and service for University students to contribute to upstream projects
                                                and setup FOSS clubs</p>
                                </div>

                                <div class="service">
                                        <i class="fa fa-diamond"></i>
                                        <h4><strong>Industry Training</strong></h4>
                                        <p>Training in Linux & Open Source techniques and products at <strong> Industry </strong>
                                                level to increase quality of employees</p>
                                </div>
                                <div class="service">
                                        <i class="fa fa-check-square"></i>
                                        <h4><strong>Open Source Solutions</strong></h4>
                                        <p>Develop and maintain Open Source solutions for organizations and support in porting</p>
                                </div>

                                <div class="service">
                                        <i class="fa fa-desktop"></i>
                                        <h4><strong>Web Development</strong></h4>
                                        <p>Build professional websites for organisations keen at changing their web outlook</p>
                                </div>

                                <div class="service">
                                        <i class="fa fa-mobile"></i>
                                        <h4><strong>Mobile Apps</strong></h4>
                                        <p>Mobile application solutions in Android and other platforms for organizations get into the <em>next market</em></p>
                                </div>

                        </div>
                </div>
        </div>
</div>

<!-- Clients Section
==========================================-->
<div id="tf-clients" class="text-center">
        <div class="overlay">
                <div class="container">

                        <div class="section-title center">
                                <h2>Upstream <strong>Contributions</strong></h2>
                                <div class="line">
                                        <hr>
                                </div>
                        </div>
                        <div id="clients" class="owl-carousel owl-theme">
                                <div class="item">
                                        <img src="img/client/01.png">
                                        <div class="caption">
                                                <h3> Mediawiki</h3>
                                        </div>
                                </div>
                                <div class="item">
                                        <img src="img/client/02.png">
                                        <h3>Mozilla Firefox</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/chromium.png">
                                        <h3>Chromium</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/drupal-logo.png">
                                        <h3>Drupal</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/gnome2-logo.png">
                                        <h3>Gnome</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/Rlogo-3.png">
                                        <h3>R Language</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/linux-kernel.png">
                                        <h3>Linux Kernel</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/owasp.png">
                                        <h3>OWASP</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/kde-logo-plain.png">
                                        <h3>KDE</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/git-icon-white.png">
                                        <h3>Git</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/buggie.png">
                                        <h3>Bugzilla</h3>
                                </div>
                                <div class="item">
                                        <img src="img/client/wordpress.png">
                                        <h3>Wordpress</h3>
                                </div>
                        </div>

                </div>
        </div>
</div>

<div id="tf-task">
        <div class="container">
                <div class="row">
                        <div class="col-md-6">
                                <a href="portal/portal.php"><img src="img/getsolutions.png" class="img-responsive"></a>
                        </div>
                        <div class="col-md-6">
                                <div class="about-text">
                                        <div class="section-title">
                                                <h4>Submit your task</h4>
                                                <h2>Get your <strong>Solution</strong></h2>
                                                <hr>
                                                <div class="clearfix"></div>
                                        </div>
                                        <p class="intro"> ThinkFOSS uses its <a href="portal/portal.php">portal</a> to handle solution requests, and you are welcome to use it.
                                                ThinkFOSS currently can handle web and mobile application requests, and one of our admins will reach to you back in <24 hours to
                                                get more details and start working.
                                        <ol class="task-list">
                                                <li>
                                                        <span class="fa fa-flask"></span>
                                                        <strong>Register</strong> - <em>Use one of the options available to log-in</em>
                                                </li>
                                                <li>
                                                        <span class="fa fa-pencil-square-o"></span>
                                                        <strong>Create a new solution request</strong> - <em>Create a task with your requirements, and play around as far as
                                                                you want</em>
                                                </li>
                                                <li>
                                                        <span class="fa fa-coffee"></span>
                                                        <strong>Grab a coffee </strong> - <em> Wait for moments until one of us contact you with the same</em>
                                                </li>

                                        </ol> <br>
                                        <a href="portal/portal.php" class="page-scroll"><button class="btn tf-btn btn-center" >Create Request</button></a>
                                        <br>
                                </div>
                        </div>
                </div>
        </div>
</div>


<!-- Testimonials Section
==========================================-->
<div id="tf-testimonials" class="text-center">
        <div class="overlay">
                <div class="container">
                        <div class="section-title center">
                                <h2><strong>Our clients’</strong> testimonials</h2>
                                <div class="line">
                                        <hr>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                        <div id="testimonial" class="owl-carousel owl-theme">
                                                <div class="item">
                                                        <blockquote>
                                                        <h3>I requested for an app - to be used on a tablet for obtaining sign ups during Amrita University's International tours.
                                                        My sincere thanks to ThinkFOSS for providing me with the app within two days of request. A simple, yet neat app was provided
                                                        with the basic necessary features. Got emails and answers to all questions within minutes. Keep up the great work ThinkFOSS!
                                                        Thanks a lot for your help and effort. Will keep you posted on the actual usage. Looking forward to extended support in case
                                                        of future issues/request for upgrade.</h3>

                                                                <p><strong>Sujatha</strong>,Co-ordinator, Amrita Center for International Programs.</p>
                                                        </blockquote>
                                                </div>

                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>

<div id="tf-mentor" >
        <div class="container">
                <div class="row">
                        <div class="col-md-6" style="background-color:gold; padding-top: 10px">
                                <div class="jumbotron">
                                        <h1 style="text-align: center">Be a mentor! </h1><br>
                                        <p>Mentoring is one of the key process in Open Source Software development, and ThinkFOSS
                                                aims at providing the best mentoring available to the needy in a complete transparent transaction.</p>
                                        <br>
                                        <div style="text-align: center" class="row">
                                        <div class="col-xs-6 col-md-3" id="icon-container">
                                        <i class="fa fa-sign-in fa-5x" style="color: #67b168"> </i> <br>
                                        Join
                                        </div>

                                        <div class="col-xs-6 col-md-3" id="icon-container">
                                                <i class="fa fa-plus fa-5x" style="color: #c1e2b3"> </i> <br>
                                                Add
                                        </div>

                                        <div class="col-xs-6 col-md-3" id="icon-container">
                                                <i class="fa fa-clock-o fa-5x" style="color: #46b8da"> </i><br>
                                                Confirm
                                        </div>

                                        <div class="col-xs-6 col-md-3" id="icon-container">
                                                <i class="fa fa-mortar-board fa-5x" style="color: #fcac45"></i><br>
                                                Teach
                                        </div>

                                        <div class="col-xs-6 col-md-3" id="icon-container">
                                                <i class="fa fa-dollar fa-5x" style="color: #03a9f4"></i> <br>
                                                Earn
                                        </div>


                                        </div>

                                        <div style="bottom: 0; padding-top: 50px">
                                                <button class="btn btn-primary btn-lg" href="portal/portal.php" role="button">Be a Mentor</button>
                                        </div>
                                </div>


                        </div>

                        <div class="col-md-6" id="student" style="background-color: silver;  padding-top: 10px">
                                        <div class="jumbotron">
                                                <h1 style="text-align: center">Be a student! </h1><br>
                                                <p> ThinkFOSS helps in connecting people with skills to people in need, and
                                                        makes sure that you get the maximum out of it. Topics available to learn ranges from 'Beginner' to 'Advanced' level.</p>
                                                <br>
                                                <div class="row" style="text-align: center">
                                                <div class="col-xs-6 col-md-3" id="icon-container">
                                                        <i class="fa fa-sign-in fa-5x" style="color: #67b168"> </i> <br>
                                                        Join
                                                </div>

                                                <div class="col-xs-6 col-md-3" id="icon-container">
                                                        <i class="fa fa-search fa-5x" style="color: #c1e2b3"> </i> <br>
                                                        View
                                                </div>

                                                <div class="col-xs-6 col-md-3" id="icon-container">
                                                        <i class="fa fa-cutlery fa-5x" style="color: #46b8da"> </i><br>
                                                        Enroll
                                                </div>

                                                <div class="col-xs-6 col-md-3" id="icon-container">
                                                        <i class="fa fa-street-view fa-5x" style="color: #fcac45"> </i><br>
                                                        Learn
                                                </div>

                                                <div class="col-xs-6 col-md-3" id="icon-container">
                                                        <i class="fa fa-trophy fa-5x" style="color: #03a9f4"> </i> <br>
                                                        Succeed
                                                </div>

                                                </div>

                                                <div style="bottom: 0; padding-top: 50px">
                                                        <button class="btn btn-primary btn-lg" href="portal/portal.php" role="button">Be a Student</button>
                                                </div>
                                        </div>

                        </div>

                        <div class="container well">
                                <div class="section-title center">
                                <h2 style="text-align: center" > <strong>Trending</strong> on ThinkFOSS</h2>
                                        </div>
                        <div id="owl-demo" class="owl-carousel owl-theme">


                                <?php
                                $statement = "SELECT `course_name`, `course_id`, `course_bio` FROM `course_details` WHERE `course_approved` = true";
                                if ( $res = $conn->query( $statement ) ) {
                                        foreach( $res as $row ) {
                                                $courseName = $row['course_name'];
                                                $courseId = $row['course_id'];
                                                $coruseBio = $row['course_bio'];

                                                echo "
                                                <div class='panel panel-primary' id='course-panel-mentor'>
                                                <div class='panel-heading'>
                                                <div class='panel-title'>
                                                <a href='portal/student/course.php?name=$courseName&course=course-$courseId'
                                                target='_blank' style='color: white'> <h2>$courseName</h2></a>
                                                </div></div>

                                                <div class='panel-body'> <p>$coruseBio</p></div>

                                                </div>";

                                        }
                                }
                                ?>

                        </div>

                        <div class="customNavigation">
                                <a class="btn prev " style="padding: 4px;"><i class="fa fa-arrow-circle-left fa-2x"></i> </a>
                                <a class="btn next " style="padding: 4px;"><i class="fa fa-arrow-circle-right fa-2x"></i> </a>
                        </div>
                        </div>


                        </div>
        </div>
</div>

<!-- Contact Section
==========================================-->
<div id="tf-contact" class="text-center" style="background-color: seashell">
        <div class="container">
                <div class="row">
                        <div class="col-md-8 col-md-offset-2 well">

                                <div class="section-title center">
                                        <h2>Feel free to <strong>contact us</strong></h2>
                                        <div class="line">
                                                <hr>
                                        </div>
                                        <div class="clearfix"></div>
                                        <small><em>Please drop in a mail to hire us for your need</em></small>
                                </div>

                                <form action="http://formspree.io/tony@thinkfoss.com" method="POST" >
                                        <form class="form-inline">
                                                <div class="form-group">
                                                        <label class="sr-only" for="exampleInputAmount">Your Name</label>
                                                        <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-user"></i> </div>
                                                                <input type="text" class="form-control" id="contact-name" placeholder="Your Name" name="name">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label class="sr-only"  for="exampleInputEmail1">Email id</label>
                                                        <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-envelope"></i> </div>
                                                                <input type="email" class="form-control" id="contact-email" placeholder="Enter email" name="_replyto">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label class="sr-only" for="exampleInputEmail1">Message</label>
                                                        <div class="input-group">
                                                                <div class="input-group-addon"><i class="fa fa-book"></i> </div>
                                                                <textarea class="form-control" rows="3" name="message" id="message" placeholder="Your message" ></textarea>
                                                        </div>
                                                </div>
                                                <div class="form-group" >
                                                        <div class="input-group" >
                                                                <button type="submit" class="btn tf-btn btn-lg btn-right">Submit</button>
                                                        </div>
                                                </div>
                                        </form>

                        </div>
                </div>

        </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/SmoothScroll.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>

<script src="js/owl.carousel.js"></script>
<!-- Javascripts
================================================== -->
<script type="text/javascript" src="js/main.js"></script>

</body>
</html>
