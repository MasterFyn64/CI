<div class="page-name">Statistics</div>
<div class="container-fluid">
    <div class="row">
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
        <div id="1" class="col-lg-12 col-md-12 col-xs-12">
          <div>
              <div id="pieDiv" style=""></div>
              <div class="text-center">
                  <button type="button" id="pie-graph" class="btn btn-default btn-primary hidden">SELECT</button>
              </div>
            </div>
        </div>
        <div id="2" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
           <div>
               <div id="barDiv" style=""></div>
               <div class="text-center">
                   <button type="button" id="bar-graph" class="btn btn-default btn-primary">SELECT</button>
               </div>
           </div>
        </div>
        <div id="3" class="col-lg-6 col-md-6 col-sm.12 col-xs-12">
            <div>
                <div id="progressDiv" style=""></div>
                <div class="text-center">
                    <button type="button" id="progress-graph" class="btn btn-default btn-primary">SELECT</button>
                </div>
            </div>
        </div>
    </div>
</div>