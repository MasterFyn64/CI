$(document).ready(function() {


    $('input[name^="state-"]').click(function()
    {
        var name= $(this).attr('name');
        var values = name.split("-");
        var number = values[1];
        var bar = "header-messages-"+number;
        var state =$(this).attr('value');

        var message_id=  $('div[id="'+bar+'"]').attr("send-message-to");

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
                    changing:message_id,
                    newstate:state
                },
                function(data,status)
                {
                    //
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
                        location.reload();
                    }



            });

    });
//--------------------------------------------------------------------


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
        $('span[id="'+field_name+'"]').attr('contenteditable',true).focus();
        $('span[name="save-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-ok text-success");
        $('span[name="cancel-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-remove text-danger");

    });

    //Save profile information and send notification with errors made
    $('span[id="save"]').click(function(e){

        var  edit_link = $(e.target);
        var field_name= edit_link.attr('value');
        $('span[id="'+field_name+'"]').attr('contenteditable',false);
        var changed_value=$('span[id="'+field_name+'"]').html();

        //in case of errors save the last value
        var last_value = $('span[id="'+field_name+'"]').attr('value');

        var error=false;
        message_notification=message_type=message_title=message_delay="";


        //needed to update appointments information
        var message_id=  $(this).parent().parent().parent().parent().children('span[id="send-message-to"]').html();
        var data_value=  $('.page-name').attr('id');

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
                //Confirm thisssss!!!!!!
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

            //updates database
            $.post("/CI/api/updatedata",
                {
                    value: changed_value,
                    property:field_name,
                    changing:message_id,
                    fromwhere:data_value //from where should be updated
                },
                function(data, status){
                   //
                });
        }
        else
        {
            notify(message_notification,message_type,message_title,message_delay);

            //Used to take the timeout on cancelling the values change
            $('span[id="'+field_name+'"]').attr('value', last_value); // update data
            $('span[id="'+field_name+'"]').html(last_value);
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
        $('span[id="'+field_name+'"]').attr('contenteditable',false);

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


function reloadPage()
{
    location.reload()
}


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