<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function index()
    {

    }
public  function  removeInstance()
{
    getUserSessionDataArray();
    $doctor_id = $_SESSION['id'];
    if(!empty($_SESSION['user_data']) &&  !empty($_POST['remove'])) //check if the data isset and proceeds to saving data
    {
        $query=$this->DB_Helper->get('exerciseinstance',array('id'=>$_POST['remove']));//get exercise
        if(count($query)==1) {
            $query=$this->DB_Helper->delete('exerciseinstance',array('id'=>$_POST['remove'])); //remove instance of exercise
            echo "SUCCESS";
        }
        else
        {
            echo "ERROR";
        }

    }
    else
    {
        echo "ERROR";
    }
}
    public function remove()
    {
        getUserSessionDataArray();
        $doctor_id = $_SESSION['id'];
        if(!empty($_SESSION['user_data']) &&  !empty($_POST['remove'])) //check if the data isset and proceeds to saving data
        {
            $query = $this->DB_Helper->get('plan',array('id'=>$_POST['remove'],'doctor_id'=>$doctor_id));
            if(count($query)==1)
            {
                $query=$this->DB_Helper->get('exerciseinstance',array('plan_id'=>$_POST['remove']));//get exercises

                if(count($query)>0)
                    $this->DB_Helper->delete('exerciseinstance',array('plan_id'=>$_POST['remove']));//remove exercises
               $query=$this->DB_Helper->delete('plan',array('id'=>$_POST['remove'])); //remove plan

                var_dump($query);
               if(!$query)
                   echo "SUCCESS";
               else
                   echo "ERROR";
           }
            else
            {
                echo "ERROR";
            }

        }
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
                case "repetitions":
                {
                  //check this
                }break;
                case "duration":
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
                {
                    $this->DB_Helper->update('person',array($_POST['property']=>$_POST['value']),array('id'=>$_SESSION['id']));

                    echo "SUCCESS";
                }
                else if ($page=="appointment")
                {
                    $result= explode('-',$_POST['property']);
                    $property = $result[0];
                    $this->DB_Helper->update('appointment',array($property=>$_POST['value']),array('id'=>$_POST['changing']));
                    echo "SUCCESS";
                }
                else if($page=="plan")
                {
                    $result= explode('-',$_POST['property']);
                    $property = $result[0];
                    $this->DB_Helper->update('exerciseinstance',array($property=>$_POST['value']),array('id'=>$_POST['changing']));

                    echo "SUCCESS";
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
                echo "SUCCESS";
            }
            else
            {
                if(isset($_POST['user_id']))
                {
                    $user_id= $_POST['user_id'];
                    $appointment  = new Appointment();
                    $appointment->setInformation($description,$date." ".$hour,$user_id,$user_data->getId(),"","","pending",$type);
                    $appointment = $appointment->getArray();
                    $user_data->addAppointment($appointment);
                    echo "SUCCESS";
                }
                else
                    echo "id_error";
            }

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

        }
        else
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
                        $message->setInformation(1,0,$content,$subject,$date_hour,$user_data->getId(),$user_ids[$i],"DOCTOR");
                        $message = $message->getArray();
                        $user_data->addMessage($message);
                    }
                }
                else if ($user_type=="USER")
                {
                    $message  = new Message();
                    $message->setInformation(0,1,$content,$subject,$date_hour,$user_data->getDoctorId(),$user_data->getId(),"USER");
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

    public function getPieData(){
        //ver sessao iniciada....  getUserId()
        $data = array();
        array_push($data, array('Walking', 12.7));
        array_push($data, array('Still', 74.6));
        array_push($data, array('name' => 'Running',
            'y' => 12.8,
            'sliced' => true,
            'selected' => true
        ));
        array_push($data, array('Cycling', 1.2));
        array_push($data, array('Car', 15.6));

        echo json_encode($data);
    }

    public function getBarData(){
        //ver sessao iniciada....  getUserId()
        $data = array();
        $data["serie"] = array();
        array_push($data["serie"], array('name' => "Walking", "data" => array(72.4,78.1,74.8,73.0,71.4,71.1,70.2,82.3,84.4,79.8,82.1,81.6,73.1,81.2,78.8,84.2,71.8,76.4,70.1,80.2,77.8,84.6,80.2,82.4,84.1,81.1,76.2,71.7,78.4,77.5)));
        array_push($data["serie"], array('name' => "Still",   "data" => array(8.8,7.0,9.1,8.7,9.6,6.7,5.7,7.3,7.6,9.3,6.6,5.5,7.8,7.3,7.2,6.5,5.9,8.7,8.2,9.4,5.6,8.8,5.2,9.6,7.9,9.4,9.3,9.7,6.9,8.2)));
        array_push($data["serie"], array('name' => "Running", "data" => array(2.3,3.8,2.5,3.7,3.0,3.7,3.4,3.7,2.8,2.4,3.8,2.9,2.5,3.7,3.9,3.9,2.3,3.7,3.7,3.8,3.2,2.5,3.7,3.6,3.1,3.8,2.4,3.7,3.3,3.0)));
        array_push($data["serie"], array('name' => "Cycling", "data" => array(0,0,4,4,0,0,3,0,0,2,2,0,0,0,0,0,0,0,1,2,3,4,5,6,7,8,9,10,11)));
        array_push($data["serie"], array('name' => "Car",     "data" => array(16.5,10.8,9.4,10.3,15.8,18.3,17.5,6.5,5.0,6.4,5.3,9.7,16.,7.6,9.9,5.2,19.7,11.1,17.9,5.4,11.2,0.9,6.7,0.1,0.1,0.1,3.9,5.7,1.2,0.04)));

        $data["date"] = array('year' => date('Y', strtotime("-30 day")), "month" => date('m',strtotime("-30 day")), "day" => date('d',strtotime("-30 day")));

        echo json_encode($data);
    }

    public function getProgressData(){
        //ver sessao iniciada....  getUserId()
        $data = array();
        $data["serie"] = array();
        array_push($data["serie"], array('name' => "Walking", "data" => array(72.4,78.1,74.8,73.0,71.4,71.1,70.2,82.3,84.4,79.8,82.1,81.6,73.1,81.2,78.8,84.2,71.8,76.4,70.1,80.2,77.8,84.6,80.2,82.4,84.1,81.1,76.2,71.7,78.4,77.5)));


        $data["date"] = array('year' => date('Y', strtotime("-30 day")), "month" => date('m',strtotime("-30 day")), "day" => date('d',strtotime("-30 day")));

        echo json_encode($data);
    }
}
