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
                    <li><a data-toggle = "modal" data-target = "#appointments" href="">New</a></li>
                    <li><a href="<?=base_url()?>appointments">View all</a></li>
                </ul>
            </li>
            <li ><a href="<?=base_url()?>statistics">Statistics</a></li>

            <!-- Messages dropdown-->
            <li class="dropdown">
                <a  href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true" aria-haspopup="true" id="dropdown_messages">Messages
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-pages">
                    <li><a data-toggle = "modal" data-target = "#message" href="">New</a></li>
                    <li><a href="<?=base_url()?>messages">View All</a></li>
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
            <li ><a href="<?=base_url()?>plan">Plan</a></li>
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




<!-- pop-up for new appointment -->
<div class = "modal fade" id = "appointments" tabindex = "-1" role = "dialog"
     aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>

                <h4 class = "modal-title" id = "myModalLabel">
                    Book Appointment
                </h4>
            </div>

            <div class = "modal-body text-left">
                <p><label for="description">Description: </label>
                    <input type="text" id="description" name="description"></p>
                <p><label for="type">Type: </label>
                    <input type="text" id="type" name="type"></p>
                <p> <label for="date">Start Date: </label>
                    <input type="date" id="date" name="date">
                    <label for="hour">Hour: </label><input placeholder="10:45" type="text" id="hour" name="hour"></p>
                <p ><label>Room Number: </label></p>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                    Close
                </button>

                <button type = "button" class = "btn btn-primary">
                    Submit changes
                </button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<!-- pop-up for new Message -->
<div class = "modal fade" id = "message" tabindex = "-1" role = "dialog"
     aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>

                <h4 class = "modal-title" id = "myModalLabel">
                    New Message
                </h4>
            </div>

            <div class = "modal-body text-left">
                <p><label for="description">Subject: </label>
                    <input type="text" id="subject" name="subject"></p>
                    <textarea type="text" id="content" name="content"></textarea></p>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                    Close
                </button>

                <button type = "button" class = "btn btn-primary">
                    Submit changes
                </button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->


