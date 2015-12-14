<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointments extends CI_Controller {

    public function index()
    {
        checkSessionStart();
        $type = $_SESSION['user_type'];

        $data = $_SESSION['user_data'];
        $data = $data->getAppointments($type,'date_hour','desc'); //getApointment

        $patients = $this->DB_Helper->get_join(array("user","person"),"user.person_id = person.id",array("user.doctor_id"=>"15"));

        $this->load->view('navbar',getUserSessionDataArray());
        $this->load->view('appointments',array("values"=>$data,"user_type"=>$type,"patients"=>$patients));
        $this->load->view('footer');
    }
}