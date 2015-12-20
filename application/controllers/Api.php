<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function index()
    {

    }

    public function updatedata()
    {
        getUserSessionDataArray();

        if(!empty($_SESSION['user_data']) &&  !empty($_POST['property']) && !empty($_POST['value'])) //check if the data isset and proceeds to saving data
        {
            $error=false;
            switch($_POST['property'])
            {
                case "address":
                {
                    if(!preg_match("/^[a-zA-Z0-9 ]+$/", $_POST['value']))
                    {
                        echo "Wrong Address!";
                        $error=true;
                    }
                }break;
                case "email":
                {
                    if(!filter_var($_POST['value'],FILTER_VALIDATE_EMAIL))
                    {
                        echo "Wrong email!";
                        $error=true;
                    }
                }break;
                case "birthdate":
                {
                    //check this
                }break;
                case "name":
                {
                    if(!preg_match("/^[a-zA-Z ]+$/", $_POST['value']))
                    {
                        echo "Wrong name!";
                        $error=true;
                    }
                }break;
                case "contact":
                {
                  //check this
                }break;
                case "private_note":
                {
                  //check this
                }break;
                case "public_note":
                {
                  //check this
                }break;
                case "description":
                {
                  //check this
                }break;
            }


            $page =$_POST['fromwhere'];

            if($page=="")
            {
                echo "Error changing data";
                die();
            }


            if(!$error)
            {
                if($page=="profile")
                $this->DB_Helper->update('person',array($_POST['property']=>$_POST['value']),array('id'=>$_SESSION['id']));
                else if ($page=="appointment")
                {
                    $result= explode('-',$_POST['property']);
                    $property = $result[0];
                    $this->DB_Helper->update('appointment',array($property=>$_POST['value']),array('id'=>$_POST['changing']));
                }


            }

        }
        else
        {
            echo "You don't have access";
        }
    }


    public function book()
    {
        getUserSessionDataArray();

        $user_data = $_SESSION['user_data'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $date = $_POST['date'];
        $hour = $_POST['hour'];
        $user_id= $_POST['user_id'];


        $error ="";

        if(empty($type)||empty($date)||empty($description)||empty($hour))
        {
            $error = "Please fill de missing fields";
        }
        else
        {
            if(!preg_match("/^[a-zA-Z]+$/",$type))
            {
                $error.= "Type is wrong!<br/>";
            }
            if(!preg_match("/^[a-zA-Z1-9 ]+$/",$description))
            {
                $error.= "Description is wrong!<br/>";
            }


            if(preg_match("/[0-9]{2}:[0-9]{2}$/",$hour))
            {
                $hour_array = explode(':',$hour);
                if($hour_array[0]>=25 ||$hour_array[1]<=0||$hour_array[1]>60||$hour_array[1]<0)
                {
                    $error.= "Time is wrong!<br/>";
                }
            }
            else
            {
                $error.= "Time is wrong!<br/>";
            }


            if(!preg_match("/^[a-zA-Z1-9 ]+$/",$description))
            {
                $error.= "Description is wrong!<br/>";
            }
        }




        if($error!="")
        {
            echo $error;
        }
        else
        {


            if($_SESSION['user_type']!="Doctor")
            {
                $this->DB_Helper->insertArray('appointment',array('description'=>$description,'date_hour'=>$date." ".$hour,'user_id'=>$_SESSION['id'],"doctor_id"=>$user_data->getDoctorId(),"state"=>"pending","type"=>$type,"private_note"=>"","public_note"=>""));
            }
            else
            {
                $this->DB_Helper->insertArray('appointment',array('description'=>$description,'date_hour'=>$date." ".$hour,'user_id'=>$user_id,"doctor_id"=>$user_data->getId(),"state"=>"pending","type"=>$type,"private_note"=>"","public_note"=>""));
            }


            echo "SUCCESS";
        }
    }
}
