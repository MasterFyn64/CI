<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function index()
    {

    }

    public function saveData()
    {
        session_start();

        if(!empty($_SESSION['user_data']) &&  !empty($_POST['property']) && !empty($_POST['value']) && !empty($_POST['id']) ) //check if the data isset and proceeds to saving data
        {
            $error=false;
            switch($_POST['property'])
            {
                case "address":
                {
                    if(!preg_match("/^[a-zA-Z0-9 ]+$/", $_POST['value']))
                    {
                        echo "Wrong Address!";
                        $error=true;
                    }
                }break;
                case "email":
                {
                    if(!filter_var($_POST['value'],FILTER_VALIDATE_EMAIL))
                    {
                        echo "Wrong email!";
                        $error=true;
                    }
                }break;
                case "birthdate":
                {
                    //check this
                }break;
                case "name":
                {
                    if(!preg_match("/^[a-zA-Z ]+$/", $_POST['value']))
                    {
                        echo "Wrong name!";
                        $error=true;
                    }
                }break;
                case "contact":
                {
                  //check this
                }break;
            }

            if(!$error)
            {
                $this->DB_Helper->update('person',array($_POST['property']=>$_POST['value']),array('id'=>$_POST['id']));
            }

        }
        else
        {
            echo "You don't have access";
        }
    }

}
