<div class="page-name" id="appointment">Appointments</div>

<div class="container">
    <div class="row">
        <div class="appointment-date-hour  text-center col-lg-offset-6 col-lg-6 col-md-offset-4 col-md-8 col-sm-offset-2 col-sm-10">
            <label for="date">Start Date: </label>
            <input type="date" id="date" name="date">
            <div class="visible-xs"><br/></div>
            <label for="hour">Hour: </label>
            <input placeholder="10:45" type="text" id="hour" name="hour">
            <div class="visible-xs"><br/></div>
            <button id="search-appointments" type="button" class="btn btn-primary ">Search</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
       <?php
            $total =  count($patients);
           $layout ="col-lg-12 col-md-12 col-xs-12";
           if($user_type =="DOCTOR") {
            $layout ="col-md-8";
                ?>
        <div class="col-md-3 no-float text-center">
                <h2>Patients</h2>
                <select class="form-control" >

                    <?php
                    foreach ($patients as $patient) {
                        ?>
                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?> </option>
                        <?php
                    }
                    ?>
                </select><br/>
            <button type="button" class="btn btn-primary" data-toggle = "modal" data-target = "#appointments">New Appointment</button><br/><br/>

        </div>

        <?php
            }
            else
            {
                ?>
                <button type="button" class="btn btn-primary center-block" data-toggle = "modal" data-target = "#appointments">New Appointment</button><br/><br/>

                <?php
            }
       ?>

        <div class="<?=$layout?> no-float">
            <div id = "main-container-messages">
                <div id="all-messages" class= "panel">
                    <br>
                    <!--preview bar-->
                    <div class="btn-group btn-group-lg btn-group-justified ">
                        <div class="btn-group">
                            <button data-toggle="collapse" type="button" class="btn btn-default btn-info"
                                    data-parent="#main-container-plans">
                                <span class="">Open </span>
                            </button>
                        </div>
                        <div class="btn-group hidden-xs">
                            <button type="button" class="btn btn-default btn-info">Type</button>
                        </div>
                        <div class="btn-group hidden-xs">
                            <button type="button" class="btn btn-default btn-info">State</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-info">Day</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-info">Hour</button>
                        </div>

                        <?php
                        if($user_type=="DOCTOR")
                        {

                        ?>
                        <div class="btn-group hidden-xs">
                            <button type="button" class="btn btn-default btn-info">Room</button>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    $count =0;

                    if(empty($appointments))
                    {
                        echo "<div class='text-center'>You don't have any appointments!</div>";
                    }
                    else
                    {
                        foreach($appointments as $appointment)
                        {

                            //Color and states
                            $state =$appointment->getState();
                            $color="btn-primary";
                            if($state=="cancelled") {
                                $color = "btn-danger";
                                $state= "CANC";
                            }
                            else if ($state=="done"){
                                $color ="btn-success";
                                $state= "DONE";
                            }
                            else if($state=="pending")
                            {
                                $color ="btn-warning";
                                $state= "PEND";
                            }
                            else if($state=="waiting")
                            {
                                $color ="btn-primary disabled";
                                $state= "WAIT";
                            }


                            //Other information about the appointment
                            $id=  $appointment->getId();
                            $description= $appointment->getDescription();
                            $doctor_id =  $appointment->getDoctorId();
                            $user_id =  $appointment->getUserId();
                            $private_note =  $appointment->getPrivateNote();
                            $public_note =  $appointment->getPublicNote();
                            $temp =  $appointment->getDateHour();
                            $type =  $appointment->getType();

                            //Separate hour and date
                            $temp = explode(' ',$temp);
                            $date = $temp[0];
                            $hour =$temp[1];

                            if($user_type =="DOCTOR")
                            {
                                ?>
                                <div class="btn-group btn-group-lg btn-group-justified " id="header-messages-<?= $count ?>" send-appointment-id="<?=$id?>">
                                    <div class="btn-group">
                                        <button data-toggle="collapse" type="button" class="btn btn-default <?= $color ?>"
                                                data-parent="#main-container-messages" href="#messages-<?= $count ?>">
                                            <span class="glyphicon glyphicon-chevron-down"></span>
                                        </button>
                                    </div>

                                    <div class="btn-group hidden-xs"><input type="button" id="type"
                                                                  class="btn btn-default <?= $color ?>"
                                                                  value="<?= $type ?>"></div>
                                    <div class="btn-group hidden-xs"><input type="button" id="state-messages-<?=$count?>"
                                                                  class="btn btn-default <?= $color ?>"
                                                                  value="<?= $state ?>"></div>
                                    <div class="btn-group"><input type="button" id="date-message"
                                                                  class="date btn btn-default <?= $color ?>"
                                                                  value="<?= $date ?>"></div>
                                    <div class="btn-group"><input type="button" id="hour-message"
                                                                  class="btn btn-default <?= $color ?>"
                                                                  value="<?= $hour ?>"></div>
                                    <div class="btn-group hidden-xs"><input type="button" class="btn btn-default <?= $color ?>"
                                                                  value="<?=$room_number?>"></div>
                                    <div class="btn-group hidden">
                                        <button type="button" class="btn btn-default <?= $color ?>">
                                            <span class="glyphicon glyphicon-envelope"></span>
                                        </button>
                                    </div>

                                </div>

                                <div id="messages-<?= $count ?>" class="collapse <?php if ($count == 0) echo " in" ?>">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <span class="hidden" id="send-appointment-id"><?=$id?></span>
                                            <div class=" well  col-lg-12  col-md-12  col-sm-12  col-xs-12  ">
                                                <div class="text-left">
                                                    <span><b>Description:</b></span>
                                                <span id="edit-description-<?= $count ?>">
                                                    <input type="text" class="hidden" value="<?= $description ?>" id="description-<?= $count ?>">
                                                    <span value="<?= $description ?>" id="description-<?= $count ?>"><?= $description ?></span>
                                                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-description-<?= $count ?>" value="description-<?= $count ?>"></span>
                                                    <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-description-<?= $count ?>" value="description-<?= $count ?>" id="save"></span>
                                                    <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-description-<?= $count ?>" value="description-<?= $count ?>" id="remove"></span><br/>

                                                    <span><b>Type:</b></span>
                                                <span>
                                                    <span><?= $type ?></span>
                                                </span><br/>
                                                     <span><b>Room Number:</b></span>
                                                <span>
                                                    <span><?= $room_number ?></span>
                                                </span>
                                                </div>
                                            </div>

                                            <h3>Notes</h3>

                                            <div class=" well col-lg-6  col-md-6 col-sm-6  col-xs-12 ">
                                                <div class="text-left ">
                                                    <span><b>Private notes:</b></span>
                                                <span id="edit-private_note-<?= $count ?>">
                                                    <input type="text" class="hidden" value="<?= $private_note ?>" id="private_note-<?= $count ?>">
                                                    <span value="<?= $private_note ?>" id="private_note-<?= $count ?>"><?= $private_note ?></span>
                                                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-private_note-<?= $count ?>" value="private_note-<?= $count ?>"></span>
                                                    <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-private_note-<?= $count ?>" value="private_note-<?= $count ?>" id="save"></span>
                                                    <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-private_note-<?= $count ?>" value="private_note-<?= $count ?>" id="remove"></span>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="well  col-lg-6  col-md-6 col-sm-6  col-xs-12">
                                                <div class="text-left ">
                                                    <span><b>Public notes:</b></span>
                                                <span id="edit-public_note-<?= $count ?>">
                                                    <input type="text" class="hidden" value="<?= $public_note ?>" id="public_note-<?= $count ?>">
                                                    <span value="<?= $public_note ?>" id="public_note-<?= $count ?>"><?= $public_note ?></span>
                                                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-public_note-<?= $count ?>" value="public_note-<?= $count ?>"></span>
                                                    <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-public_note-<?= $count ?>" value="public_note-<?= $count ?>" id="save"></span>
                                                    <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-public_note-<?= $count ?>" value="public_note-<?= $count ?>" id="remove"></span>
                                                </span>
                                                </div>
                                            </div>
                                            <div class=" well  col-lg-12  col-md-12  col-sm-12  col-xs-12  ">
                                                <div class="text-left">
                                                    <p><span><b>Sate:</b></span>
                                                        Pending <input type="radio" name="state-<?= $count ?>" id="state-<?= $count ?>" value="pending" <?php if($state=="PEND") echo"checked";?>>
                                                        Done <input type="radio" name="state-<?= $count ?>" id="state-<?= $count ?>" value="done" <?php if($state=="DONE") echo"checked";?>>
                                                        Cancelled <input type="radio" name="state-<?= $count ?>" id="state-<?= $count ?>" value="cancelled" <?php if($state=="CANC") echo"checked";?>>
                                                        Waiting <input type="radio" name="state-<?= $count ?>" id="state-<?= $count ?>" value="waiting" <?php if($state=="WAIT") echo"checked";?>>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End of collapsed information-->
                                <p></p>

                                <?php
                            }
                            else
                            {
                                ?>
                                <!-- If is the patient -->
                                <div class="btn-group btn-group-lg btn-group-justified " id="header-messages-<?= $count ?>">
                                    <div class="btn-group">
                                        <button data-toggle="collapse" type="button" class="btn btn-default <?= $color ?>"
                                                data-parent="#main-container-messages" href="#messages-<?= $count ?>">
                                            <span class="glyphicon glyphicon-chevron-down"></span>
                                            <span class="hidden" send-id-to=""></span>
                                        </button>
                                    </div>

                                    <div class="btn-group hidden-xs"><input type="button" id="type"
                                                                  class=" btn btn-default <?= $color ?>"
                                                                  value="<?= $type ?>"></div>
                                    <div class="btn-group hidden-xs"><input type="button" id="state-messages-<?=$count?>"
                                                                  class="btn btn-default <?= $color ?>"
                                                                  value="<?= $state ?>"></div>
                                    <div class="btn-group"><input type="button" id="date-message"
                                                                  class="date btn btn-default <?= $color ?>"
                                                                  value="<?= $date ?>"></div>
                                    <div class="btn-group"><input type="button" id="hour-message"
                                                                  class="btn btn-default <?= $color ?>"
                                                                  value="<?= $hour ?>"></div>
                                    <div class="btn-group hidden"><input type="button" class="btn btn-default <?= $color ?>"
                                                                  value="Room"></div>
                                    <div class="btn-group hidden">
                                        <button type="button" class="btn btn-default <?= $color ?>">
                                            <span class="glyphicon glyphicon-envelope"></span>
                                        </button>
                                    </div>

                                </div>

                                <div id="messages-<?= $count ?>" class="collapse <?php if ($count == 0) echo " in" ?>">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class=" well  col-lg-12  col-md-12  col-sm-12  col-xs-12  ">
                                                <div class="text-left">
                                                    <span><b>Description:</b></span>
                                                    <span class="edit-description"><?= $description ?></span><br/>
                                                    <span><b>Type:</b></span>
                                                <span id="edit-description-<?= $count ?>">
                                                    <span value="<?= $type ?>" id="description-<?= $count ?>"><?= $type ?></span>
                                                </div>
                                            </div>

                                            <h3>Notes</h3>

                                            <div class="well  col-xs-12 col-lg-12  col-md-12 col-sm-12">
                                                <div class="text-left ">
                                                    <span class="edit-private-public"><?= $public_note ?></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div> <!-- End of collapsed information-->
                                <p></p>
                                <!--PAtient information-->
                                <?php
                            }
                            $count++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="text-right">
    <button type="button" class="btn btn-danger btn-xs">&nbsp;&nbsp;&nbsp;</button><label>&nbsp;CANCELLED</label>
    <button type="button" class="btn btn-primary btn-xs disabled">&nbsp;&nbsp;&nbsp;</button><label>&nbsp;WAITING</label>
    <button type="button" class="btn btn-success btn-xs">&nbsp;&nbsp;&nbsp;</button><label>&nbsp;DONE</label>
    <button type="button" class="btn btn-warning btn-xs">&nbsp;&nbsp;&nbsp;</button><label>&nbsp;PENDING</label>
</div>