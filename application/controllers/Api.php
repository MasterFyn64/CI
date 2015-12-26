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
            if($_SESSION['user_type']!="DOCTOR")
            {
                $appointment  = new Appointment();
                $appointment->setInformation($description,$date." ".$hour,$_SESSION['id'],$user_data->getDoctorId(),"","","waiting",$type);
                $appointment = $appointment->getArray();
                $user_data->addAppointment($appointment);
            }
            else
            {
                $user_id= $_POST['user_id'];
                $appointment  = new Appointment();
                $appointment->setInformation($description,$date." ".$hour,$user_id,$user_data->getId(),"","","pending",$type);
                $appointment = $appointment->getArray();
                $user_data->addAppointment($appointment);
            }

            echo "SUCCESS";
        }
    }

    public function updatestate()
    {
        $new_state= $_POST['newstate'];
        $id= $_POST['changing'];

        if(!empty($new_state)&&($new_state=="pending"||$new_state=="waiting"||$new_state=="done"||$new_state=="cancelled"))
        {
            $this->DB_Helper->update('appointment',array("state"=>$new_state),array('id'=>$id));
            echo "SUCCESS";
            die();
        }
        echo "ERROR";

    }

    public function sendmessage()
    {
        checkSessionStart();
        $date_hour = date("Y-m-d h:i:s");
        $user_data =$_SESSION['user_data'];
        $user_type= strtoupper(get_class($user_data));
        if(isset($_POST['content'])&&isset( $_POST['subject']))
        {
            $content= $_POST['content'];
            $subject = $_POST['subject'];
            if(!empty($content)&&!empty($subject))
            {
                if(isset($_POST['user_ids'])&&$user_type=="DOCTOR")
                {
                    $user_ids= $_POST['user_ids'];
                    for($i=0;$i<count($user_ids);$i++)
                    {
                        $message  = new Message();
                        $message->setInformation(1,0,$content,$subject,$date_hour,$user_data->getId(),$user_ids[$i]);
                        $message = $message->getArray();
                        $user_data->addMessage($message);
                    }
                }
                else if ($user_type=="USER")
                {
                    $message  = new Message();
                    $message->setInformation(0,1,$content,$subject,$date_hour,$user_data->getDoctorId(),$user_data->getId());
                    $message = $message->getArray();
                    $user_data->addMessage($message);
                }
                else if($user_type=="DOCTOR")
                {
                    echo "ids_error";
                }
            }
            else
            {
                echo "fields_error";
            }

        }
    }

    public function updatemessage()
    {
        checkSessionStart();
        if(isset($_SESSION['id'])&&isset($_POST['message_number']))
        {
            if(preg_match('/^[0-9]*$/',$_POST['message_number']))
            {
                if($_SESSION['user_type']=='DOCTOR')
                    $this->DB_Helper->update('message',array('read_doctor'=>1),array('id'=>$_POST['message_number']));
                else
                    $this->DB_Helper->update('message',array('read_user'=>1),array('id'=>$_POST['message_number']));
            }
            else
                echo "Message Wrong";
        }
        else
            echo "Message is not set!";
    }
}
