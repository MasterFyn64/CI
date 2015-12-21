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
    public function getMessages(){
        return $this->DB_Helper->getByUserId($this->id, "message");
    }
    
    public function getPlans(){
        return $this->DB_Helper->getByUserId($this->id, "plan");
    }
    
    public function getAppointments($user_type){

        return $this->DB_Helper->getClassById($this->id, "appointment",$user_type);
    }
    
    public function getContacts(){

        return $this->DB_Helper->getClassById($this->id,'contact');
    }

    public function setContacts($contacts){

      $this->contacts=$contacts;
    }
    
    // ---------------------------------- ADD PROPERTIES
    public function addMessage($message){
        $message->person_id = $this->id;
        if (!in_array($message, $this->getMessages())){
            $this->DB_Helper->insertObject($message, $this->DB_Helper->MESSAGE);
        }
    }
    
    public function addPlan($plan){
        $plan->person_id = $this->id;
        if (!in_array($plan, $this->getPlans())){
            $this->DB_Helper->insertObject($plan, $this->DB_Helper->PLAN);
        }
    }
    
    public function addAppointment($appointment){
        $appointment->person_id = $this->id;
        if (!in_array($appointment, $this->getAppointments())){
            $this->DB_Helper->insertObject($appointment, $this->DB_Helper->APPOINTMENT);
        }
    }
    
    public function addContact($contact){
        $contact->person_id = $this->id;
        if (!in_array($contact, $this->getContacts())){
            $this->DB_Helper->insertObject($contact, $this->DB_Helper->CONTACT);
        }
    }
}
