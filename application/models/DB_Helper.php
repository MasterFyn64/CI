<?php

/* In the context of a class, static variables are on the class scope (not the object) scope, but unlike a const, their values can be changed.*/

class DB_Helper extends CI_Model{

static $DOCTOR = "doctor";
 static $USER = "User";
 static  $MESSAGE = "message";
 static  $CONTACT = "contact";
 static  $PLAN = "plan";
 static  $EXERCISE = "exercise";
 static $COST_EXERCISE_INSTANCE = "exercise_instance";

    public function insertObject($table, $values)
    {
       /* public function insert($table, $values)
        {
        }*/
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

    // get objects by IDs
    public function getByUserId($user_id, $table){

           $query = $this->db->query("SELECT * FROM ".strtolower($table)." WHERE person_id=".$user_id);


        $item_array = array();

        $error = $this->db->error();

        if($error['code']==0) //Check for any errors
        {

            return $query->result_array();
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

    //get user by id
    public function getUserById($person_id){
        $query = $this->db->query("SELECT * FROM user JOIN person ON person.id = user.person_id WHERE user.person_id=".$person_id);

        $error = $this->db->error();
         if($error['code']==0) //Check for any errors
        {
            if($query->num_rows()==1) // $query->row();
            {
                $_SESSION['user_type'] = 'User';
                return $query->row(0, "User");
            }
        }
        return null;
    }

    //get docto by id
    public function getDoctorById($person_id){
        $query = $this->db->query("SELECT * FROM doctor JOIN person ON person.id = doctor.person_id WHERE doctor.person_id=".$person_id);

        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            if ($query->num_rows() == 1) {
                $_SESSION['user_type'] = 'Doctor';
                return $query->row(0, "Doctor");
            }
        }

        return null;
    }


    //get table by table name as values
    public function get($table, $values){
       $query= $this->db->get_where($table, $values);
        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
        {
            return $query->result_array();
        }
        return null;
    }

    public function get_join($tables,$condition ,$where){

        $this->db->select('*');
        $this->db->from($tables[0]);
        $this->db->join($tables[1],$condition);
        $this->db->where($where);
        $query = $this->db->get();

        $error = $this->db->error();
        if($error['code']==0) //Check for any errors
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
