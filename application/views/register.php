<div class="page-name">Register</div>
<!-- Call header_login on controller-->

<div class="container-fluid">
    <div class="row ">
        <div class="register-menu well col-xs-7 col-xs-offset-2 col-md-6 col-md-offset-3 col-lg-5 col-lg-offset-3">

            <?php
            $attributes = array( 'id' => 'form1');
            echo form_open_multipart('register/insert',$attributes);?>

                <h2 class="text-center">Personal Data</h2>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Name</span>
                    <input type="textarea" class="form-control" placeholder="name" name="name" id="name" aria-describedby>
                </div><br/>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Email</span>
                    <input type="text" class="form-control" placeholder="email@email.pt" name="email" id="email" aria-describedby>
                </div><br/>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Password</span>
                    <input type="password" class="form-control" placeholder="password" name="password" id="password" aria-describedby>
                </div><br/>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Repeat Password</span>
                    <input type="password" class="form-control" placeholder="password" name="repeat_password" id="repeat_password" aria-describedby>
                </div><br/>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Birthdate</span>
                    <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="birthdate" id="birthdate" >
                </div><br/>

                <!-- add more contacts--->
               <div class="add-contacts">
                   <p class="hidden">&nbsp</p>
                   <div class="input-group">
                       <span id="change" class="input-group-addon" id="basic-addon1">Contact</span>
                       <input type="number" class="form-control" name="contact[]" id="contact" >
                       <span class="input-group-btn">
                           <button id="remove" type="button " value="X" class=" btn btn-danger">X</button>
                       </span>
                   </div>

               </div>

            <div class="new-contact"">

            </div>
            <button type="button" class="form-control btn btn-primary" name="add" id="add">add</button>
                <br/>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Address</span>
                    <textarea class="form-control" rows="2" name="address" id="address"></textarea>
                </div><br/>


            </form>
        <input class="btn btn-default" form="form1" class="form-control" type="reset" value="Reset">
        <button id="check" class = "btn btn-primary" data-toggle = "modal" data-target = "#myModal">
            Register
        </button>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog"
     aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>

                <h4 class = "modal-title" id = "myModalLabel">
                   Information check
                </h4>
            </div>

            <div class = "modal-body">
                <p><label>Name:</label> <span id="name"> </span></p>
                <p ><label>Email:</label><span id="email"></span></p>
                <p><label>Birthdate:</label><span id="birthdate"> </span></p>
                <p><label>Contact:</label><span id="contact"> </span></p>
                <p><label>Address:</label><span id="address"> </span></p>
            </div>

            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">
                    Edit
                </button>

                <input class="btn btn-primary"type="submit" form="form1" class="form-control" value="Confirm">
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->
