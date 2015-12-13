<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

    public function index()
    {
        session_start();

        if(isset($_SESSION['id']) && $_SESSION['user_type']=="Doctor")
        {

            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view("register");
            $this->load->view("footer");
        }
        else
        {
            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view('errors_notification',notification('Only doctors can access this resource!',"info","Access denied:",1500));
            $this->load->view("profile");
            $this->load->view("footer");
        }
    }

    public function insert()
    {
        checkSessionStart();
        //retrieving all form data
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];
        $contacts = $_POST['contact'];
        $birthdate = $_POST['birthdate'];
        $address  = $_POST['address'];
        $doctor =$_POST['id'];

        var_dump($_SESSION);
        $errors="";

        $s=strtotime($birthdate);

        //time verification
        if((time()-$s)<0){
           $errors.='Birthdate ('.$birthdate.') wrong!<br/>';
        }

        // name verification
        if(!preg_match("/^[a-zA-Z ]+$/", $name))
        {
            $errors.='<br/>Name: Please enter a correct name!';
        }

        //email verification
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $errors.='<br/>Email: Please a correct email!';
        }

        //password verification
        if($password!=$repeat_password)
        {
            $errors.='!<br/>Pasword: Please enter the same password in both fields';

        }


        if($errors=="") //If doesn't exist any error insert the data
        {
             if($this->DB_Helper->checkPersonByEmail($email)){ //checks if the email exists

                 //Insert user data and retrieve is ID
                  $insert_id= $this->DB_Helper->insertArray('person',array('email'=>$email,'name'=>$name,'password_hash'=> password_hash($password,PASSWORD_DEFAULT),'birthdate'=>$birthdate,'address'=>$address,'photo_url'=>'_profile.png'));

                 foreach($contacts as $contact)
                 {
                     //Insert is contacts
                     $this->DB_Helper->insertArray('contact',array('number'=>$contact,'person_id'=>$insert_id));
                 }

                 //insert is role
                 $this->DB_Helper->insertArray('user',array('person_id'=>$insert_id,'doctor_id'=>$doctor));

                 $this->load->view("navbar", getUserSessionDataArray());
                 $this->load->view('errors_notification', notification('User created correctly!', "success", "User creation: ", 3000));
                 $this->load->view("register");
                 $this->load->view("footer");

              }
              else
              {
                  $this->load->view("navbar",getUserSessionDataArray());
                  $this->load->view('errors_notification',notification('Enter other email!',"info","Email already taken:",3000));
                  $this->load->view("register");
                  $this->load->view("footer");
              }
        }
        else//in case of errors on the form
        {
            $this->load->view("navbar",getUserSessionDataArray());
            $this->load->view('errors_notification',notification($errors,"danger","Form Errors:",3000));
            $this->load->view("register");
            $this->load->view("footer");
        }

    }


}