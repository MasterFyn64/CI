<?php

require_once __DIR__.'/Person.php';

class User extends Person{

    private $doctor_id;

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setDoctorId($doctor_id)
    {
        $this->doctor_id = $doctor_id;
    }
    public function getDoctorId()
    {
        return $this->doctor_id;
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

    public function getPasswordHash()
    {
        return $this->password_hash;
    }


}
