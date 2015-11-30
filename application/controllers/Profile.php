<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function index()
    {
        checkSessionStart(); //check if user session has started, and if not start the session

        if(isset($_SESSION['id'])) {
         // Both retrieve contact data and saves in the session global variable
            //Checks if is an user
            $result = $this->DB_Helper->getUserById($_SESSION['id']);
            if($result)
                $_SESSION['contacts'] = $this->DB_Helper->getByUserId($result->getId(), 'Contact');

            // if isn't a user checks if is a doctor
            if (!$result) {
                $result = $this->DB_Helper->getDoctorById($_SESSION['id']);
                $_SESSION['contacts'] = $this->DB_Helper->getByUserId($result->getId(), 'Contact');
            }

            //Updates user data to the session
            $_SESSION['user_data']=$result;

            //name used on the navBar (First Name)
            $_SESSION['name']=explode(" ",$result->getName())[0];

            //Load page parts
            $this->load->view("navbar",getUserSessionDataArray());//get all data to display for the user/doctor
            $this->load->view("profile");
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

    function do_upload()
    {
        checkSessionStart(); //check if user session has started, and if not start the session
        if (isset($_SESSION['id'])) {
            //Constant for all the photos
            $photo_url="_profile".$_SESSION['id'];

            //Image properties
            $config['upload_path'] = './assets/images/profile/';
            $config['allowed_types'] = 'jpg';
            $config['max_size'] = '2000000';
            $config['max_width'] = '20000';
            $config['max_height'] = '20000';
            $config['file_name'] = $photo_url;
            $config['overwrite']=true;


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload())
            {
                //Due the need of retrieving the users data with the message we created an helper to help us with processing all data needed

                $this->load->view("navbar",getUserSessionDataArray());
                $this->load->view('errors_notification',notification($this->upload->display_errors(). "And the image must be max 400x400 pixeis.","danger","Image Error:",1500));
                $this->load->view("profile");
                $this->load->view("footer");

            } else
            {

                //creation of the name for the profile image
                $photo_extension=$this->upload->data();
                $photo_extension = $photo_extension['file_ext'];
                $photo_url_extension="_profile".$_SESSION['id'].$photo_extension;


                //Resize de image uploaded
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/images/profile/'.$photo_url.$photo_extension;
                $config['maintain_ratio'] =false;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['width'] = '400';
                $config['height'] = '400';
                $this->load->library('image_lib', $config);

                if ( ! $this->image_lib->resize())
                {
                    echo $this->image_lib->display_errors();
                    echo $config['source_image'];
                }


                //Obtain and update user data
                $user_data=$_SESSION['user_data'];
                $user_data->setPhotoUrl($photo_url_extension);

                //Update user profile photo (database)
                $updated_data=['photo_url'=>$photo_url_extension];
                $this->DB_Helper->update('person',$updated_data,array('id'=>$_SESSION['id']));

                $_SESSION['user_data']=$user_data;

                //Obtain user data updated to send
                $data=getUserSessionDataArray();

                $this->load->view("navbar",$data);
                $this->load->view('errors_notification',notification("Your image has been uploaded successful","success","Image Success:",1500));
                $this->load->view("profile");
                $this->load->view("footer");
            }


        }

    }

}