<div id="plan" class="page-name">Plan</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id = "main-container-plans">
                <div id="all-plans" class= "panel">
                    <div class="col-lg-offset-8 col-lg-3 col-md-offset-9 col-md-2 col-sm-offset-8  col-sm-3 col-xs-12">
                        <?php
                        if($user_type=="DOCTOR")
                        {?>
                            <div class="pull-right  hidden-xs text-center">
                                <select class="form-control" >

                                    <?php
                                    foreach ($patients as $patient) {
                                        ?>
                                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select><br/>
                            </div>
                            <?php
                            ?>
                            <div class="visible-xs text-center">
                                <select class="form-control" >

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
                            $description_first = "";


                            if ($user_type == "DOCTOR")
                            {?>
                    <div class="btn-group btn-group-lg btn-group-justified " id="header-plan-<?= $plan_position ?>">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-primary">Start: <?=$plan['plan']['start_date']?></button>
                </div>
                <div class="btn-group">
                    <button data-toggle="collapse" type="button" class="btn btn-default btn-primary"
                            data-parent="#main-container-plans" href="#plan-<?= $plan_position ?>">
                        <span class="">&nbsp;<span class="glyphicon glyphicon-chevron-down"></span> </span>
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-primary">End: <?=$plan['plan']['end_date']?></button>
                </div>
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
                                <span class="hidden" id="exercise-duration-<?php echo $position; ?>" ><?= $duration ?></span>
                                <span class="hidden" id="exercise-repetitions-<?php echo $position; ?>"><?= $repetitions ?></span>
                                <span class="hidden" id="exercise-name-<?php echo $position; ?>"><?= $name ?></span>
                                <span class="hidden" id="exercise-days-<?php echo $position; ?>"><?= $days ?></span> <br/>
                                <span class="hidden" id="exercise-description-<?php echo $position; ?>"><?= $description ?></span>
                                <?php $count_exercises++;
                            } ?>
                        </div>
                        <div class="col-md-6" id="<?= $plan_position ?>">
                            <p>
                                <label id="exercise-name-<?php echo $plan_position; ?>" >Name: </label><span class="exercise-content"><?= $name_first ?></span>
                                <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-name-<?= $count_exercises ?>" value="name-<?= $count_exercises ?>"></span>
                                <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-name-<?= $count_exercises ?>" value="name-<?= $count_exercises ?>" id="save"></span>
                                <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-name-<?= $count_exercises ?>" value="name-<?= $count_exercises ?>" id="remove"></span><br/>

                            </p>

                            <p>
                                <label id="exercise-repetitions-<?php echo $plan_position; ?>" >Repetitions:</label><span class="exercise-content"><?= $repetitions_first ?> </span>
                                <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-repetitions-<?= $count_exercises ?>" value="repetitions-<?= $count_exercises ?>"></span>
                                <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-repetitions-<?= $count_exercises ?>" value="repetitions-<?= $count_exercises ?>" id="save"></span>
                                <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-repetitions-<?= $count_exercises ?>" value="repetitions-<?= $count_exercises ?>" id="remove"></span><br/>

                            </p>
                            <p>
                                <label id="exercise-description-<?php echo $plan_position; ?>" >Description: </label><span class="exercise-content"><?= $description_first ?></span>
                                <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-description-<?= $count_exercises ?>" value="description-<?= $count_exercises ?>"></span>
                                <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-description-<?= $count_exercises ?>" value="description-<?= $count_exercises ?>" id="save"></span>
                                <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-description-<?= $count_exercises ?>" value="description-<?= $count_exercises ?>" id="remove"></span><br/>

                            </p>
                            <p>
                                <label id="exercise-duration-<?php echo $plan_position; ?>" >Duration: </label><span class="exercise-content"><?= $duration_first ?></span>
                                <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-duration-<?= $count_exercises ?>" value="duration-<?= $count_exercises ?>"></span>
                                <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-duration-<?= $count_exercises ?>" value="duration-<?= $count_exercises ?>" id="save"></span>
                                <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-duration-<?= $count_exercises ?>" value="duration-<?= $count_exercises ?>" id="remove"></span><br/>

                            </p>
                            <p><label  >Days of week: </label></p>
                            <div id="exercise-days-<?php echo $plan_position; ?>" class="btn-group btn-group-lg btn-group-justified ">
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
                        <div class="btn-group btn-group-lg btn-group-justified " id="header-plan-<?= $plan_position ?>">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-primary">Start: <?=$plan['plan']['start_date']?></button>
                                </div>
                                <div class="btn-group">
                                    <button data-toggle="collapse" type="button" class="btn btn-default btn-primary"
                                            data-parent="#main-container-plans" href="#plan-<?= $plan_position ?>">
                                        <span class="">&nbsp;<span class="glyphicon glyphicon-chevron-down"></span> </span>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-primary">End: <?=$plan['plan']['end_date']?></button>
                                </div>
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
                                            <span class="hidden" id="exercise-duration-<?php echo $position; ?>" ><?= $duration ?></span>
                                            <span class="hidden" id="exercise-repetitions-<?php echo $position; ?>"><?= $repetitions ?></span>
                                            <span class="hidden" id="exercise-name-<?php echo $position; ?>"><?= $name ?></span>
                                            <span class="hidden" id="exercise-days-<?php echo $position; ?>"><?= $days ?></span> <br/>
                                            <span class="hidden" id="exercise-description-<?php echo $position; ?>"><?= $description ?></span>
                                            <?php $count_exercises++;
                                        } ?>
                                    </div>
                                    <div class="col-md-6" id="<?= $plan_position ?>">
                                        <p><label id="exercise-name-<?php echo $plan_position; ?>" >Name: </label><span class="exercise-content"><?= $name_first ?></span></p>
                                        <p><label id="exercise-repetitions-<?php echo $plan_position; ?>" >Repetitions:</label><span class="exercise-content"><?= $repetitions_first ?> </span></p>
                                        <p><label id="exercise-description-<?php echo $plan_position; ?>" >Description: </label><span class="exercise-content"><?= $description_first ?></span> </p>
                                        <p><label id="exercise-duration-<?php echo $plan_position; ?>" >Duration: </label><span class="exercise-content"><?= $duration_first ?></span></p>
                                        <p><label  >Days of week: </label></p>
                                        <div id="exercise-days-<?php echo $plan_position; ?>" class="btn-group btn-group-lg btn-group-justified ">
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
