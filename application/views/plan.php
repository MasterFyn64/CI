<div id="plan" class="page-name">Plan</div>
<!-- Modal -->
<div class = "modal fade" id = "remove-plan" tabindex = "-1" role = "dialog"
     aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>

                <h4 class = "modal-title" id = "myModalLabel">
                    Remove Plan
                </h4>
            </div>

            <div class = "modal-body">
                <label>Are you sure that you want to remove this plan ?</label>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                    Cancel
                </button>
                <button plan-id="" form="remove-plan" type = "submit" class = "btn btn-primary">
                    Remove
                </button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Add exercise pop-up -->
<div class = "modal fade" id = "add-exercise" tabindex = "-1" role = "dialog"
     aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>

                <h4 class = "modal-title" id = "myModalLabel">
                    Add Exercise
                </h4>
            </div>

            <div class = "modal-body">
                <?php
                $attributes = array( 'id' => 'add-exercises');
                echo form_open_multipart('plan/addExercise',$attributes);?>
                <input type="text" value="" name="planID" id="planID" class="hidden">
                <div class="form-group">
                    <label class="" for="repetitions">Exercise: </label>
                    <select class="form-control" name="choose-exercise">
                        <option value="select-exercise">Select one</option>
                        <option value="insert-exercise">Insert one</option>
                    </select><br>
                    <select id="select-exercise" class="form-control" name="chosenExercise[]" multiple="multiple" size="<?=count($defined_exercises)?>">
                        <?php
                        foreach($defined_exercises as $one_exercise)
                        {
                        ?>
                        <option value="<?=$one_exercise['id']?>"><?=$one_exercise['name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                   <div id="insert-exercise" class="hidden">
                       <div class="form-group">
                           <label class="" for="exercise-name">Name: </label>
                           <input class="form-control" id="exercise-name" name="exercise-name" type="text">
                       </div>
                       <div class="form-group">
                           <label class="" for="exercise-description">Description: </label>
                           <input class="form-control" id="exercise-description" name="exercise-description" type="text">
                       </div>
                       <hr/>
                   </div>

                </div>
                <div class="form-group">
                    <label class="" for="repetitions">Repetitions: </label>
                    <input class="form-control" id="repetitions" name="repetitions" type="number">
                </div>
                <div class="form-group">
                    <label class="" for="duration">Duration: </label>
                    <input class="form-control" id="duration" name="duration" type="number">
                </div>
                <div class="form-group">
                    <label class="" for="duration">Days: </label>
                    <select class="form-control" multiple="multiple" name="days[]" size="7">
                        <option value="sunday">Sunday</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                    </select>
                </div>

                </form>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                    Cancel
                </button>

                <button type = "submit" form="add-exercises"  class = "btn btn-primary">
                    Add Exercise
                </button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id = "main-container-plans">
                <div id="all-plans" class= "panel">
                    <div class="col-lg-offset-8 col-lg-3 col-md-offset-9 col-md-2 col-sm-offset-8  col-sm-3 col-xs-12">
                        <?php
                        if($user_type=="DOCTOR")
                        {?>
                            <!-- Modal -->
                            <div class = "modal fade" id = "newplan" tabindex = "-1" role = "dialog"
                                 aria-labelledby = "myModalLabel" aria-hidden = "true">
                                <div class = "modal-dialog">
                                    <div class = "modal-content">
                                        <div class = "modal-header">
                                            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                                                &times;
                                            </button>
                                            <h4 class = "modal-title" id = "myModalLabel">
                                                New Plan
                                            </h4>
                                        </div>
                                        <div class = "modal-body">
                                            <?php
                                            $attributes = array( 'id' => 'addplan');
                                            echo form_open_multipart('plan/insert',$attributes);?>
                                            <div class="form-group">
                                                <label class="" for="start-date">Description: </label>
                                                <input class="form-control" id="description" name="description" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="" for="start-date">Start Date: </label>
                                                <input class="form-control" id="start-date" name="start-date" type="date">
                                            </div>
                                            <div class="form-group">
                                                <label class="" for="start-date">End Date: </label>
                                                <input class="form-control" id="end-date" name="end-date" type="date">
                                            </div>
                                            <div class="form-group">
                                                <label class="" for="patient-id">Patient: </label>
                                                <select class="form-control" name="patient" >
                                                    <?php
                                                    foreach ($patients as $patient) {
                                                        ?>
                                                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            </form>
                                        </div>
                                        <div class = "modal-footer">
                                            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                                                Close
                                            </button>
                                            <button form="addplan" type = "submit" class = "btn btn-primary">
                                                Add Plan
                                            </button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <div class="pull-right  hidden-xs text-center "">
                                <select class="form-control" id="select-patient" >
                                    <option value="all">All</option>
                                    <?php
                                    foreach ($patients as $patient) {
                                        ?>
                                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="visible-xs text-center">
                                <select class="form-control" id="select-patient">
                                    <option value="all">All</option>
                                    <?php
                                    foreach ($patients as $patient) {
                                        ?>
                                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php
                        }?>
                    </div>
                    <br><br>
                    <?php
                    if($user_type=="DOCTOR") {
                        ?>
                        <div class="text-center">
                            <button class="btn btn-primary " data-toggle="modal" data-target="#newplan">
                                New Plan
                            </button>
                            <br><br>
                        </div>
                        <?php
                    }
                    ?>
                     <!--preview bar-->
                    <div class="btn-group btn-group-lg btn-group-justified ">
                        <div class="btn-group">
                            <button data-toggle="collapse" type="button" class="btn btn-default btn-info"
                                    data-parent="#main-container-plans">
                                <span class="">Open </span>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-info">Start Date</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-info">End Date</button>
                        </div>
                        <?php
                        if($user_type=="DOCTOR")
                        {
                            ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-info">Delete</button>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    $count =0;
                    $day_name = array("S","M","T","W","T","F","S");
                    $plan_position=0;

                    if(empty($plans))
                    {
                        echo "<div class='text-center'>You don't have any Plans!</div>";
                    }
                    else
                    {

                        foreach ($plans as $plan)
                        {
                            //reset variables
                            $duration_first = "";
                            $repetitions_first = "";
                            $days_first = "0-0-0-0-0-0-0";
                            $days_first = explode("-", $days_first);
                            $days_first = array_diff($days_first, array("-")); //remove all "-"
                            $name_first = "";
                            $position_first="";
                            $description_first = "";
                            $first_id="";
                            ?>
                            <div class="btn-group btn-group-lg btn-group-justified" id="header-plan-<?= $plan_position ?>">
                                <span class="hidden" user-id="<?=$plan['plan']['user_id']?>"></span>
                                <div class="btn-group">
                                    <button data-toggle="collapse" type="button" class="btn btn-default btn-primary"
                                            data-parent="#main-container-plans" href="#plan-<?= $plan_position ?>">
                                        <span class="">&nbsp;<span class="glyphicon glyphicon-chevron-down"></span> </span>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-primary"><?=$plan['plan']['start_date']?></button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-primary"><?=$plan['plan']['end_date']?></button>
                                </div>

                            <?php
                            if ($user_type == "DOCTOR")
                            {?>
                                <div class="btn-group">
                                    <button  data-target="#remove-plan" data-toggle="modal" type="button" plan-id="<?=$plan['plan']['id']?>" class="btn btn-default btn-danger">x</button>
                                </div>
                            </div>

                        <div id="plan-<?= $plan_position ?>" class="collapse <?php if ($plan_position == 0) echo " in" ?>">
                            <div class="container-fluid">
                                <div class="row well">
                                    <div class="col-md-6">
                                        <h4 class="text-primary text-center">Exercises</h4>
                                        <button data-plan-id-exercise="<?=$plan['plan']['id']?>" data-target="#add-exercise" data-toggle="modal" class=" btn btn-primary btn-default btn-group-justified">Add Exercise</button><br>
                                        <?php
                                        $count_exercises = 0;
                                        $exercise=""; //reset exercise values
                                        foreach ($plan["exercises"] as $exercise)
                                        {
                                            if ($count_exercises == 0) {
                                                $duration_first = $exercise['duration'];
                                                $repetitions_first = $exercise['repetitions'];
                                                $days_first = $exercise['days']; /* 0-0-0-0-0-0-0*/
                                                $days_first = explode("-", $days_first);
                                                $days_first = array_diff($days_first, array("-")); //remove all "-"
                                                $name_first = $exercise['name'];
                                                $description_first = $exercise['exercise_description'];
                                                $first_id =$exercise['id'];
                                                $position_first = $plan_position ."-". $count_exercises;
                                            }

                                            $duration = $exercise['duration'];
                                            $repetitions = $exercise['repetitions'];
                                            $days = $exercise['days']; /* 0-0-0-0-0-0-0*/
                                            $name = $exercise['name'];
                                            $description = $exercise['exercise_description'];
                                            $position = $plan_position ."-". $count_exercises;


                                            //EDIT HERE
                                            ?>
                                            <p id="exercise-values-<?=$position?>" class="hidden">
                                                <label id="id-instance"><?=$exercise['id']?></label>
                                                <label id="days"><?=$exercise['days']?></label>
                                            </p>

                                            <div class="input-group">
                                                <button  exercise-instance-id="<?=$exercise['id']?>" id="<?= $plan_position ?>" data-exercise="<?=$count_exercises?>" data-obtain="exercise-button"  class=" input-group btn btn-sm btn-primary btn-default btn-group-justified <?php if ($count_exercises == 0) echo "disabled " ?>"><?= $name ?></button>
                                               <span class="input-group-btn">
                                                    <input  exercise-instance-id="<?=$exercise['id']?>" id="<?= $plan_position ?>"  class=" btn btn-sm btn-default btn-danger" value="x">
                                                </span>
                                            </div>
                                            <br/>
                                             <span class="hidden" id="saved-duration-<?php echo $position; ?>" ><?= $duration ?></span>
                                            <span class="hidden" id="saved-repetitions-<?php echo $position; ?>"><?= $repetitions ?></span>
                                            <span class="hidden" id="saved-name-<?php echo $position; ?>"><?= $name ?></span>
                                            <span class="hidden" id="saved-days-<?php echo $position; ?>"><?= $days ?></span>
                                            <span class="hidden" id="saved-description-<?php echo $position; ?>"><?= $description ?></span>
                                            <?php $count_exercises++;

                                        } ?>
                                    </div>

                                    <div class="col-md-6" id="<?= $plan_position ?>">

                                        <p>
                                            <label id="exercise-patient-<?php echo $position_first; ?>" >Patient: </label>
                                            <span class="exercise-content"><?= $plan['user_data']['name'] ?></span>
                                        </p>
                                        <p>
                                            <label id="exercise-patient-<?php echo $position_first; ?>" >Address: </label><span class="exercise-content"><?= $plan['user_data']['address'] ?></span>
                                        </p>
                                        <p>
                                            <label id="exercise-patient-<?php echo $position_first; ?>" >Birthdate: </label><span class="exercise-content"><?= $plan['user_data']['birthdate'] ?></span>
                                        </p>
                                        <hr/>
                                        <p>
                                            <label id="name-<?php echo $plan_position; ?>" >Name: </label>
                                            <span id="name-<?php echo $plan_position; ?>" class="exercise-content"><?= $name_first ?></span>
                                        </p>
                                        <p instance-id="<?=$first_id?>">
                                            <label id="repetitions-<?php echo $plan_position; ?>" >Repetitions:</label>
                                            <span value="<?= $repetitions_first ?>" class="exercise-content" id="repetitions-<?= $position_first ?>"><?= $repetitions_first ?> </span>
                                            <input type="text" class="hidden" value="<?= $repetitions_first ?>" id="repetitions-<?= $position_first ?>">
                                            <!-- if the exercise is empty its not possible to edit-->
                                            <?php if(!empty($exercise))
                                            {
                                            ?>
                                            <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-repetitions-<?= $position_first ?>" value="repetitions-<?= $position_first ?>"></span>
                                            <span  class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-repetitions-<?= $position_first ?>" value="repetitions-<?= $position_first ?>" id="save"></span>
                                            <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-repetitions-<?= $position_first ?>" value="repetitions-<?= $position_first ?>" id="remove"></span><br/>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <p>
                                            <label id="description-<?php echo $plan_position; ?>" >Description: </label>
                                            <span id="description-<?php echo $plan_position; ?>" class="exercise-content"><?= $description_first ?></span>
                                        </p>
                                        <p instance-id="<?=$first_id?>">
                                            <label id="duration-<?php echo $plan_position; ?>" >Duration: </label>
                                            <span value="<?= $duration_first ?>" class="exercise-content" id="duration-<?= $position_first ?>"><?= $duration_first ?></span>
                                            <input type="text" class="hidden" value="<?= $duration_first ?>" id="duration-<?= $position_first ?>">
                                            <!-- if the exercise is empty its not possible to edit-->
                                            <?php if(!empty($exercise))
                                            {
                                            ?>
                                            <span  class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-duration-<?= $position_first ?>" value="duration-<?= $position_first ?>"></span>
                                            <span  class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-duration-<?= $position_first ?>" value="duration-<?= $position_first ?>" id="save"></span>
                                            <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-duration-<?= $position_first ?>" value="duration-<?= $position_first ?>" id="remove"></span><br/>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <p><label  >Days of week: </label></p>
                                        <div id="days-<?php echo $plan_position; ?>" class="btn-group btn-group-lg btn-group-justified ">
                                            <?php

                                            for ($i = 0; $i < count($days_first); $i++)
                                            {
                                                $color = $days_first[$i] == 0 ? "btn-primary" : "btn-success";
                                                ?>
                                                <div class="btn-group">
                                                    <button class="btn <?= $color ?>"><?= $day_name[$i] ?></button>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End of collapsed information-->
                        <p></p>
                           <?php }
                            else
                            {
                               ?>
                        </div>
                        <div id="plan-<?= $plan_position ?>" class="collapse <?php if ($plan_position == 0) echo " in" ?>">
                            <div class="container-fluid">
                                <div class="row well">
                                    <div class="col-md-6">
                                        <h4 class="text-primary text-center">Exercises</h4>
                                        <?php
                                        $count_exercises = 0;
                                        foreach ($plan["exercises"] as $exercise)
                                        {
                                            if ($count_exercises == 0) {
                                                $duration_first = $exercise['duration'];
                                                $repetitions_first = $exercise['repetitions'];
                                                $days_first = $exercise['days']; /* 0-0-0-0-0-0-0*/
                                                $days_first = explode("-", $days_first);
                                                $days_first = array_diff($days_first, array("-")); //remove all "-"
                                                $name_first = $exercise['name'];
                                                $description_first = $exercise['exercise_description'];
                                            }

                                            $duration = $exercise['duration'];
                                            $repetitions = $exercise['repetitions'];
                                            $days = $exercise['days']; /* 0-0-0-0-0-0-0*/
                                            $name = $exercise['name'];
                                            $description = $exercise['exercise_description'];
                                            $position = $plan_position ."-". $count_exercises;
                                            ?>
                                            <button id="<?= $plan_position ?>" data-obtain="exercise-button" data-exercise="<?=$count_exercises?>"class=" btn btn-primary btn-group-justified <?php if ($count_exercises == 0) echo "disabled " ?>"><?= $name ?></button>
                                            <span class="hidden" id="saved-duration-<?php echo $position; ?>" ><?= $duration ?></span>
                                            <span class="hidden" id="saved-repetitions-<?php echo $position; ?>"><?= $repetitions ?></span>
                                            <span class="hidden" id="saved-name-<?php echo $position; ?>"><?= $name ?></span>
                                            <span class="hidden" id="saved-days-<?php echo $position; ?>"><?= $days ?></span> <br/>
                                            <span class="hidden" id="saved-description-<?php echo $position; ?>"><?= $description ?></span>
                                            <?php $count_exercises++;
                                        } ?>
                                    </div>
                                    <div class="col-md-6" id="<?= $plan_position ?>">
                                        <p>
                                                <label id="exercise-doctor-<?php echo $plan_position; ?>" >Doctor: </label><span class="exercise-content"><?= $plan['doctor_data']['name'] ?></span>
                                        </p>
                                        <p>
                                            <label id="exercise-doctor-<?php echo $plan_position; ?>" >Email: </label><span class="exercise-content"><?= $plan['doctor_data']['email'] ?></span>
                                        </p>
                                        <hr/>
                                        <p><label id="name-<?php echo $plan_position; ?>" >Name: </label><span class="exercise-content"><?= $name_first ?></span></p>
                                        <p><label id="repetitions-<?php echo $plan_position; ?>" >Repetitions:</label><span class="exercise-content"><?= $repetitions_first ?> </span></p>
                                        <p><label id="description-<?php echo $plan_position; ?>" >Description: </label><span class="exercise-content"><?= $description_first ?></span> </p>
                                        <p><label id="duration-<?php echo $plan_position; ?>" >Duration: </label><span class="exercise-content"><?= $duration_first ?></span></p>
                                        <p><label  >Days of week: </label></p>
                                        <div id="days-<?php echo $plan_position; ?>" class="btn-group btn-group-lg btn-group-justified ">
                                            <?php

                                            for ($i = 0; $i < count($days_first); $i++)
                                            {
                                                $color = $days_first[$i] == 0 ? "btn-primary" : "btn-success";
                                                ?>
                                                <div class="btn-group">
                                                    <button id="days-week" class="btn <?= $color ?>"><?= $day_name[$i] ?></button>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End of collapsed information-->
                        <p></p>
                        <?php
                            }
                            $plan_position++;
                        }
                    }?>

                </div>
            </div>
        </div>
    </div>
</div>


