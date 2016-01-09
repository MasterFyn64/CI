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

        return array("appointments" => $appointments, "patients" => $this->getPatients());
    }
    public function getMessagesInformation($user_type){
        checkSessionStart(); //check if user session has started, and if not start the session
        $user_data = $_SESSION['user_data']; //get user data
        if($user_type=="DOCTOR")
        {
            $patients = $this->getPatients();
            $search = array();
            foreach($patients as $patient)
            {
                $search[]=$patient['person_id'];  //add appointments to array to check on the view
            }

            $name_messages=$this->DB_Helper->get_join(array("person", " message"), " message.user_id= person.id",array("message.doctor_id"=>$this->id),'Message','DESC','date_hour',array("message.user_id",$search));
        }
        else if ($user_type=="USER")
        {
            $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));
            $name_messages=$this->DB_Helper->get_join(array("person", " message"), " message.doctor_id= person.id", array("message.user_id"=>$this->id,"message.doctor_id"=>$user_data->getDoctorId()),"Message",'DESC','date_hour');
            $_SESSION['doctor_id']=$user_data->getDoctorId();
        }
        return array("messages"=>$name_messages,"patients"=>$patients);
    }

    public function getPlansInformation($user_type)
    {
        if($user_type=="DOCTOR")
        {
            //search for both user_data and doctor_plans and order by the same field to join after that
            $plans = $this->DB_Helper->get_join(array("plan","doctor"),"doctor.person_id=plan.doctor_id",array("doctor_id"=>$this->id),null,'desc','start_date');
            $user_data_plan = $this->DB_Helper->get_join(array("plan","user","person"),array("user.person_id=plan.user_id","user.person_id=person.id"),array("plan.doctor_id"=>$this->id),null,'desc','start_date');
        }
        else
        {
            //search for both doctor_data and user_plans and order by the same field to join after that
            $plans = $this->DB_Helper->get_join(array("plan","user"),"user.person_id=plan.user_id",array("user_id"=>$this->id),null,'desc','start_date');
            $user_data_plan = $this->DB_Helper->get_join(array("plan","person"),"plan.doctor_id=person.id",array("user_id"=>$this->id),null,'desc','start_date');
        }

        $values=array();
        $final_result = array();
        $patients = $this->getPatients();

        $count=0;
        foreach($plans as $plan)
        {
            //join the user_data to the plans
            if($user_type=="DOCTOR")
                $values['user_data']=$user_data_plan[$count];
            else
                $values['doctor_data']=$user_data_plan[$count];

            $values['plan']=$plan;
            $values['exercises'] = $this->DB_Helper->get_join(array("exercise","exerciseinstance"),"exerciseinstance.exercise_id=exercise.id",array("exerciseinstance.plan_id"=>$plan['id']));

            //save that plan to the final array
            $final_result[]=$values;

            //clear the array for the next plan
            $values=array();

            //var to iterate the user_data
            $count++;
        }
        //get exercises
        $exercises = $this->DB_Helper->get('exercise');

        return array("plans"=>$final_result,"patients"=>$patients,"defined_exercises"=>$exercises);
    }

    // GET & SET

    // ---------------------------------- GET PROPERTIES


    
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
