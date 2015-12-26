<div class="page-name">Messages</div>

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

            if($user_type =="DOCTOR") {
                ?>
                <h2>Patients</h2>
                <select class="form-control" size="<?= $total ?>" multiple="multiple" >

                    <?php
                    foreach ($patients as $patient) {
                        ?>
                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?> </option>
                        <?php
                    }
                    ?>
                </select><br/>

                <?php
            }
            ?>
            <button type="button" class="btn btn-primary" data-toggle = "modal" data-target = "#message">New Message</button><br/><br/>
        </div>

        <div class="col-md-9 no-float">
            <div id = "main-container-messages">
                <div id="all-messages" class= "panel">

                    <?php
                    $count =0;
                    if(empty($messages))
                    {
                        echo "<div class='text-center'>You don't have any messages!</div>";
                    }
                    else
                    {
                        foreach($messages as $message)
                        {


                            $id = $message->getId();
                            $doctor_id = $message->getDoctorId();
                            $user_id = $message->getUserId();
                            $message_text = $message->getText();
                            $temp =  $message->getDateHour();
                            $subject =  $message->getSubject();
                            $messsage_name =  $message->getName(); //Obtain the name of the sender
                            $read_Doctor =  $message->getReadDoctor();
                            $read_User =  $message->getReadUser();
                            $from =  $message->getFrom();


                            $read_message =  $user_type=="DOCTOR" ? ($read_Doctor==true ? "disabled":"") :($read_User==true ? "disabled":"");
                            $read =  $user_type=="DOCTOR" ? $read=$read_Doctor : $read=$read_User;
                            $from =  $from==$user_type ? $name  : $messsage_name;
                            $to=  $from==$name? $messsage_name: $name;

                            $temp = explode(' ',$temp);
                            $date = $temp[0];
                            $hour =$temp[1];

                            ?>
                            <div class="btn-group btn-group-lg btn-group-justified " id="header-messages-<?= $count ?>"
                                 send-message-to="">
                                <div class="btn-group">
                                    <button data-toggle="collapse" id="open-message" message-number="<?=$id?>" type="button" read="<?=$read?>" class="btn btn-default btn-primary <?=$read_message?> "
                                            data-parent="#main-container-messages" href="#messages-<?= $count ?>">
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </button>
                                </div>

                                <div class="btn-group"><input type="button" id="from-message-<?= $count ?>" class="btn btn-default btn-primary <?=$read_message?>" value="<?=$from?>"></div>
                                <div class="btn-group"><input type="button" id="to-message-<?= $count ?>" class="btn btn-default btn-primary <?=$read_message?>" value="<?=$to?>"></div>
                                <div class="btn-group"><input type="button" id="subject-message-<?= $count ?>" class="btn btn-default btn-primary <?=$read_message?>" value="<?=$subject?>"></div>
                                <div class="btn-group"><input type="button" id="date-message" class="date btn btn-default btn-primary <?=$read_message?>" value="<?=$date?>"></div>
                                <div class="btn-group"><input type="button" id="hour-message" class="Hour btn btn-default btn-primary <?=$read_message?>" value="<?=$hour?>"></div>
                            </div>

                            <div id="messages-<?= $count ?>" class="collapse <?php if ($count == 0) echo " in" ?>">
                                <div class="container-fluid">
                                    <div class="row">
                                        <span class="hidden" id="send-message-to"><?= $id ?></span>

                                        <div class=" well  col-lg-12  col-md-12  col-sm-12  col-xs-12  ">
                                            <div class="text-left">
                                                <span><b>From:</b></span>
                                                <span id="edit-description-<?= $count ?>"><?=$from?></span>
                                                <br/>
                                            </div>
                                            <div class="text-left">
                                                <span><b>To:</b></span>
                                                <span id="edit-description-<?= $count ?>"><?=$to?></span>
                                                <br/>
                                            </div>
                                            <div class="text-left">
                                                <span><b>Subject:</b></span>
                                                <span id="edit-description-<?= $count ?>"><?=$subject?></span>
                                            </div>
                                        </div>
                                        <div class=" well  col-lg-12  col-md-12  col-sm-12  col-xs-12  ">
                                            <div class="text-left">
                                                <span><b>Message:</b></span>
                                                <span id="edit-description-<?= $count ?>"><?=$message_text?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- End of collapsed information-->

                            <p></p>
                        <?php
                            $count++;
                        }
                    }?>

                </div>
            </div>
        </div>
    </div>

</div>


