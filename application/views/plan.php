<div class="page-name">Plan</div>


<div class="container">
    <div class="row">
        <div class="col-md-1 no-float text-center "></div>

        <div id = "main-container-messages" class=" panel col-md-10 no-float">
                    <?php
                    $count =
                        $color="btn-primary";
                        0;?>


                    <div class="btn-group btn-group-lg btn-group-justified " id="header-messages-<?= $count ?>">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-primary">Start: </button>
                        </div>
                        <div class="btn-group">
                            <button data-toggle="collapse" type="button" class="btn btn-default <?= $color ?>"
                                    data-parent="#main-container-messages" href="#messages-<?= $count ?>">
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-primary">End: </button>
                        </div>
                    </div>

                    <div id="messages-<?= $count ?>" class="collapse <?php if ($count == 0) echo " in" ?>">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 well">
                                    <h4 class="text-primary text-center">Exercises</h4>
                                    <button class="btn btn-primary btn-group-justified disabled">Exercise name</button>
                                </div>
                                <div class="col-md-6 well">
                                    <p><label class="text-primary">Repetitions: </label> 22</p>
                                    <p><label class="text-primary">Duratiion: </label> </p>
                                    <p><label class="text-primary">Days of week: </label> </p>

                                    <div class="btn-group btn-group-lg btn-group-justified ">
                                        <div class="btn-group">
                                            <button class="btn btn-success">S</button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-primary">M</button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-primary">T</button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-primary">W</button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-primary">T</button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-success">F</button>
                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-primary">S</button>
                                        </div>

                                    </div>
                                 </div>
                        </div>
                    </div> <!-- End of collapsed information-->
                    <p></p>

            </div>
        </div>
    </div>

    <div class="col-md-1 no-float text-center "></div>
</div>







