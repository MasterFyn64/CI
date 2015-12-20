<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklogin extends CI_Controller {

    public function index()
    {
        $data=['email'=>$_POST['email']];
        $result = $this->DB_Helper->get('person',$data);

        if(!empty($result)) { //get result from email
            if(password_verify ($_POST['password'],  $result[0]['password_hash']))
            {
                session_start();
                //Save user id on the Session to known who logged in
                $_SESSION['id']= $result[0]['id'];
                //redirects user to the profile page
                header('location: '.base_url().'profile');
            }
            else
            {
                $this->load->view("header_login");
                //Sends notification to the user with the view
                $this->load->view('errors_notification',notification('Your password is wrong!','danger','Password Error: ',1000));
                $this->load->view("welcome");
                $this->load->view("footer");
            }

        }
        else {
            $this->load->view("header_login");
            //Sends notification to the user with the view
            $this->load->view('errors_notification',notification('Your email is wrong!','danger','Email Error: ',1000));

            $this->load->view("welcome");
            $this->load->view("footer");

        }
    }



}
