<!-- navigation bar for logged user-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ActChange</title>
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.css">
   <!--<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap_material.css">-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/index.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/animate.css">
</head>
<body>

<div class="nav navbar-default" role="navigation">
    <div class="navbar-header">
        <!-- mobile menu button-->
        <button type="button" class="navbar-toggle" data-target="#navbar1" data-toggle="collapse">
            <span class="icon-bar sr-only">Toggle NavBar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="profile"><img src="<?=base_url()?>assets/images/logo.png"></a>
    </div><!-- end of header navbar  (this contains the brand and the collapse button for the mobile version-->

    <div class="collapse navbar-collapse" id="navbar1" >
<!----------------------Left navbar----------------------------------->
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a  href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true" aria-haspopup="true" id="dropdown_appointment">Appointment
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-pages">
                    <li><a href="#">Book</a></li>
                    <li><a href="#">Check</a></li>
                </ul>
            </li>
            <li ><a href="#">Statistics</a></li>

            <!-- Messages dropdown-->
            <li class="dropdown">
                <a  href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true" aria-haspopup="true" id="dropdown_messages">Messages
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-pages">
                    <li><a href="#">New</a></li>
                    <li><a href="#">Check</a></li>
                </ul>
            </li>
            <?php
            if($_SESSION['user_type']=='Doctor') {
                ?>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true" aria-haspopup="true"
                       id="dropdown_messages">Users
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-pages">
                        <li><a href="<?=base_url()?>register">Register</a></li>
                    </ul>
                </li>
                <?php
            }

            ?>
            <li ><a href="#">Plan</a></li>
        </ul><!-- end of left navbar-->
        <!------------------------------right navbar---------------------------->
        <ul class="nav navbar-nav navbar-right">
            <!-- NavBar send messages-->
            <li>
                <a href="<?=base_url()?>messages"> <span class="glyphicon glyphicon-envelope"></span></a>
            </li>

            <li>
                <a href="<?=base_url()?>settings"> <span class="glyphicon glyphicon-cog"></span></a>
            </li>
            <!-- user  dropdown-->
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true" aria-haspopup="true" id="dropdown_settings">
                    <img class="img-circle user-nav-photo"  src="<?=base_url()?>assets/images/profile/<?=$photo_url?>"><span class="user-nav-photo"> <?=$_SESSION['name']?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-pages">
                    <li><a href="<?=base_url()?>profile">Profile</a></li>
                    <li><a href="<?=base_url()?>logout">Logout</a></li>
                </ul>
            </li>
            <!-- user image -->


        </ul><!-- end of right navBar-->

    </div> <!-- navbar content end-->
</div> <!-- close navbar-->


