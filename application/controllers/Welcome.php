<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index()
    {
        session_start();
        if(!isset($_SESSION['user_data']))
        {
            //$this->load->view("welcome",array('id'=>$this->uri->segment(2)));
            $this->load->view("header_login");
            $this->load->view("welcome");
            $this->load->view("footer");
        }
        else//User is logged in
        {
            header("location:".base_url()."profile");
        }

    }

}
