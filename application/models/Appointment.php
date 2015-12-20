<?php

class Appointment extends CI_Model{
    private $id;
    private $description;
    private $date_hour;
    private $user_id;
    private $doctor_id;
    private $private_note;
    private $public_note;
    private $state;
    private $type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDateHour()
    {
        return $this->date_hour;
    }

    /**
     * @param mixed $date_hour
     */
    public function setDateHour($date_hour)
    {
        $this->date_hour = $date_hour;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDoctorId()
    {
        return $this->doctor_id;
    }

    /**
     * @param mixed $doctor_id
     */
    public function setDoctorId($doctor_id)
    {
        $this->doctor_id = $doctor_id;
    }

    /**
     * @return mixed
     */
    public function getPrivateNote()
    {
        return $this->private_note;
    }

    /**
     * @param mixed $private_note
     */
    public function setPrivateNote($private_note)
    {
        $this->private_note = $private_note;
    }

    /**
     * @return mixed
     */
    public function getPublicNote()
    {
        return $this->public_note;
    }

    /**
     * @param mixed $public_note
     */
    public function setPublicNote($public_note)
    {
        $this->public_note = $public_note;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}
