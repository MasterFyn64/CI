<?php

class Message extends CI_Model
{
    protected $id;
    protected $date_hour;
    protected $text;
    protected $doctor_id;
    protected $user_id;
    protected $subject;
    protected $read_doctor;
    protected $read_user;
    protected $name;
    protected $from;

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setInformation($read_doctor,$read_user,$text,$subject,$date_hour,$doctor_id,$user_id,$from)
    {
        $this->date_hour=$date_hour;
        $this->text=$text;
        $this->doctor_id=$doctor_id;
        $this->user_id=$user_id;
        $this->subject=$subject;
        $this->read_doctor=$read_doctor;
        $this->read_user=$read_user;
        $this->from=$from;
    }
    /**
     * @return mixed
     */
    public function getReadDoctor()
    {
        return $this->read_doctor;
    }

    /**
     * @param mixed $read_doctor
     */
    public function setReadDoctor($read_doctor)
    {
        $this->read_doctor = $read_doctor;
    }

    /**
     * @return mixed
     */
    public function getReadUser()
    {
        return $this->read_user;
    }

    /**
     * @param mixed $read_user
     */
    public function setReadUser($read_user)
    {
        $this->read_user = $read_user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
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

    public function getArray()
    {
        return array('date_hour'=>$this->date_hour,'text'=>$this->text,'doctor_id'=>$this->doctor_id,'user_id'=>$this->user_id,'subject'=>$this->subject,'read_doctor'=>$this->read_doctor,'read_user'=>$this->read_user,'from'=>$this->from);
    }

}