<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function index()
    {
        //$this->load->view("welcome",array('id'=>$this->uri->segment(2)));
        session_start();
        session_destroy();
        header('location:'.base_url());
    }

}
