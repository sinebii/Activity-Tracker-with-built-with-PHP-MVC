<?php

class Adm{

    private $db;

    public function __construct()
    {
        
        $this->db = new Database();
    }


    public function getUsersForAdmin(){

        $this->db->query('SELECT * FROM users ORDER BY user_id ASC');
		
		$results = $this->db->resultSet();
		return $results;
        
    }

    public function getUserActivity($id){

        $this->db->query('SELECT * FROM todos WHERE user_id = :user_id ORDER BY todo_id DESC');
		$this->db->bind(':user_id',$id);
		$results = $this->db->resultSet();
		return $results;

    }

    public function userAccount($id){
		
		$this->db->query('SELECT * FROM users WHERE user_id = :user_id');
		$this->db->bind(':user_id',$id);
		$row = $this->db->single();
        return $row;
	}




}

?>