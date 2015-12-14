<div class="page-name">Appointments</div>

<div class="container">
    <div class="row">
        <div class="appointment-date-hour  text-center col-lg-offset-6 col-lg-6 col-md-offset-4 col-md-8 col-sm-offset-2 col-sm-10">
            <label for="date">Start Date: </label>
            <input type="date" id="date" name="date">
            <label for="hour">Hour: </label>
            <input placeholder="10:45" type="text" id="hour" name="hour">
            <button id="search-appointments" type="button" class="btn btn-primary ">Search</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3 no-float text-center">

            <?php
            $total =  count($patients);
            ?>
            <h2>Patients</h2>
            <select class="form-control" size="<?=$total?>" multiple="multiple">

                <?php
                foreach($patients  as $patient)
                {
                    ?>
                    <option value="<?=$patient['id']?>"><?=$patient['name']?></option>
                    <?php
                }
                ?>
            </select><br/>
            <button type="button" class="btn btn-primary" data-toggle = "modal" data-target = "#appointments">New Appointment</button><br/><br/>
            <!-- Modal -->
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
        </div>

        <div class="col-md-9 no-float">
            <div id = "main-container-messages">
                <div id="all-messages" class= "panel">
                    <?php
                    $count =0;

                    foreach($values as $value)
                    {

                        $id=  $value['id'];
                        $description=  $value['description'];
                        $doctor_id =  $value['doctor_id'];
                        $user_id =  $value['user_id'];
                        $private_note =  $value['private_note'];
                        $public_note =  $value['public_note'];
                        $temp =  $value['date_hour'];
                        $type =  $value['type'];
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
                        <div class="btn-group btn-group-lg btn-group-justified " id="header-messages-<?=$count?>">
                            <div class="btn-group"><button data-toggle = "collapse" type="button" class="btn btn-default <?=$color?>" data-parent = "#main-container-messages" href = "#messages-<?=$count?>">
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                    <span class="hidden" send-message-to=""></span>
                                </button>
                            </div>

                            <div class="btn-group"><input type="button" id="type" class="btn btn-default <?=$color?>"  value="<?=$type?>"></div>
                            <div class="btn-group"> <input type="button" id="state-messages-messages" class="btn btn-default <?=$color?>" value="<?=$state?>"></div>
                            <div class="btn-group"> <input type="button" id="date-messages" class="date btn btn-default <?=$color?>" value="<?=$date?>"></div>
                            <div class="btn-group"><input type="button" id="hour-messages" class="btn btn-default <?=$color?>" value="<?=$hour?>"></div>
                            <div class="btn-group"><input type="button" class="btn btn-default <?=$color?>" value="Room"></div>
                            <div class="btn-group"> <button type="button" class="btn btn-default <?=$color?>">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </button></div>

                        </div>

                        <div id = "messages-<?=$count?>" class = "collapse <?php if($count==0) echo " in"?>">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class=" well  col-lg-12  col-md-12  col-sm-12  col-xs-12  ">
                                        <div class="text-left">
                                            <span><b>Description:</b></span>
                                            <span class="edit-description"><?=$description?></span>
                                            <span id="edit-description" class="text-right glyphicon glyphicon-edit text-right"></span>
                                        </div>
                                    </div>

                                    <h3>Notes</h3>
                                    <div class=" well col-lg-6  col-md-6 col-sm-6  col-xs-12 ">
                                        <div class="text-left ">
                                            <span><b>Private notes:</b></span>
                                            <span class="edit-private-notes"><?=$private_note?></span>
                                            <span class="text-right glyphicon glyphicon-edit text-right"></span>
                                        </div>
                                    </div>
                                    <div class="well  col-xs-12 col-lg-6  col-md-6 col-sm-6 hidden-xs" >
                                        <div class="text-left ">
                                            <span><b>Public notes:</b></span>
                                            <span class="edit-private-public"><?=$public_note?></span>
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