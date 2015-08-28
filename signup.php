<?php
        session_start();
	if( $_SESSION['loggedin_user'] ) {
		header( 'Location: portal.php');
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

    <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="js/modernizr.custom.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body background="black">
<!-- Navigation
==========================================-->
<nav id="tf-menu" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
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
                <li><a href="index.php#tf-partners" class="page-scroll">Partners</a></li>
                <li><a href="index.php#tf-contact" class="page-scroll">Contact</a></li>
                <li>
                    <?php
                    if ( isset( $_SESSION['loggedin_user'] ) ) {
                        $loggedinUser = $_SESSION['loggedin_user'];
                        echo "<li> <a>Hi <span style='color: red; font-weight: bold'>$loggedinUser</span></a></li>
                            <li>
                                <form class='form-inline' action = 'php/doSignOut.php' method = 'post' >
                                <div class='form-group'>
                                    <button type = 'submit' id = 'member-logout' class='btn btn-danger' ><i class='fa fa-sign-out' ></i ></button >
                                    </div>
                                </form>
                            </li>";
                    } else { echo "
                        <form class='form-inline' action = 'php/doSignIn.php' method = 'post' >
                        <div class='form-group'>

                            <label class='sr-only' for='username' > Email id </label >
                            <div class='input-group' >
                                <div class='input-group-addon'><i class='fa fa-user'></i ></div >
                                <input type = 'text' class='form-control' id = 'username' name = 'username' placeholder = 'Email id'>
                            </div>
                            <label class='sr-only' for='password'> Password</label >
                            <div class='input-group'>
                                <div class='input-group-addon' ><i class='fa fa-eye' ></i ></div >
                                <input type = 'password' class='form-control' id = 'password' name = 'password' placeholder = 'Password'>
                            </div >
                            <button type = 'submit' id = 'member-login' class='btn btn-info' ><i class='fa fa-arrow-right' ></i ></button >
                        </div >
                    </form >
                </li >
                    ";
                    }
                    ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="tf-portal" class="text-center">
    <div class="overlay">
        <div class="content">
            </div>


                        <?php
                        session_start();
                        if ( $_SESSION['message'] ) {
                            $message = $_SESSION['message'];
                            echo "<p class='alert-success'> $message</p>";
                            unset( $_SESSION['message'] );
                        } else if ( $_SESSION['error'] ) {
                            $errorMessage = $_SESSION['error'];
                            echo "<p class='alert-warning'> $errorMessage </p>";
                            unset( $_SESSION['error'] );
                        }

                        ?>
        <div class="col-xs-6" style="text-align: left;">
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

            </ul>
            <h3>Already a member ?</h3>
            <ul class="user-list">
                <li><span class="fa fa-sign-in"></span>
                    <strong>Sign in </strong> to manage your preferences
                </li>
                </ul>



        </div>



        <div class="col-xs-6">
            <div class="section-title" style="text-align: left">
                <h2>Sign <strong>Up</strong></h2>
                <div class="clearfix"></div>
            </div> <br>
	        <div>
            <form class='form-inline' action='php/doSignUp.php'  style="text-align: justify" method='post'>
                <div class='form-group'>

                    <label class='sr-only' for='user_name'>Your Name</label>
                    <div class='input-group'>
                        <div class='input-group-addon'><i class='fa fa-user'></i></div>
                        <input required type='text'class='form-control' id='user_name' name='user_name' placeholder='Your Name'>
                    </div>

                    <label class='sr-only' for='user_email'>Your Email</label>
                    <div class='input-group'>
                        <div class='input-group-addon'><i class='fa fa-envelope'></i></div>
                        <input required type='email'  class='form-control' id='user_email'  name='user_email' placeholder='Your Email id'>
                    </div>
                    <br> <br>
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
                    <label class='sr-only' for='user_dob'>BirthDay</label>
                    <div class='input-group'>
                        <div class='input-group-addon'><i class='fa fa-birthday-cake'></i></div>
                        <input required type='date' class='form-control' id='user_dob'  name='user_dob' placeholder='Birthday'>
                    </div>
                    <div class='input-group'>
                    <div class='input-group-addon'><i class='fa fa-venus-mars'></i></div>
                    <select name='user-gender' class="form-control">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                    </div>
                    <button type='submit' class='btn btn-primary'>Sign Up</button>
                </div>
            </form>
        </div>
        </div>


    </div>
	</div>

                        <!--                        <form class="form-inline" style="text-align: right" action="php/signIn.php" method="post">-->
<!--                            <div class="form-group">-->
<!---->
<!--                                <label class="sr-only" for="user_name">Email id</label>-->
<!--                                <div class="input-group">-->
<!--                                    <div class="input-group-addon">Email id</div>-->
<!--                                    <input type="text" size="20%"  class="form-control" id="user_name" name="user_name" placeholder="Email id">-->
<!--                                </div>-->
<!--                                <label class="sr-only" for="user_pass_once">Password</label>-->
<!--                                <div class="input-group">-->
<!--                                    <div class="input-group-addon">Password</div>-->
<!--                                    <input type="password"  size="20%" class="form-control" id="user_pass_once" name="user_pass_once" placeholder="Password">-->
<!--                                </div> <br><br>-->
<!--                                <button type="submit" id="member-login" class="btn btn-info">Sign In</button>-->
<!---->
<!--                            </div>-->
<!--                        </form>-->

                                <!--<label class="sr-only" for="user-name">Available Courses</label>-->
                                <!--<div class="input-group">-->
                                    <!--<div class="input-group-addon">Course</div>-->
                                    <!--<select id="student-avialabale-course" class="form-control">-->
                                        <!--<option> Introduction to Git</option>-->
                                        <!--<option> Basics of Programming </option>-->
                                        <!--<option> Web development using Node JS </option>-->
                                    <!--</select>-->
                                <!--</div>-->
                                <!--<button type="button" id="student-compare" class="btn btn-info">Compare</button>-->

                                <!--<br><br>-->
                                <!--<div class="table-responsive">-->

                                    <!--<table class="table table-bordered">-->

                                        <!--<thead>-->
                                        <!--<tr>-->
                                            <!--<td>Instructor</td>-->
                                            <!--<td>Availability IST</td>-->
                                            <!--<td>Price</td>-->
                                            <!--<td>Rating</td>-->
                                            <!--<td>Enroll</td>-->
                                        <!--</tr>-->
                                        <!--</thead>-->
                                        <!--<tbody>-->
                                        <!--<tr>-->
                                            <!--<td> Max </td>-->
                                            <!--<td> 07 - 09 </td>-->
                                            <!--<td> 10 $ </td>-->
                                            <!--<td> **** </td>-->
                                            <!--<td><button type="button" id="student-enroll" class="btn btn-info">Enroll</button> </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                            <!--<td> Manu </td>-->
                                            <!--<td> 07 - 09 </td>-->
                                            <!--<td> 10 $ </td>-->
                                            <!--<td> **** </td>-->
                                            <!--<td><button type="button" id="student-enroll" class="btn btn-info">Enroll</button> </td>-->
                                        <!--</tr>-->
                                        <!--</tbody>-->
                                    <!--</table>-->
                                <!--</div>-->


<?php include 'footer.html';?>
</body>
</html>