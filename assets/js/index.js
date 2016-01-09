$(document).ready(function() {

    /* plans */
    $('input[exercise-instance-id]').click(function()
    {
        var exercise_instance = $(this).attr('exercise-instance-id');
       $('div[id="'+ $(this).attr('id')+'"]').children('p').children('span[class="exercise-content"]').each(function()
       {
           $(this).parent().children('span[id^="repetitions"]').html("");
           $(this).parent().children('span[id^="name"]').html("");
           $(this).parent().children('span[id^="description"]').html("");
           $(this).parent().children('span[id^="duration"]').html("");
       });
        var s = $(this);
        $.post('/CI/Api/removeInstance',
            {
                remove : exercise_instance
            },
            function(data,status)
            {
                console.log(data);
                if(data=="SUCCESS")
                {
                    s.parent().parent().next().remove(); //remove br
                    s.parent().parent().remove(); //remove node
                }

            }
        )
    });

    $('select[id="select-patient"]').change(function() { //search plans using patient name
        var option_selected = $(this).val();
        console.log(option_selected);

        $('span[user-id]').each(function()
        {
            if($(this).attr('user-id')!="all")
            {
                if($(this).attr('user-id')==option_selected)
                {
                    $(this).parent().attr('class','btn-group btn-group-lg btn-group-justified');
                }
                else{
                    $(this).parent().attr('class','hidden');
                    var plan_position = $(this).parent().attr('id');
                    var splitted=  plan_position.split('-');
                    $('div[id="plan-'+splitted[2]+'"]').attr('class','collapse');
                }
            }
            if(option_selected=="all") // when the optin selected is all (show everything)
            {
                $(this).parent().attr('class','btn-group btn-group-lg btn-group-justified');
            }
        });
    });

    $('select[name="choose-exercise"]').change(function() //choose what method will use (or enter new exercise or choose one)
    {
        var option_selected = $(this).val();
        console.log(option_selected);
        if(option_selected=="insert-exercise")
        {
            $('select[id="select-exercise"]').attr('class','hidden');
            $('div[id="insert-exercise"]').attr('class','');
        }
        else if (option_selected=="select-exercise")
        {
            $('select[id="select-exercise"]').attr('class','form-control');
            $('div[id="insert-exercise"]').attr('class','hidden');
        }

    });

    $('button[data-plan-id-exercise]').click(function()  //update planID to add new exercises
    {
        var value = $(this).attr('data-plan-id-exercise');
        $('input[id="planID"]').attr('value',value);
    });

    $('button[plan-id]').click(function() //change plan to remove to pop-up
    {
        var remove = $(this).attr('plan-id');
        $('div[id="remove-plan"]').children().children().children('div[class="modal-footer"]').children('button[plan-id]').attr('plan-id',remove);
    });

    $('button[form="remove-plan"]').click(function() //confirm and remove plan
    {
        //esc key
        var esc = jQuery.Event("keydown");
        esc.which = 27;

        var remove = $(this).attr('plan-id');
        $.post('/CI/Api/remove',
            {
                remove:remove
            },
            function(data,status)
            {
                if(data="SUCCESS")
                {
                    var close = $('#remove-plan');
                    close.attr("data-dismiss","modal").trigger(esc);
                    close.attr("data-dismiss","");
                    location.reload();
                }
            });

    });

    $("button[data-obtain='exercise-button']").click(function()
    {
        var plan_id = $(this).attr('id');

        $(this).parent().parent().children('div[class="input-group"]').each(function()
        {
            $(this).children('button').attr('class','btn btn-sm btn-default btn-primary btn-group-justified');
        });

        $(this).attr('class','btn btn-sm btn-primary btn-group-justified disabled');
        var exercise_id =$(this).attr('data-exercise');
        var s = ['duration-','repetitions-','name-','description-'];

        var results =[];
        for(r=0;r< s.length;r++)
        {
            results[r]=$('span[id="saved-'+s[r]+plan_id+'-'+exercise_id+'"]').html();

        }
        for(r=0;r< s.length;r++)
        {
            //change exercise position and plan to change em real time
            var plan_exercise_id =s[r]+plan_id+"-"+exercise_id;

            $('label[id="'+s[r]+plan_id+'"]').next(".exercise-content").html(results[r]);
            $('label[id="'+s[r]+plan_id+'"]').next(".exercise-content").attr({'value':results[r],'id':plan_exercise_id});//span
            $('label[id="'+s[r]+plan_id+'"]').next(".exercise-content").next().attr({'value':results[r],'id':plan_exercise_id});//input
            $('label[id="'+s[r]+plan_id+'"]').parent().attr("instance-id",$(this).attr("exercise-instance-id"));



            $('label[id="'+s[r]+plan_id+'"]').parent().children('span[id="edit"]').attr('name','edit-'+plan_exercise_id);
            $('label[id="'+s[r]+plan_id+'"]').parent().children('span[id="edit"]').attr('value',plan_exercise_id);
            $('label[id="'+s[r]+plan_id+'"]').parent().children('span[id="remove"]').attr('name','cancel-'+plan_exercise_id);
            $('label[id="'+s[r]+plan_id+'"]').parent().children('span[id="remove"]').attr('value',plan_exercise_id);
            $('label[id="'+s[r]+plan_id+'"]').parent().children('span[id="save"]').attr('name','save-'+plan_exercise_id);
            $('label[id="'+s[r]+plan_id+'"]').parent().children('span[id="save"]').attr('value',plan_exercise_id);
        }
        //days
            var days= $('span[id="saved-days-'+plan_id+'-'+exercise_id+'"]').html();

            var i=0;
            $('div[id="days-'+plan_id+'"]').children('div').each(function()
            {
                if(days[i]==0)
                    $(this).children().attr('class','btn btn-default btn-primary');
                else
                    $(this).children().attr('class','btn btn-default btn-success');
                i=i+2;
            });
    });

    /*emd plans*/
    $("#1").on("click","button",function() //It looks for button inside the div 1 and execute click button
    {
       changeGraphs($(this));
    });

    $("#2").on("click","button",function()
    {
       changeGraphs($(this));
    });

    $("#3").on("click","button",function()
    {
       changeGraphs($(this));
    });

    function changeGraphs(Object)
    {
        Object.attr('class','btn btn-default btn-primary hidden');
        var graph = Object.parent().parent();
        var present_position_id = Object.parent().parent().parent().attr('id');
        graph.remove();
        var next_position =$('div[id="1"]');
        next_position.children().children().children('button').attr('class','btn btn-default btn-primary');
        var old_graph=next_position.children();
        old_graph.remove();
        $('div[id="'+present_position_id+'"]').append(old_graph);
        next_position.append(graph);
        reloadGraphs(Object.attr('id'),old_graph.children().children('button').attr('id'));
    }

    $('input[name^="state-"]').click(function()
    {
        var name= $(this).attr('name');
        var values = name.split("-");
        var number = values[1];
        var bar = "header-messages-"+number;
        var state =$(this).attr('value');

        var appointment_id=  $('div[id="'+bar+'"]').attr("send-appointment-id");

        if(state=="pending"||state=="done"||state=="cancelled"||state=="waiting")
        {
            if(state=="pending")
            {
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children().attr('class','btn btn-default btn-warning');
                });
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children('input').attr('class','btn btn-default btn-warning');

                });
                $('input[id="state-messages-'+number+'"]').val('PEND');
            }
            else if(state=="done")
            {
                $('div[id="'+bar+'"]').children().each(function(){
                   $(this).children().attr('class','btn btn-default btn-success');
                });
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children('input').attr('class','btn btn-default btn-success');
                });
                $('input[id="state-messages-'+number+'"]').val('DONE');
            }
            else if(state=="cancelled")
            {
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children().attr('class','btn btn-default btn-danger');
                });
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children('input').attr('class','btn btn-default btn-danger');
                });
                $('input[id="state-messages-'+number+'"]').val('CANC');
            }
            else if(state=="waiting")
            {
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children('button').attr('class','btn btn-default btn-primary disabled');
                });
                $('div[id="'+bar+'"]').children().each(function(){
                    $(this).children('input').attr('class','btn btn-default btn-primary disabled');
                });
                $('input[id="state-messages-'+number+'"]').val('WAIT');
            }

            $.post('/CI/Api/updatestate',
                {
                    changing:appointment_id,
                    newstate:state
                },
                function(data,status)
                {
                    if(data=="SUCCESS")
                    {
                        message_notification="State updated successfully!";
                        message_type="success";
                        message_title="Information: ";
                        message_delay=2000;;

                        notify(message_notification,message_type,message_title,message_delay);
                    }
                }
            );
        }
    });

//-------------------------------Send Message-------------------------
    $('button[id="send-message"]').click(function() {
        //esc key
        var esc = jQuery.Event("keydown");
        esc.which = 27;

        //in case of doctor
        var user_ids= [];
        var doctor_id;

        var subject= $('input[id="message-subject"]').val();
        var subject_object= $('input[id="message-subject"]');
        var content= $('textarea[id="message-content"]').val();
        var content_object= $('textarea[id="message-content"]');

        var fields =[subject_object,content_object];

        $('select option:selected').each(function(){
            user_ids.push($(this).attr('value'));
        });

        $.post("/CI/Api/sendmessage",
            {
                content:content,
                subject: subject,
                user_ids: user_ids
            },
            function(data, status){
                    if(data=="ids_error")
                    {
                        message_notification="Select one patient!";
                        message_type="info";
                        message_title="Patients Error:";
                        message_delay=2000;
                        var close = $('#send-message');
                        close.attr("data-dismiss","modal").trigger(esc);
                        close.attr("data-dismiss","");
                        notify(message_notification,message_type,message_title,message_delay);
                    }
                    else if(data=="fields_error")
                    {
                        message_notification="Missing fields!";
                        message_type="info";
                        message_title="Message:";
                        message_delay=2000;
                        var close = $('#send-message');
                        close.attr("data-dismiss","modal").trigger(esc);
                        close.attr("data-dismiss","");
                        notify(message_notification,message_type,message_title,message_delay);
                    }
                     else
                    {

                        //Reset pop-up
                        var close = $('#send-message');
                        for(var i=0;i<2;i++) {
                            fields[i].val("");
                            fields[i].parent().attr('class',"form-group");
                        }
                        //Change data-dismiss to be able to close pop-up and trigger click to close it
                        close.attr("data-dismiss","modal").trigger(esc);
                        close.attr("data-dismiss","");
                        message_notification="Message(s) sent correctly!";
                        message_type="success";
                        message_title="Message:";
                        message_delay=2000;
                        notify(message_notification,message_type,message_title,message_delay);
                        setTimeout(reload,4000);
                    }



            });

    });
//--------------------------------------------------------------------
function reload()
{
    location.reload();
}

//---------------------------------------Take care of messages-----------
    $('button[id="open-message"]').click(function()
    {
       if($(this).attr('read')!=1)
       {
           var message_number = $(this).attr('message-number');
           $(this).attr('read',1);
           $(this).parent().parent().children().children('input').each(function()
           {
               $(this).attr('class','btn btn-primary disabled');
           });
           $(this).parent().parent().children().children('button').each(function()
           {
               $(this).attr('class','btn btn-primary disabled');
           });
           $.post("/CI/Api/updatemessage",
               {
                   message_number:message_number
               },
               function(data,status)
               {
                   //
               });

       }
    });
//--------------------------------------------------------------------

//--------------------------------Appointments book--------------------


    $('button[id="submit-book"]').click(function()
    {
        //esc key
        var esc = jQuery.Event("keydown");
        esc.which = 27;

        //in case of doctor
        var user_id = $('select option:selected').attr('value');

        var date_value =$('input[id="book-date"]').val();
        var date =$('input[id="book-date"]');
        var hour_value =$('input[id="book-hour"]').val();
        var hour =$('input[id="book-hour"]');
        var description_value =$('input[id="book-description"]').val();
        var description =$('input[id="book-description"]');
        var type_value =$('input[id="book-type"]').val();
        var type =$('input[id="book-type"]');
        var errors="";
        var show_errors=$('p[id="book-errors"]');


        var s = ["hour", "date", "type","description"];
        var fields=[hour,date,type,description];
        var values=[hour_value,date_value,type_value,description_value];

        if(date_value==""||hour_value==""||description_value==""||type_value=="")
        {
            for(var i=0;i<4;i++)
            {
                if(values[i]=="")
                {
                    errors+="Please insert the "+s[i]+"!<br/>";
                    fields[i].parent().attr('class',"form-group has-error");
                    fields[i].focus();
                }
                else
                    fields[i].parent().attr('class',"form-group");

            }

            show_errors.html(errors);
        }
        else
        {
            $.post("/CI/api/book",
                {
                    date: date_value,
                    hour:hour_value,
                    description: description_value,
                    type:type_value,
                    user_id: user_id
                },
                function(data, status){
                    if(data=="id_error")
                    {
                        message_notification="Select one patient!";
                        message_type="info";
                        message_title="Patients Error:";
                        message_delay=2000;

                        var close = $('#submit-book');
                        //Change data-dismiss to be able to close pop-up and trigger click to close it
                        close.attr("data-dismiss","modal").trigger(esc);
                        close.attr("data-dismiss","");

                        notify(message_notification,message_type,message_title,message_delay);

                    }
                    else if(data!="SUCCESS")
                    {
                        show_errors.html(data);
                    }
                    else
                    {
                        //Reset pop-up
                        var close = $('#submit-book');
                        for(var i=0;i<4;i++) {
                            fields[i].val("");
                            show_errors.html("");
                            fields[i].parent().attr('class',"form-group");
                        }
                        //Change data-dismiss to be able to close pop-up and trigger click to close it
                        close.attr("data-dismiss","modal").trigger(esc);
                        close.attr("data-dismiss","");
                        location.reload();

                    }
                });
        }


    });
//-----------------------------------End appointment BOOK------------

    $('button[id="search-appointments"]').click(function()
    {
        var hour = $('input[id="hour"]').val()+":00";
        var date = $('input[id="date"]').val();

       $('input[id="date-message"]').each(function() {
           var message_date = $(this).val();
           var message_hour = $(this).parent().parent().find('input[id="hour-message"]').val();
           if(date>=message_date) {
               if(date==message_date && hour<=message_hour) //check if the day is the same as message and compare with hour
               {
                  // console.log(message_hour+" "+hour); Check information
                   $(this).parent().parent().attr('class', "btn-group btn-group-lg btn-group-justified visible");
                   var search_content = $(this).parent().parent().attr('id');
                   var temp =search_content.split("-");
                   var search = "messages-"+temp[2].toString();
                   $('div[id='+search+']').attr("class","collapse visible")
               }
              else
               {
                   $(this).parent().parent().attr('class', "btn-group btn-group-lg btn-group-justified hidden");
                   var search_content = $(this).parent().parent().attr('id');
                   var temp =search_content.split("-");
                   var search = "messages-"+temp[2].toString();
                   $('div[id='+search+']').attr("class","collapse hidden")
               }
           }
           else
           {
               $(this).parent().parent().attr('class', "btn-group btn-group-lg btn-group-justified visible");
               var search_content = $(this).parent().parent().attr('id');
               var temp =search_content.split("-");
               var search = "messages-"+temp[2].toString();
               $('div[id='+search+']').attr("class","collapse visible")
           }


       });

    });


    /*---------------------------------------------Start of add contacts-------------------------------------------------*/
    //variable that counts how many contacts where added
        var number_of_contacts=1;
    //Add new contacts input
    $('button[id="add"]').click(function () {
        number_of_contacts++;
        //add new inputs for the new contacts.

        //Clones the previous input for the contact and changes is attributes to match the remove and the style.
        var newContact= $('.add-contacts').clone(true, true);
        newContact.find('input', newContact).val("");
        var txt = document.createTextNode('Contact '+number_of_contacts+"");
        newContact.find('span[id="change"]', newContact).html(txt);
        newContact.find('button',newContact).attr({'class':' btn btn-danger','id':number_of_contacts,'name':'remove'});
        newContact.find('p',newContact).attr({'class':''});
        newContact.attr({'class':'new-added-'+number_of_contacts,'id':number_of_contacts}).appendTo('.new-contact');

    });

    //remove contact condition
    $('button[id="remove"]').click(function(e)
    {
        var button_clicked = $(e.target); //get object clicked
        var contact_id=button_clicked.attr('id')
        $('div[id='+contact_id+']').remove();
        number_of_contacts--;
    });

    //Handles the check form data button
    $('button[id="check"]').click(function(e)
    {
        $contact_values ="";

        //obtain all the values with id=contact
        $('input[id="contact"]').each(function(){
            $contact_values+="<br/>"+$(this).val();
        });

        $('span[id="email"]').html($('input[id="email"]').val());
        $('span[id="name"]').html($('input[id="name"]').val());
        $('span[id="birthdate"]').html($('input[id="birthdate"]').val());
        $('span[id="contact"]').html($contact_values);
        $('span[id="address"]').html($('textarea[id="address"]').val());
    });
/*---------------------------------------------End of add contacts-------------------------------------------------*/


/*---------------------------------------------Profile treatment-------------------------------------------------*/
    //start edit profile information
    $('span[id="edit"]').click(function(e){
       var  edit_link = $(e.target);
        var field_name = edit_link.attr('value');

        edit_link.attr('class',"glyphicon glyphicon-profile glyphicon-edit hidden")
        $('input[id="'+field_name+'"]').attr('class',"").focus();
        $('span[id="'+field_name+'"]').attr('class',"hidden");
        $('span[name="save-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-ok text-success");
        $('span[name="cancel-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-remove text-danger");

    });

    //Save profile information and send notification with errors made
    $('span[id="save"]').click(function(e){

        var  edit_link = $(e.target);
        var field_name= edit_link.attr('value');
        //change input to span
        $('span[id="'+field_name+'"]').attr('class',"exercise-content");
        $('input[id="'+field_name+'"]').attr('class',"hidden");
        var changed_value=$('input[id="'+field_name+'"]').val();
        $('span[id="'+field_name+'"]').html(changed_value);

        //in case of errors save the last value
        var last_value = $('span[id="'+field_name+'"]').attr('value');


        var error=false;
        message_notification=message_type=message_title=message_delay="";

        //needed to update appointments information
         var data_value=  $('.page-name').attr('id');

        if(data_value=="appointment")//need to update appointments
            var id=  $(this).parent().parent().parent().parent().children('span[id="send-appointment-id"]').html();
        else if(data_value=="plan") //need to update exercises
        {
            //proceed to the change of changed value
            var exercise_position=$(this).attr('name');
            var result = exercise_position.split('-');
            var plan = result[2];
            var exercise_position = result[3];
            var fieldname = field_name.split('-');
            fieldname = fieldname[0];

            var complete_search = 'saved-'+fieldname+'-'+plan+'-'+exercise_position;
            $('span[id="'+complete_search+'"]').html(changed_value);
            var id = $(this).parent().attr('instance-id');
        }


        switch (field_name) //checks what field will be updated
        {
            case 'description':
            {
                if(!changed_value.match(/^[a-zA-Z ]+$/)) {
                    error = true;
                    message_notification="Insert a correct description!";
                    message_type="info";
                    message_title="Invalid Description:";
                    message_delay=2000;
                }
            }break;
            case 'private_note':
            {
                if(!changed_value.match(/^[a-zA-Z1-9 ]+$/)) {
                    error = true;
                    message_notification="Insert a correct note!";
                    message_type="info";
                    message_title="Invalid Note:";
                    message_delay=2000;
                }
            }break;
            case 'public_note':
            {
                if(!changed_value.match(/^[a-zA-Z1-9 ]+$/)) {
                    error = true;
                    message_notification="Insert a correct note!";
                    message_type="info";
                    message_title="Invalid Note:";
                    message_delay=2000;
                }
            }break;
            case 'address':{
                if(!changed_value.match(/^[a-zA-Z1-9 ]+$/)) {
                    error = true;
                    message_notification="Insert a correct address!";
                    message_type="info";
                    message_title="Invalid address: ";
                    message_delay=2000;
                }
            }break;
            case 'name':{
                if(!changed_value.match(/^[a-zA-Z ]+$/)) {
                    error = true;
                    message_notification="Insert a correct name!";
                    message_type="info";
                    message_title="Invalid name:";
                    message_delay=2000;
                }
            }break;
            case 'birthdate':{
                //missing this verification!!!
            }break;
            case 'email':{
                if(!changed_value.match(/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/))
                {
                    error = true;
                    message_notification="Insert a correct email!";
                    message_type="info";
                    message_title="Invalid Email: ";
                    message_delay=2000;
                }
            }break;
            case 'contact':{
                if(!changed_value.match(/^[1-9]+$/)) {
                    error = true;
                    message_notification="Insert a valid contact!";
                    message_type="info";
                    message_title="Invalid contact:";
                    message_delay=2000;
                }
            }break;
            case 'repetitions':{
                if(!changed_value.match(/^[1-9]+$/)) {
                    error = true;
                    message_notification="Insert a valid contact!";
                    message_type="info";
                    message_title="Invalid contact:";
                    message_delay=2000;
                }
            }break;
            case 'duration':{
                if(!changed_value.match(/^[1-9]+$/)) {
                    error = true;
                    message_notification="Insert a valid contact!";
                    message_type="info";
                    message_title="Invalid contact:";
                    message_delay=2000;
                }
             }break;
        }
        if(!error)
        {
            //Used to take the timeout on cancelling the values change
            $('span[id="'+field_name+'"]').attr('value', changed_value); // update data
            $('input[id="'+field_name+'"]').attr('value', changed_value); // update data

            //updates database
            $.post("/CI/api/updatedata",
                {
                    value: changed_value,
                    property:field_name,
                    changing:id,
                    fromwhere:data_value //from where should be updated
                },
                function(data, status){
                    console.log(data);
                  if(data=="SUCCESS")
                  {
                      message_notification="Data updated successfully!";
                      message_type="success";
                      message_title="Information: ";
                      message_delay=2000;;

                      notify(message_notification,message_type,message_title,message_delay);
                  }
                    else
                  {
                      message_notification="Reload the page and try again!";
                      message_type="danger";
                      message_title="Error:";
                      message_delay=2000;;

                      notify(message_notification,message_type,message_title,message_delay);
                  }
                });
        }
        else
        {
            notify(message_notification,message_type,message_title,message_delay);

            //Used to take the timeout on cancelling the values change
            $('span[id="'+field_name+'"]').attr('value', last_value); // update data
            $('span[id="'+field_name+'"]').html(last_value);
            $('input[id="'+field_name+'"]').val(last_value);
        }

        $('span[name="save-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-ok text-success hidden");
        $('span[name="cancel-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-remove text-danger hidden");
        $('span[name="edit-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-edit text-primary");

    });

    //Cancels the update of the profile information
    $('span[id="remove"]').click(function(e)
    {
        var  edit_link = $(e.target);
        var field_name= edit_link.attr('value');
        $('span[id="'+field_name+'"]').attr('class',"");
        $('input[id="'+field_name+'"]').attr('class',"hidden");

        //returns the last entered value without going to the database
        $('span[id="'+field_name+'"]').html($('span[id="'+field_name+'"]').attr('value'));

        $('span[name="save-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-ok text-success hidden");
        $('span[name="cancel-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-remove text-danger hidden");
        $('span[name="edit-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-edit text-primary");

    });
    /*---------------------------------------------End of profile treatment-------------------------------------------------*/


    //Notifying the user of the errors or changes
    if ($('.div_errors').hasClass('login_error')) {

        var message_notification = $('div[id="errors"]').attr('message_notification');
        var message_type = $('div[id="errors"]').attr('message_type');
        var message_title = $('div[id="errors"]').attr('message_title');
        var message_delay = $('div[id="errors"]').attr('message_delay');
        notify(message_notification,message_type,message_title,message_delay);
    }
});


//function that generates the notifications
function notify(message_notification,message_type,message_title,message_delay)
{
    $.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: message_title,
        message: message_notification,
        target: '_self'
    }, {
        // settings
        element: 'body',
        position: null,
        type: message_type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: message_delay,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-7 col-sm-6 col-md-4 col-lg-4 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
}

function reloadGraphs(refresh_old,refresh_new)
{
    console.log(refresh_new);
    console.log(refresh_old);
    if(refresh_old=="pie-graph")
        getPieData(loadPieChart);
    else if(refresh_old=="progress-graph")
        getProgressData(loadProgressChart);
    else if(refresh_old=="bar-graph")
        getBarData(loadBarChart);

    if(refresh_new=='bar-graph')
        getBarData(loadBarChart);
    else if(refresh_new=='progress-graph')
        getProgressData(loadProgressChart);
    else if(refresh_new=='pie-graph')
        getPieData(loadPieChart);

}