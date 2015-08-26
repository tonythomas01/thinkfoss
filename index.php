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
      <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-66359518-1', 'auto');
          ga('send', 'pageview');

      </script>
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
            <li><a href="#tf-home" class="page-scroll">Home</a></li>
            <li><a href="#tf-about" class="page-scroll">About</a></li>
            <li><a href="#tf-team" class="page-scroll">Team</a></li>
            <li><a href="#tf-services" class="page-scroll">Services</a></li>
            <li><a href="#tf-partners" class="page-scroll">Partners</a></li>
            <li><a href="#tf-contact" class="page-scroll">Contact</a></li>
                  <li>
                          <?php
                          if ( isset( $_SESSION['loggedin_user'] ) ) {
                                  $loggedinUser = $_SESSION['loggedin_user'];
                                  echo "<li> <a>Hi <span style='color: red; font-weight: bold'>$loggedinUser</span></a></li>
                            <li>
                                <form class='form-inline' action = 'php/signOut.php' method = 'post' >
                                    <div class='form-group'>
                                        <button type = 'submit' id = 'member-logout' style='margin-top: 10%' class='btn btn-danger' ><i class='fa fa-sign-out' ></i ></button >
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
                            <button type = 'submit' id = 'member-login' class='btn btn-info' ><i class='fa fa-sign-in' ></i ></button >
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

    <!-- Home Page
    ==========================================-->
    <div id="tf-home" class="text-center">
        <div class="overlay">
            <div class="content">
                <h1>Welcome on <strong>Think<span class="color">FOSS</span></strong></h1>
                <p class="lead"><strong>< code | train | grow ></strong></p>
                </div>
            <br>
                <div>
                <div class="col-xs-6 col-md-4" style="border: solid; padding: 1%">
                        <i style="font-size: 500%" class="fa fa-graduation-cap"></i>
                        <h3> I got skills, <br>I want to earn some <span style="color: gold">$$</span>  out of it!</h3>
                        <a href="#tf-mentor" class="page-scroll">
                            <button class="btn tf-btn btn-primary btn-lg" ><strong>I got skills</strong></button></a>

                </div>
                <div class="col-xs-6 col-md-4" style="border: dashed gold; padding: 1%">
                        <i style="font-size: 500%; color: gold" class="fa fa-star"></i>
                        <h3> I am looking for solutions!<br> Build me one</h3>
                        <a href="#tf-task" class="page-scroll">
                                <button class="btn tf-btn btn-primary btn-lg" style="background-color: gold" ><strong><span style="color: black";>Get Solutions</span></strong></button></a>
                </div>
                <div class="col-xs-6 col-md-4" style="border: solid; padding: 1%">
                     <i style="font-size: 500%" class="fa fa-child"></i>
                     <h3> I am looking for skills!<br> Help me find them</h3>
                     <a href="#tf-mentor" class="page-scroll">
                     <button class="btn tf-btn btn-primary btn-lg" ><strong>I want skills</strong></button></a>
                </div>



                <div style="position: absolute; bottom: 0; width: 100%; background-color: #d58512">
                        <div class="col-xs-12 col-sm-6 col-lg-8" style="text-align: right" >
                                <p style="opacity: 1; font-size: xx-large; font-family: 'Lato', sans-serif">Have you checked out our portal yet ?</p>
                        </div>
                        <div class="col-xs-6 col-lg-4" style="text-align: left; padding-top: 5px">
                                <a href="portal.php"> <button class="btn tf-btn btn-info btn-lg" ><strong>Visit Portal</strong></button></a>
                        </div>
                </div>

                </div>
        </div>
    </div>



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
                        </ul>
                    </div>
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
                                <p>CTO</p>
                                <p>Random Open Source guy and Wikimedian who thinks<br> FOSS is the best</p>
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
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="thumbnail">
                            <img src="img/team/tinaj.jpg" alt="Tina Johnson" class="img-circle team-img">
                            <div class="caption">
                                <h3>Tina Johnson</h3>
                                <p>Systems Programmer</p>
                                <p>Google Summer of Code student with various commits to Mediawiki and Linux Kernel</p>
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
                    <a href="http://phab.thinkfoss.com"><img src="img/newphab.jpg" class="img-responsive"></a>
                </div>
                <div class="col-md-6">
                    <div class="about-text">
                        <div class="section-title">
                            <h4>Submit your task</h4>
                            <h2>How to get <strong>Serviced</strong></h2>
                            <hr>
                            <div class="clearfix"></div>
                        </div>
                        <p class="intro">ThinkFOSS is happy to use <a href="http://phabricator.org/" target="_blank">Phabricator</a> for
                        its client satisfaction. To get started with our services, you will have to create an account in our Phabricator instance
                        at <a href="http://phab.thinkfoss.com" target="_blank">phab.thinkfoss.com</a>. You can find basic help with Phabricator<a href="https://www.mediawiki.org/wiki/Phabricator/Help" target="_blank"> here.</a> </p>
                        <ol class="task-list">
                            <li>
                                <span class="fa fa-flask"></span>
                                <strong>Register</strong> - <em>Register with your E-mail id at phab.thinkfoss.com</em>
                            </li>
                            <li>
                                <span class="fa fa-pencil-square-o"></span>
                                <strong>Create a task</strong> - <em>Create a task with your requirements, and play around as far as
                            you want</em>
                            </li>
                            <li>
                                <span class="fa fa-coffee"></span>
                                <strong>Grab a coffee </strong> - <em> Wait for moments until one of us contact you with the same</em>
                            </li>

                        </ol> <br>
                        <a href="http://phab.thinkfoss.com" target="_blank"  class="page-scroll"><button class="btn tf-btn btn-center" >Take me to Phab</button></a>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Testimonials Section
    ==========================================-->
    <div id="tf-partners" class="text-center">
        <div class="overlay">
            <div class="container">
                <div class="section-title center">
                    <h2>Our <strong> Partners</strong></h2>
                    <div class="line">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="partner" class="owl-carousel owl-theme">
                            <div class="item">
                                <a href="http://amritafoss.in" target="_blank">
                                    <img src="img/partners/fosswhite.png">
                                    <h3>FOSS@Amrita</h3>
                                </a>
                            </div>
                            <div class="item">
                                <a href="http://init-labs.org/" target="_blank">
                                    <img src="img/partners/initlabs.png">
                                    <h3>Init-Labs</h3>
                                </a>
                            </div>
                            <div class="item">
                                <a href="http://amrita.edu" target="_blank">
                                    <img src="img/partners/amrita.png">
                                    <h3>Amrita Vishwa Vidyapeetham</h3>
                                </a>
                            </div>

                            <div class="item">
                                <a href="http://nodeschool.io/kerala" target="_blank">
                                    <img src="img/partners/nodeschool.png">
                                    <h3>NodeSchool Kerala</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tf-mentor">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="section-title">
                        <h2>Why you should <strong>Mentor</strong></h2>
                        <hr>
                        <div class="clearfix"></div>
                    </div>
                    <p class="intro"> Mentoring is one of the key process in Open Source Software developmenet, and ThinkFOSS
                    aims at providing the best mentoring available to the needy in a complete transparant transaction.
                    </p> <br>
                    <h2>How it Works ?</h2>
                    <ul class="mentor-list">
                        <li>
                            <span class="fa fa-hand-o-right"></span>
                            <strong>Register as a Mentor</strong> - <em>Register as a mentor using the form on the right.
                            You can type in what you will be teaching in the
                        'I will teach' text box. You can add more courses later. </em>
                        </li>
                        <li>
                            <span class="fa fa-clock-o"></span>
                            <strong>Wait for verification</strong> - <em> Wait till we verify your profile, and show up your contribution
                        among the 'Available courses' </em>
                        </li>
                        <li>
                            <span class="fa fa-dollar"></span>
                            <strong>Collect your money</strong> - <em> Once we have a student enrolling to your course, the fee you proposed
                        will get transferred to your bank. </em>
                        </li>

                    </ul>
                    <h3>Already a member ?</h3>
                        <ul class="mentor-list">
                                <li><span class="fa fa-sign-in"></span>
                                <strong>Sign in </strong> to your portal to manage your preferences
                                </li>


                </div>

                <div class="col-md-6">
                    <div class="section-title">
                        <h2>Be a <strong>Mentor</strong></h2>
                        <hr>
                        <div class="clearfix"></div>
                    </div>

                        <?php
                        if ( isset( $_SESSION['loggedin_user'] ) ) {
                                echo "<p class='intro'> Looks like you are Logged In. Its time to visit your Portal! You can add in more course, change your
                                personal settings and do a lot more once you are inside the portal. <br><br>
                                 <h2>What to do now ?</h2>
                                    <ul class='mentor-list'>
                                        <li>
                                            <span class='fa fa-sign-in'></span>
                                            <strong>Get inside your portal</strong> - <em> The portal allows you to add/remove/edit your mentoring preferences. Keep an
                                             eye out for it</em>
                                        </li>
                                        <li>
                                            <span class='fa fa-plus'></span>
                                            <strong>Add in new courses</strong> - <em> You can Add in more courses which you would like to take upon once you are inside the
                                             portal.</em>
                                        </li>
                                        <li>
                                            <span class='fa fa-phone'></span>
                                            <strong>Contact one of us</strong> - <em> In case you find something difficult, use one of the contact options listed to get support</em>
                                        </li>
                                                  <li>
                                            <span class='fa fa-bug'></span>
                                            <strong>Found a bug ?</strong> - <em> Report immediately to one of the admins, or file it as a task in our <a href='http://phab.thinkfoss.com'
                                             target='_blank'> Phabricator</a></em>
                                        </li>

                                    </ul><br>
                                     <a href='portal.php' class='page-scroll'><button class='btn tf-btn btn-center' >Take me to my Portal</button></a>
                                ";
                        } else { echo "

                    <form class='form-inline' action='php/mentorEnroll.php' method='post'>
                        <div class='form-group'>

                            <label class='sr-only' for='mentor_name'>Your Name</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-user'></i></div>
                                <input required type='text'   class='form-control' id='mentor_name' name='mentor_name' placeholder='Your Name'>
                            </div>

                            <label class='sr-only' for='mentor_email'>Your Email</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-envelope'></i></div>
                                <input required type='email'  class='form-control' id='mentor_email'  name='mentor_email' placeholder='Your Email id'>
                            </div>
                            <br> <br>
                            <label class='sr-only' for='mentor_pass_once'>Password</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-eye'></i> </div>
                                <input required type='password'  class='form-control' id='mentor_pass_once' name='mentor_pass_once' placeholder='Password'>
                            </div>
                            <label class='sr-only' for='mentor_pass_again'>Again </label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-eye'></i></div>
                                <input required type='password' class='form-control' id='mentor_pass_again' name='mentor_pass_again' placeholder='Password again'>
                            </div>
                            <br> <br>
                            <label class='sr-only' for='mentor_github'>Github</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-github'></i></div>
                                <input required type='text' class='form-control' id='mentor_github'  name='mentor_github' placeholder='Github profile'>
                            </div>
                            <label class='sr-only' for='mentor_linkedin'>LinkedIn</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-linkedin'></i></div>
                                <input required type='text'  class='form-control' id='mentor_linkedin'  name='mentor_linkedin' placeholder='LinkedIn profile'>
                            </div>
                            <br><br>

                            <label class='sr-only' for='mentor_bio'>Short Bio</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-book'></i></div>
                                <textarea required rows='4' cols='100' class='form-control' id='mentor_bio'  name='mentor_bio' placeholder='I tried pushing 3 patchsets to a proprietary software in 3 minutes, and failed miserably'></textarea>
                            </div>

                            <br><br>
                            <label class='sr-only' for='mentor_skills-1'>I will teach</label>
                            <div class='input-group' id='mentor-skills-wrapper'>
                                <div class='input-group-addon'>I will teach</div>
                                <input required  type='text' size='100%' class='form-control' id='mentor_skills-1' name='mentor_skills-1' placeholder='Give a stylish name for your course'>
                            </div>
                            <br>
                            <small><em>Want to add more ?You can add in more once you sign-up</em></small><br><br>
                            <label class='sr-only' for='mentor_date_to'>Date from</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><strong>From</strong></div>
                                <input required type='date' class='form-control' id='mentor_date_from' name='mentor_date_from' placeholder='Available Date'>
                            </div>
                            <label class='sr-only' for='mentor_date_to'>Time from</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-clock-o'></i></div>
                                <input required type='time' class='form-control' id='mentor_time_from' name='mentor_time_from' placeholder='Available Time'>
                            </div>

                            <br><br>

                            <label class='sr-only' for='mentor_date_to'>Date To</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><strong>To &nbsp; &nbsp;&nbsp;</strong></div>
                                <input required type='date' class='form-control' id='mentor_date_to' name='mentor_date_to' placeholder='Available Date'>
                            </div>
                            <label class='sr-only' for='mentor_time_to'>Time to</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-clock-o'></i></div>
                                <input required type='time'  class='form-control' id='mentor_time_to' name='mentor_time_to' placeholder='Available Time'>
                            </div> <br><br>
                            <label class='sr-only' for='mentor_amount'>Amount</label>
                            <div class='input-group'>
                                <div class='input-group-addon'><i class='fa fa-rupee'></i> </div>
                                <input required type='number' class='form-control' id='mentor_amount'  name='mentor_amount' placeholder='Charge'>
                            </div>
                            <button type='submit' class='btn btn-primary'>Sign Up</button>
                        </div>
                    </form>
                    "; } ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section
    ==========================================-->
    <div id="tf-contact" class="text-center" style="background-color: seashell">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <div class="section-title center">
                        <h2>Feel free to <strong>contact us</strong></h2>
                        <div class="line">
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                        <small><em>Please drop in a mail to hire us for your need</em></small>
                    </div>

                    <form action="http://formspree.io/tony@thinkfoss.com" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="_replyto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Your Name</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Your Name" name="name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Message</label>
                            <textarea class="form-control" rows="3" name="message" id="message"></textarea>
                        </div>
                        
                        <button type="submit" class="btn tf-btn btn-right">Submit</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <nav id="footer">
        <div class="container">
            <div class="pull-left fnav">
                <p>ALL RIGHTS RESERVED. COPYRIGHT © 2015. Designed and Maintained by <a href="http://foss.amrita.ac.in" target="_blank">FOSS@Amrita</a>
            </div>
            <div class="pull-right fnav">
                <ul class="footer-social">
                    <li><a href="http://facebook.com/thinkfoss" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="https://twitter.com/thinkfoss"><i class="fa fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>


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