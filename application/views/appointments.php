<div class="page-name">Appointments</div>

<div class="container">
    <div class="row">
        <div class="apointment-date-hour bg-primary text-center col-lg-offset-6 col-lg-6 col-md-offset-5 col-md-7 col-sm-offset-4 col-sm-8">

            <label for="date">Date: </label>
            <input type="date" id="date" name="date">
            <label for="hour">Hour: </label>
            <input placeholder="10:45" type="text" id="hour" name="hour">
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3 no-float text-center">
            <button type="button" class="btn btn-primary">New Appointment</button><br/><br/>
            <?php
            $total =  count($patients);
            ?>
            <select class="form-control" size="<?=$total?>" multiple="multiple">

                <?php
                    foreach($patients  as $patient)
                    {
                        ?>
                <option value="<?=$patient['id']?>"><?=$patient['name']?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <br/>
                <div class="col-md-9 no-float">
                    <div id = "main-container-messages">
                        <div class= "panel">
                            <?php
                            $count =0;

                            foreach($values as $value)
                            {
                                $description=  $value['description'];
                                $doctor_id =  $value['doctor_id'];
                                $user_id =  $value['user_id'];
                                $private_note =  $value['private_note'];
                                $public_note =  $value['public_note'];
                                $temp =  $value['date_hour'];
                                $temp = explode(' ',$temp);
                                $date = $temp[0];
                                $hour =$temp[1];

                                $state =$value['state'];
                                $color="btn-primary";
                                if($state=="cancelled") {
                                    $color = "btn-danger";
                                    $state= "CANC";
                                }
                                else if ($state=="done"){
                                    $color ="btn-success";
                                    $state= "DONE";
                                }
                                else
                                {
                                    $color ="btn-warning";
                                    $state= "PEND";
                                }

                                ?>
                                <div class="btn-group btn-group-lg header-messages">
                                    <button data-toggle = "collapse" type="button" class="btn btn-default <?=$color?>" data-parent = "#main-container-messages" href = "#message<?=$count?>">
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                        <span class="hidden" send-message-to=""></span>
                                    </button>
                                    <button type="button" class="btn btn-default <?=$color?>">Type</button>
                                    <button type="button" class="btn btn-default <?=$color?>"><?=$state?></button>
                                    <button type="button" class="btn btn-default <?=$color?>"><?=$date?></button>
                                    <button type="button" class="btn btn-default <?=$color?>"><?=$hour?></button>
                                    <button type="button" class="btn btn-default <?=$color?>">Room Number</button>
                                    <button type="button" class="btn btn-default <?=$color?>">
                                        <span class="glyphicon glyphicon-envelope"></span>
                                    </button>

                                </div>


                                <div id = "message<?=$count?>" class = "messages-content collapse <?php if($count==0) echo " in"?>">
                                    <div class="container">
                                        <div class="row">
                                            <div class=" well col-lg-4  col-md-4 col-sm-5  col-xs-10 ">
                                                <div class="text-left">
                                                    <span><b>Private notes:</b></span>
                                                    <span><?=$private_note?></span>
                                                </div>
                                            </div>
                                            <div class="well  col-xs-10 col-lg-4  col-md-4 col-sm-5 hidden-xs" >
                                                <div class="text-left">
                                                    <span><b>Public notes:</b></span>
                                                    <span><?=$public_note?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Visible only in mobile mode-->
                                    <div class="container visible-xs">
                                        <div class="row">
                                            <div class="well col-xs-10 col-lg-4  col-md-4 col-sm-5 " >
                                                <div class="text-left">
                                                    <span><b>Public notes:</b></span>
                                                    <span><?=$public_note?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Visible only in mobile mode-->

                                    <div class="container">
                                        <div class="row">
                                            <h3>Description</h3>
                                            <div class=" well  col-lg-8  col-md-8  col-sm-10  col-xs-10  ">
                                                <div class="text-left">
                                                    <span><b>Description:</b></span>
                                                    <span><?=$description?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End of collapsed information-->
                                <p></p>
                                <?php
                                $count++;
                            }
                            ?>
                        </div>
                    </div>
            </div>
    </div>

</div>


<div class="text-right">
    <button type="button" class="btn-danger">&nbsp;</button><label>Cancelled</label>
    <button type="button" class="btn-success">&nbsp;</button><label>Success</label>
    <button type="button" class="btn-warning">&nbsp;</button><label>Warning</label>
</div>