<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller {

    public function index()
    {
        checkSessionStart(); //check if user session has started, and if not start the session
        if(isset($_SESSION['id'])) {
            $user_data = $_SESSION['user_data']; //get user data
            $user_type = strtoupper(get_class($user_data));
            $id = $user_data->getId();

            $this->load->view('navbar', getUserSessionDataArray());
            $this->load->view('statistics');
            $this->load->view('footer');
            $this->load->view("loadstatistics");
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