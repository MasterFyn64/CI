<?php

/* In the context of a class, static variables are on the class scope (not the object) scope, but unlike a const, their values can be changed.*/

class DB_Helper extends CI_Model{

static $DOCTOR = "doctor";
 static $USER = "User";
 static  $MESSAGE = "message";
 static  $APPOINTMENT = "appointment";
 static  $CONTACT = "contact";
 static  $PLAN = "plan";
 static  $EXERCISE = "exercise";
 static $COST_EXERCISE_INSTANCE = "exercise_instance";


    //get user by id
    public function getUserById($person_id){
        $query = $this->db->query("SELECT * FROM user JOIN person ON person.id = user.person_id WHERE user.person_id=".$person_id);

        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            if($query->num_rows()==1) // $query->row();
            {
                return $query->row(0, "User");
            }
        }
        return null;
    }

    //get doctor by id
    public function getDoctorById($person_id){
        $query = $this->db->query("SELECT * FROM doctor JOIN person ON person.id = doctor.person_id WHERE doctor.person_id=".$person_id);

        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            if ($query->num_rows() == 1) {
                return $query->row(0, "Doctor");
            }
        }

        return null;
    }

    //---------------------------------------------- ** Users  **-----------------------------------------

    public function insertObject($table, $values)
    {
        $this->db->insert($table,$values);
    }

    //Insert in the database
    //Receives the table name and the values (Associative array like on the database) an return the id of inserted element
    public function insertArray($table, $values){

        $this->db->insert($table, $values);

        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            return $this->db->insert_id();
        }
        return null;
    }


    // get objects by IDs
    public function getByUserId($user_id, $table){

        $query = $this->db->query("SELECT * FROM ".strtolower($table)." WHERE person_id=".$user_id);
        $error = $this->db->error();

        if($error['code']==0) //Check for any errors
        {
            return $query->result_array();
        }
        return null;
    }

    // get objects by IDs
    public function getByUserIdAndType($user_id, $table,$type,$order_table,$order){

        $temp =strtoupper($type);
        if($temp=="DOCTOR")
        {
            $query = $this->db->query("SELECT * FROM ".strtolower($table)." WHERE doctor_id=".$user_id." ORDER BY ".$order_table." ".$order);
        }
        else
            $query = $this->db->query("SELECT * FROM ".strtolower($table)." WHERE user_id=".$user_id." ORDER BY ".$order_table." ".$order);


        $item_array = array();

        $error = $this->db->error();

        if($error['code']==0) //Check for any errors
        {

            return $query->result_array();
        }
        return null;
    }

    //Get class by person_id (Appointment , contact )
    //user_type is used to make search on database rows where we have boths doctor_id and user_id
    public function getClassById($person_id,$class,$user_type=null,$order=null,$table_order=null){

        $result =  array();
        if($user_type!=null)
        {
            if($user_type=="DOCTOR")
                $query = $this->db->query("SELECT * FROM ".$class." WHERE doctor_id=".$person_id." ORDER BY date_hour DESC");
            else if($user_type=="USER")
                $query = $this->db->query("SELECT * FROM ".$class." WHERE user_id=".$person_id." ORDER BY date_hour DESC");
        }
        else
        {
            $query = $this->db->query("SELECT * FROM ".$class." WHERE person_id=".$person_id);
        }

        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            if ($query->num_rows() == 1)
            {
                $result[] =$query->row(0, $class);
                return  $result;
            }
            else
            {

                foreach ($query->result($class) as $row)
                {

                    $result[] = $row;
                }
                return $result;
            }
        }
        return null;
    }


    //Get person by id
    public function getPersonById($person_id){
        $query = $this->db->query("SELECT * FROM person WHERE id=".$person_id);


        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            if ($query->num_rows() == 1)

                return $query->row(0, "Person");
        }
        return null;
    }

    //Check if person exists by email
    public function checkPersonByEmail($email){
        $query = $this->db->query("SELECT * FROM person WHERE email='".$email."'");

        $error = $this->db->error();

        if($error['code']==0) //Check for any errors
        {

            if ($query->num_rows() == 0)
            {
                return true;
            }
        }
        return false;
    }


    //get table by table name as values
    public function get($table, $values=null){
        if($values!=null)
            $query= $this->db->get_where($table, $values);
        else
            $query=$this->db->get($table);
        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            return $query->result_array();
        }
        return null;
    }

    public function get_join($tables,$condition ,$where,$cast=null,$order=null,$table_order=null,$multiple_search=null){


        $this->db->select('*');
        $this->db->from($tables[0]);

        if(count($tables)>2)
        {
            for($i=1;$i<count($tables);$i++)
            {
                $this->db->join($tables[$i],$condition[$i-1]);
            }
        }
        else
            $this->db->join($tables[1],$condition);
        if($where!=null)
        {
            $this->db->where($where);
            if($multiple_search!=null) {
                for ($i = 0; $i < count($multiple_search[1]); $i++) {
                    if($i==0)
                        $this->db->where($multiple_search[0], $multiple_search[1][$i]);
                    else
                        $this->db->or_where($multiple_search[0], $multiple_search[1][$i]);
                }

            }
        }
        if($order!=null)
        {
            if($table_order!=null)
                $this->db->order_by($table_order,$order);
        }

        $query = $this->db->get();

        $error = $this->db->error();
        if($error['code']==0 && $cast!=null) //Check for any errors
        {
            return $query->custom_result_object($cast);
        }
        else
        {
            return $query->result_array();
        }
        return null;
    }


    //update table by table name, values and conditions
    public function update($table, $data,$where)
    {
       $this->db->update($table, $data,$where);
    }

}


/*
 *
 $this->db->trans_begin();

$this->db->query('AN SQL QUERY...');
$this->db->query('ANOTHER QUERY...');
$this->db->query('AND YET ANOTHER QUERY...');

if ($this->db->trans_status() === FALSE)
{
    $this->db->trans_rollback();
}
else
{
    $this->db->trans_commit();
}
 */



//  LAst query done ---> $str = $this->db->last_query();
