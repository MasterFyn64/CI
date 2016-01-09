<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan extends CI_Controller {

    public function index()
    {
        checkSessionStart(); //check if user session has started, and if not start the session
        if(isset($_SESSION['id'])) {
            $user_data = $_SESSION['user_data']; //get user data
            $user_type = strtoupper(get_class($user_data));
            $id = $user_data->getId();
            $this->load->view('navbar', getUserSessionDataArray());
            $this->load->view('plan',$user_data->getPlansInformation($user_type));
            $this->load->view('footer');
        }
        else
        {
            $this->load->view("header_login");
            $this->load->view('errors_notification', notification('You must be logged in to access this page','info','Login Needed: ',1000));
            $this->load->view("welcome");
            $this->load->view("footer");
        }
    }

    public function addExercise()
    {
        getUserSessionDataArray();
        if(!empty($_SESSION['user_data']) &&  !empty($_POST['repetitions'])&&  !empty($_POST['duration'])&& !empty($_POST['days'])&& !empty($_POST['planID'])) //check if the data isset and proceeds to saving data
        {
            $days_string="0-0-0-0-0-0-0"; // days that the exercise must be done
            for($i=0;$i<count($_POST['days']);$i++)
            {
                switch($_POST['days'][$i])
                {
                    case 'sunday':
                    {
                        $days_string[0]=1;
                    }break;
                    case 'monday':
                    {
                        $days_string[2]=1;
                    }break;
                    case 'tuesday':
                    {
                        $days_string[4]=1;
                    }break;
                    case 'wednesday':
                    {
                        $days_string[6]=1;
                    }break;
                    case 'thursday':
                    {
                        $days_string[8]=1;
                    }break;
                    case 'friday':
                    {
                        $days_string[10]=1;
                    }break;
                    case 'saturday':
                    {
                        $days_string[12]=1;
                    }break;
                }
            }

            if($_POST['choose-exercise']=="insert-exercise")
            {
               $exercise_id = $this->DB_Helper->insertArray('exercise',array('exercise_description'=>$_POST['exercise-description'],'name'=>$_POST['exercise-name']));
                $this->DB_Helper->insertArray('exerciseinstance',array('days'=>$days_string,'plan_id'=>$_POST['planID'],'duration'=>$_POST['duration'],'repetitions'=>$_POST['repetitions'],'exercise_id'=>$exercise_id));
            }
            else if ($_POST['choose-exercise']=="select-exercise")
            {
                for($i=0;$i<count($_POST['chosenExercise']);$i++)
                {
                    $this->DB_Helper->insertArray('exerciseinstance',array('days'=>$days_string,'plan_id'=>$_POST['planID'],'duration'=>$_POST['duration'],'repetitions'=>$_POST['repetitions'],'exercise_id'=>$_POST['chosenExercise'][$i]));
                }
            }
            else
            {
                $this->load->view("navbar",getUserSessionDataArray());
                $this->load->view('errors_notification', notification('Error inserting try again!','danger','Insert: ',2000));
                $this->load->view("plan");
                $this->load->view("footer");
                header("Refresh: 2; url=".base_url()."plan"); // wait 2 seconds and redirects
                return;
            }
            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view('errors_notification', notification('New exercise inserted correctly!','success','Insert: ',2000));
            $this->load->view("plan");
            $this->load->view("footer");
            header("Refresh: 2; url=".base_url()."plan"); // wait 2 seconds and redirects
        }
        else
        {
            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view('errors_notification', notification('Missing some fields!','danger','Insert: ',2000));
            $this->load->view("plan");
            $this->load->view("footer");
            header("Refresh: 2; url=".base_url()."plan"); // wait 2 seconds and redirects
            return;
        }
    }

    public function insert()
    {
        getUserSessionDataArray();
        $doctor_id = $_SESSION['id'];
        if(!empty($_SESSION['user_data']) &&  !empty($_POST['start-date'])&&  !empty($_POST['patient'])&& !empty($_POST['end-date'])&&!empty($_POST['description'])) //check if the data isset and proceeds to saving data
        {
            //verification
            $end_date = DateTime::createFromFormat('Y-m-d',$_POST['end-date'] );
            $start_date = DateTime::createFromFormat('Y-m-d',$_POST['start-date'] );
            $description= preg_match('/[a-zAZ ]*$/',$_POST['description']);
            if($end_date&&$start_date&&$description)
            {
                $this->DB_Helper->insertArray('plan',array('start_date'=>$_POST['start-date'],'end_date'=>$_POST['end-date'],'description'=>$_POST['description'],'user_id'=>$_POST['patient'],'doctor_id'=>$doctor_id));

                $this->load->view("navbar",getUserSessionDataArray());
                $this->load->view('errors_notification', notification('Plan inserted correctly','success','Insert: ',3000));
                $this->load->view("plan");
                $this->load->view("footer");
                header("Refresh: 2; url=".base_url()."plan"); // wait 2 seconds and redirects to other page
            }
            else
            {
                $this->load->view("navbar",getUserSessionDataArray());
                $this->load->view('errors_notification', notification('Error inserting plan! Please try again','danger','Insert: ',3000));
                $this->load->view("plan");
                $this->load->view("footer");
                header("Refresh: 2; url=".base_url()."plan"); // wait 2 seconds and redirects to other page
            }

        }
        else
        {
            header("Refresh: 2; url=".base_url()."plan"); // wait 2 seconds and redirects to other page
            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view('errors_notification', notification('Error inserting plan! Please try again','danger','Insert: ',3000));
            $this->load->view("plan");
            $this->load->view("footer");



        }
    }
}