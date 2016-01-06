<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


abstract class Person extends CI_Model{
    protected $id;
    protected $name;
    protected $photo_url;
    protected $address;
    protected $birthdate;
    protected $password_hash;
    protected $email;
    protected $contacts= array();


    public function getAppointmentsInformation($user_type){
        $appointments = $this->DB_Helper->getClassById($this->id, "appointment",$user_type); //add appointments to array to check on the view
        $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));

        return array("appointments" => $appointments, "patients" => $patients);
    }
    public function getMessagesInformation($user_type){
        checkSessionStart(); //check if user session has started, and if not start the session
        $user_data = $_SESSION['user_data']; //get user data
        if($user_type=="DOCTOR")
        {
            $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));
            $search = array();
            foreach($patients as $patient)
            {
                $search[]=$patient['person_id'];  //add appointments to array to check on the view

            }
            $name_messages=$this->DB_Helper->get_join(array("person", " message"), " message.user_id= person.id", array("message.user_id",$search),'Message','DESC','date_hour');
        }
        else if ($user_type=="USER")
        {
            $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));
            $name_messages=$this->DB_Helper->get_join(array("person", " message"), " message.doctor_id= person.id", array("message.doctor_id",$user_data->getDoctorId()),"Message",'DESC','date_hour');
            $_SESSION['doctor_id']=$user_data->getDoctorId();
        }
        return array("messages"=>$name_messages,"patients"=>$patients);
    }
    // GET & SET

    // ---------------------------------- GET PROPERTIES

    public function getPlans(){
        return $this->DB_Helper->getByUserId($this->id, "plan");
    }

    public function getPlansInformation($user_type)
    {

    }
    
    public function getContacts(){

        return $this->DB_Helper->getClassById($this->id,'contact');
    }

    public function setContacts($contacts){

      $this->contacts=$contacts;
    }
    
    // ---------------------------------- ADD PROPERTIES
    public function addMessage($message){
        $this->db->insert('message',$message);
    }

    
    public function addAppointment($appointment){
        $this->db->insert('appointment',$appointment);
    }
    
    public function addContact($contact){
        $contact->person_id = $this->id;
        if (!in_array($contact, $this->getContacts())){
            $this->DB_Helper->insertObject($contact, $this->DB_Helper->CONTACT);
        }
    }
}
