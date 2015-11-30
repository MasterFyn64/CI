<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function index()
    {
        session_start();
        if(isset($_SESSION['id']))
        {
            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view("settings");
            $this->load->view("footer");
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