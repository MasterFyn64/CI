<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//function to help generate specific notification to the user
if ( ! function_exists('notification'))
{
    function notification($message_notification,$message_type,$message_title,$message_delay)
    {
        $error =  array('message_notification'=>$message_notification,'message_type'=>$message_type,'message_title'=>$message_title,'message_delay'=>$message_delay);

        return $error;
    }
}

//if user is logged this function retrieves the user data based of the type of the user
if ( ! function_exists('getUserSessionData'))
{

    function getUserSessionDataArray()
    {
        checkSessionStart();
        $user_data=$_SESSION['user_data'];
        $user_type=strtoupper(get_class($user_data));

        if($user_type=='DOCTOR')
        {
            $data= ['user_type'=>$user_type,'name'=>$user_data->getName(),'photo_url'=>$user_data->getPhotoUrl(),'room_number'=>$user_data->getRoomNumber(),'address'=>$user_data->getAddress(),'birthdate'=>$user_data->getBirthdate(),'photo_url'=>$user_data->getPhotoUrl(),'contacts'=>$_SESSION['contacts'],'room_number'=>$user_data->getRoomNumber(),'email'=>$user_data->getEmail()];
        }
        else if ($user_type=='USER')
        {
            $data= ['user_type'=>$user_type,'name'=>$user_data->getName(),'photo_url'=>$user_data->getPhotoUrl(),'room_number'=>"",'address'=>$user_data->getAddress(),'birthdate'=>$user_data->getBirthdate(),'photo_url'=>$user_data->getPhotoUrl(),'contacts'=>$_SESSION['contacts'],'email'=>$user_data->getEmail()];
        }

        return $data;
    }
}

//check if the session if started and if not starts the session
if ( ! function_exists('checkSessionStart'))
{

    function checkSessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
