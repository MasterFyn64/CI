<div class="page-name">Plan</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id = "main-container-plans">
                <div id="all-plans" class= "panel">
                    <?php
                    $count =0;
                    $day_name = array("S","M","T","W","T","F","S");
                    $plan_position=0;
                    if(empty($plans))
                    {
                        echo "<div class='text-center'>You don't have any messages!</div>";
                    }
                    else
                    {
                        foreach ($plans as $plan)
                        {
                            //reset variables
                            $duration_first = "";
                            $repetitions_first = "";
                            $days_first="0-0-0-0-0-0-0";
                            $days_first = explode("-", $days_first);
                            $days_first = array_diff($days_first, array("-")); //remove all "-"
                            $name_first = "";
                            $description_first = "";
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
                                            <p><label id="exercise-name-<?php echo $plan_position; ?>" >Name: </label><span><?= $name_first ?></span></p>
                                            <p><label id="exercise-repetitions-<?php echo $plan_position; ?>" >Repetitions:</label><span><?= $repetitions_first ?> </span></p>
                                            <p><label id="exercise-description-<?php echo $plan_position; ?>" >Description: </label><span><?= $description_first ?></span> </p>
                                            <p><label id="exercise-duration-<?php echo $plan_position; ?>" >Duration: </label><span><?= $duration_first ?></span></p>
                                            <p><label  >Days of week: </label></p>
                                            <div id="exercise-days-<?php echo $plan_position; ?>" class="btn-group btn-group-lg btn-group-justified ">
                                                <?php

                                                    for ($i = 0; $i < count($days_first); $i++) {
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
                            <?php $plan_position++;
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
</div>
