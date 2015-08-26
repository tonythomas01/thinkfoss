<?php
    session_start();
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
<body>
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
            <a class="navbar-brand" href="index.php">Think<span class="color">FOSS</span></a>
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
                                <form class='form-inline' action = 'php/signOut.php' method = 'post' >
                                <div class='form-group'>
                                    <button type = 'submit' id = 'member-logout' class='btn btn-danger' ><i class='fa fa-sign-out' ></i ></button >
                                    </div>
                                </form>
                            </li>";
                    } else { echo "
                        <form class='form-inline' action = 'php/signIn.php' method = 'post' >
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
            <div class="container">
                <div class="row">
                    <div class="container">
                        <h3>Welcome to ThinkFOSS Portal</h3>
                        <br>

                        <h5>The page is being setup. Thank you for your co-operation</h5>

                        <?php
                        session_start();
                        if ( $_SESSION['message'] ) {
                            $message = $_SESSION['message'];
                            echo "<p class='lead'> $message</p>";
                            unset( $_SESSION['message'] );
                        } else if ( $_SESSION['error'] ) {
                            $errorMessage = $_SESSION['error'];
                            echo "<p class='alert-warning'> $errorMessage </p>";
                            unset( $_SESSION['error'] );
                        }

                        ?>

                        <!--                        <form class="form-inline" style="text-align: right" action="php/signIn.php" method="post">-->
<!--                            <div class="form-group">-->
<!---->
<!--                                <label class="sr-only" for="mentor_name">Email id</label>-->
<!--                                <div class="input-group">-->
<!--                                    <div class="input-group-addon">Email id</div>-->
<!--                                    <input type="text" size="20%"  class="form-control" id="mentor_name" name="mentor_name" placeholder="Email id">-->
<!--                                </div>-->
<!--                                <label class="sr-only" for="mentor_pass_once">Password</label>-->
<!--                                <div class="input-group">-->
<!--                                    <div class="input-group-addon">Password</div>-->
<!--                                    <input type="password"  size="20%" class="form-control" id="mentor_pass_once" name="mentor_pass_once" placeholder="Password">-->
<!--                                </div> <br><br>-->
<!--                                <button type="submit" id="member-login" class="btn btn-info">Sign In</button>-->
<!---->
<!--                            </div>-->
<!--                        </form>-->

                                <!--<label class="sr-only" for="mentor-name">Available Courses</label>-->
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



                    </div>



                    <div class="col-md-6">


                    </div>

                </div>
            </div>

        </div>
</div>
</body>
</html>