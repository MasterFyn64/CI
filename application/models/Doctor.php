<?php

require_once __DIR__.'/Person.php';

class Doctor extends Person{

    protected $room_number;
    
	public function getPatients()
    {
        $patients = $this->DB_Helper->get_join(array("user", "person"), "user.person_id = person.id", array("user.doctor_id" => $this->id));
        return $patients;
    }
    public function setRoomNumber($room_number)
    {
        $this->id = $room_number;
    }
    public function getRoomNumber()
    {
        return $this->room_number;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setPhotoUrl($photo_url)
    {
        $this->photo_url = $photo_url;
    }
    public function getPhotoUrl()
    {
        return $this->photo_url;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->password_hash;
    }


}