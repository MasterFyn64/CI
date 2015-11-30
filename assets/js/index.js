$(document).ready(function() {
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

        var error=false;
        message_notification=message_type=message_title=message_delay="";
        switch (field_name) //checks what field will be updated
        {
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
            var user_id=$('div[name="user_id"]').attr('id');
            //updates database
            $.post("/CI/api/saveData",
                {
                    value: changed_value,
                    property:field_name,
                    id:user_id
                },
                function(data, status){
                    console.log("Data: " + data + "\nStatus: " + status);
                });
        }
        else
        {
            notify(message_notification,message_type,message_title,message_delay);
            setTimeout(reloadPage,3000);
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
        var changed_value=$('span[id="'+field_name+'"]').html();

        $('span[name="save-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-ok text-success hidden");
        $('span[name="cancel-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-remove text-danger hidden");
        $('span[name="edit-'+field_name+'"]').attr('class',"glyphicon glyphicon-profile glyphicon-edit text-primary");

        setTimeout(reloadPage,0);
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