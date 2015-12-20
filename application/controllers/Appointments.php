<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointments extends CI_Controller {

    public function index()
    {
        checkSessionStart(); //check if user session has started, and if not start the session
        if(isset($_SESSION['id'])) {
            $user_data = $_SESSION['user_data']; //get user data
            $user_type = strtoupper(get_class($user_data));
            $id = $user_data->getId();


            $appointments = $user_data->getAppointments(strtoupper($user_type)); //getAppointment
            $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $id));

            $this->load->view('navbar', getUserSessionDataArray());
            $this->load->view('appointments', array("appointments" => $appointments, "patients" => $patients));
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
}