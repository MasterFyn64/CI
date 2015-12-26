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
        
    // GET & SET

    // ---------------------------------- GET PROPERTIES
    public function getMessagesInformation($user_type){
        checkSessionStart(); //check if user session has started, and if not start the session
        $user_data = $_SESSION['user_data']; //get user data
        if($user_type=="DOCTOR")
        {
            $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));
            $search = array();
            foreach($patients as $patient)
            {
                $search[]=$patient['person_id'];

            }
            $name_messages=$this->DB_Helper->get_join(array("person", " message"), " message.user_id= person.id", array("message.user_id",$search),'Message','DESC','date_hour');
        }
        else
        {
            $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));
            $name_messages=$this->DB_Helper->get_join(array("person", " message"), " message.doctor_id= person.id", array("message.doctor_id",$user_data->getDoctorId()),"Message");
            $_SESSION['doctor_id']=$user_data->getDoctorId();
        }
        return array("patients"=>$patients,"messages"=>$name_messages);
    }
    
    public function getPlans(){
        return $this->DB_Helper->getByUserId($this->id, "plan");
    }
    
    public function getAppointmentsInformation($user_type){
        $appointments = $this->DB_Helper->getClassById($this->id, "appointment",$user_type);
        $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));

        return array("appointments" => $appointments, "patients" => $patients);
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


        /*
        $date_hour = date("Y-m-d h:i:s");

        if($user_type=="DOCTOR")
        {
            if($is_array)
            {
                for($i=0;$i<count($user_ids);$i++)
                    $this->DB_Helper->insertArray('message',array('subject'=>$subject,'text'=>$content,'user_id'=>$user_ids[$i],'doctor_id'=>$this->id,'date_hour'=>$date_hour,'read_doctor'=>1));
            }
            else
            {
                $this->DB_Helper->insertArray('message',array('subject'=>$subject,'text'=>$content,'user_id'=>$user_ids,'doctor_id'=>$this->id,'date_hour'=>$date_hour,'read_doctor'=>1));
            }
        }
        else if ($user_type=="USER")
        {
            $this->DB_Helper->insertArray('message',array('subject'=>$subject,'text'=>$content,'user_id'=>$this->id,'doctor_id'=>$_SESSION['user_data']->getDoctorId(),'date_hour'=>$date_hour,'read_user'=>1));
        }
    }
    
    public function addPlan($plan){
        $plan->person_id = $this->id;
        if (!in_array($plan, $this->getPlans())){
            $this->DB_Helper->insertObject($plan, $this->DB_Helper->PLAN);
        }*/
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
