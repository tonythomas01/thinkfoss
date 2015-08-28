<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: signup.php');
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
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="../img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/apple-touch-icon-114x114.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome/css/font-awesome.css">


    <!-- Stylesheet
    ================================================== -->
    <link rel="stylesheet" type="text/css"  href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">

    <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="../js/modernizr.custom.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Latest compiled and minified CSS -->


    <!-- jQuery library -->
    <script src="../js/jquery.1.11.1.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!--[endif]-->
</head>
<body background="black">
<!-- Navigation
==========================================-->
<nav id='tf-menu' class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.php"><i class="fa fa-home"></i> Think<span class="color">FOSS</span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mentor <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Courses Created</a></li>
                        <li><a href="#">Add a new Course</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Learn <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Enrolled Courses</a></li>
                        <li><a href="#">Available courses</a></li>
                    </ul>
                </li>
            </ul>


            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Preferences</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['loggedin_user'] ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Edit Profile</a></li>
                        <li><a href="#">Recommend</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="php/doSignOut.php">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="tf-portal" class="text-center">
    <div class="overlay">
        <div class="portal">

            <div class='col-xs-6'>
                <br>
                <form class='form-inline' action='../php/doCreateCourse.php' method='post'>
                    <div class='form-group'>

                        <label class='sr-only' for='course_name'>I will teach</label>
                        <div class='input-group' >
                            <div class='input-group-addon'>I will teach</div>
                            <input required  type='text' size='100%' class='form-control' id='course_name' name='course_name' placeholder='Give a stylish name for your course'>
                        </div>
                        <br><br>

                        <label class='sr-only' for='course_bio'>Short Bio</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-book'></i></div>
                            <textarea required rows='4' cols='100' class='form-control' id='course_bio'  name='course_bio' placeholder='Short description on the course.'></textarea>
                        </div>

                        <br><br>
                        <label class='sr-only' for='course_lang'>Language</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class="fa fa-language"></i> </div>
                            <input required type='text' class='form-control' id='course_lang' name='course_lang' placeholder='Language Preferred'>
                        </div>

                        <div class='input-group'>
                            <div class='input-group-addon' ><i class='fa fa-bomb'></i></div>
                                <select class="form-control" name="course_difficulty">
                                <option>Beginner</option>
                                <option>Intermediate</option>
                                <option>Advanced</option>
                                </select>
                            </div>
                        <br><br>

                        <label class='sr-only' for='course_date_to'>Date from</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><strong>From</strong></div>
                            <input required type='date' class='form-control' id='course_date_from' name='course_date_from' placeholder='Available Date'>
                        </div>
                        <label class='sr-only' for='course_date_to'>Time from</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-clock-o'></i></div>
                            <input required type='time' class='form-control' id='course_time_from' name='course_time_from' placeholder='Available Time'>
                        </div>

                        <br><br>

                        <label class='sr-only' for='course_date_to'>Date To</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><strong>To &nbsp; &nbsp;&nbsp;</strong></div>
                            <input required type='date' class='form-control' id='course_date_to' name='course_date_to' placeholder='Available Date'>
                        </div>
                        <label class='sr-only' for='course_time_to'>Time to</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-clock-o'></i></div>
                            <input required type='time'  class='form-control' id='course_time_to' name='course_time_to' placeholder='Available Time'>
                        </div> <br><br>
                        <label class='sr-only' for='course_amount'>Amount</label>
                        <div class='input-group'>
                            <div class='input-group-addon'><i class='fa fa-rupee'></i> </div>
                            <input required type='number' class='form-control' id='course_amount'  name='course_amount' placeholder='Charge'>
                        </div>
                        <button type='submit' class='btn btn-primary'>Create</button>
                    </div>
                </form>

            </div>

            <div class='col-xs-6'>
                <h1 class="section-title"> Add a course</h1>
                <p class='intro'> Great! Add in the details of your new course, and we will make it avialable for the public in few minutes. Make sure you give
                    a catchy title so that it attracts. <br><br>
                <h2>TODO</h2>
                <ul class='mentor-list'>
                    <li>
                        <span class='fa fa-check'></span>
                        <strong>Add in course details</strong>
                    </li>
                    <li>
                        <span class='fa fa-check'></span>
                        <strong>Wait for confrimation email</strong>
                    </li>
                    <li>
                        <span class='fa fa-check'></span>
                        <strong>See your coures being public</strong>
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
<?php include '../footer.html' ?>
</body>
</html>