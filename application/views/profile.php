<!-- profile body -->
<div class="page-name" id="profile">Profile</div>
<div class="container">
   <div class="row">
       <!-- profile image and the form to upload new profile image-->
        <div class="col-lg-4 col-lg-offset-2 col-md-4 col-md-offset-1 col-sm-offset-1 col-sm-5 col-xs-12 ">
            <img class="img-circle center-block img-profile " src="<?=base_url()?>assets/images/profile/<?=$photo_url?>">

            <?php echo form_open_multipart('profile/do_upload');?>

            <input type="file" class="btn btn-primary center-block" name="userfile" size="20">
            <br />

            <input type="submit" class="btn btn-primary center-block" value="upload" />

            </form>
        </div>

       <!-- div with the profile information _ name, address, email, contacts, room number and others-->
       <div class="profile-information col-lg-5 col-md-5 col-sm-6  col-xs-8 center-block">
           <div class="form-group">
               <label >
                   Name:
               </label>
               <span id="edit-name">
                   <input type="text" class="hidden" value="<?= $name ?>" id="name">
                    <span  value="<?=$name?>" id="name"><?=$name?></span>
                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-name" value="name"></span>
                   <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-name" value="name" id="save"></span>
                   <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-name" value="name" id="remove"></span>
               </span>
           </div>
           <div class="form-group">
               <label >
                   Email:
               </label>
               <span id="edit-email">
                   <input type="text" class="hidden" value="<?= $email ?>" id="email">
                    <span value="<?=$email?>" id="email"><?=$email?></span>
                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-email" value="email"></span>
                   <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-email" value="email" id="save"></span>
                   <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-email" value="email" id="remove"></span>
               </span>

           </div>

           <div class="form-group">
               <label >
                    Address:
               </label>
               <span id="edit-address">
                   <input type="text" class="hidden" value="<?= $address ?>" id="address">
                    <span  value="<?=$address?>" id="address"><?=$address?></span>
                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-address" value="address"></span>
                   <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-address" value="address" id="save"></span>
                   <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-address" value="address" id="remove"></span>
               </span>

           </div>
           <div class="form-group">
               <label>
                    Birthdate:
               </label>
               <span id="edit-birthdate">
                   <input type="text" class="hidden" value="<?= $birthdate ?>" id="birthdate">
                    <span  value="<?=$birthdate?>"id="birthdate"><?=$birthdate?></span>
                    <span class="glyphicon glyphicon-profile glyphicon-edit text-primary"  id="edit" name="edit-birthdate" value="birthdate"></span>
                   <span class=" glyphicon glyphicon-profile glyphicon-ok text-success hidden" name="save-birthdate" value="birthdate" id="save"></span>
                   <span class="glyphicon glyphicon-profile glyphicon-remove text-danger hidden" name="cancel-birthdate" value="birthdate" id="remove"></span>
               </span>
           </div>
           <div class="form-group">


               <label>
                    Contact(s):
               </label>
               <span>
                   <?php
                      if(is_array($contacts))
                      {
                          foreach($contacts as $contact)
                              echo $contact->getNumber()."&nbsp;&nbsp;";
                      }
                       else
                       echo $contact->getNumber();
                   ?>
               </span></a>
           </div>

           <?php
           if($room_number!="") {
               ?>
               <div class="form-group">


                   <label>
                       Room Number:
                   </label>
                       <span>
                           <?=$room_number?>
                   </span></a>
               </div>
               <?php
           }
           ?>
       </div>
    </div>
</div>
