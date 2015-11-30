<?php

class Contact extends CI_Model{
    private $person_id;
    private $number;


    //get and set  functions for the contact
    public function getPerson(){
        return $this->db_helper->get_person_by_id($this->person_id);
    }

    public function getPersonId()
    {
        return $this->id;
    }

    public function setPersonId($id)
    {
        return $this->id=$id;
    }
    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        return $this->number=$number;
    }
    public function equals(){

    }
}
