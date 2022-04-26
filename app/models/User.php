<?php

class User{

    private $db;

     public function __construct()
     {
         $this->db = new Database();
     }


     // find if a username exist from registration
     public function findUsername($username){

        $this->db->query('SELECT * FROM users WHERE username=:username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){

            return true;
        }else{

            return false;
        }

     }


     public function register($data){

        $this->db->query('INSERT INTO users (first_name, surname, dept, username, password_one) VALUES(:first_name, :surname, :dept, :username, :password_one)');
        $this->db->bind(':first_name', $data['name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':dept', $data['dept']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password_one', $data['password']);


        if($this->db->execute()){

            return true;
        }else{

            return false;
        }
     }


     public function userAccount($id){
		
		$this->db->query('SELECT * FROM users WHERE user_id = :user_id');
		$this->db->bind(':user_id',$id);
		$row = $this->db->single();
        return $row;
	}



     public function addTodo($data){

        $this->db->query('INSERT INTO todos (todo,todo_time,user_id,class, status) VALUES(:todo,:todo_time,:user_id,:class,:status)');
        $this->db->bind(':todo', $data['todo']);
        $this->db->bind(':todo_time', date("Y-m-d H:i:s"));
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':class', $data['class']);
        $this->db->bind(':status', $data['class']);
        
        if($this->db->execute()){
			
			return true;
			
		}else{
			return false;
		}
     }


     public function getUsertodos($id){
        
        $this->db->query('SELECT * FROM todos JOIN users USING(user_id)WHERE user_id = :user_id && status =:pending ORDER BY todo_id DESC');
        $this->db->bind(':user_id', $id);
        $this->db->bind(':pending', 'pending');
        $results = $this->db->resultSet();
		return $results;
        }


    public function getStaffTodos($id){

        $this->db->query('SELECT * FROM todos WHERE CURDATE() < todo_time  && user_id=:user_id ORDER BY todo_id DESC');
        $this->db->bind(':user_id', $id);
        $results = $this->db->resultSet();
		return $results;

    }

    public function getAccesslevel($id){

        $this->db->query('SELECT * FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $id);
        $row = $this->db->single();
        return $row;

    }

    public function getUsersForAdmin(){

        $this->db->query('SELECT * FROM users ORDER BY user_id ASC');
		
		$results = $this->db->resultSet();
		return $results;
        
    }

    public function updateTodo($data){

        $this->db->query('UPDATE todos SET class = :class WHERE todo_id = :todo_id');
		// Bind Values
	  	  $this->db->bind(':todo_id', $data['todo_id']);
		  $this->db->bind(':class',$data['class']);
		  //Execute
	  	if($this->db->execute()){
			return true;
		  } else {
			return false;
     }


    }


    public function upadateAllTasks($data){

        $this->db->query('UPDATE todos SET status = :status WHERE todo_id >= :todo_id');
        $this->db->bind(':status', $data['expired']);
        $this->db->bind(':todo_id', '1');
        if($this->db->execute()){
			return true;
		  } else {
			return false;
     }

    }


    public function changePassword($username, $password){
		
		
		$this->db->query('SELECT * FROM users WHERE username = :username');
		$this->db->bind(':username',$username);
		
		$row = $this->db->single();
		$hashed_password = $row->password_one;
		
		if(password_verify($password, $hashed_password)){
			
			return $row;
		}else{
			return false;
		}
    }
    

    public function verifyAccount($data){

        $this->db->query('SELECT * FROM users WHERE username = :username');
		$this->db->bind(':username',$data['username']);
		
		$row = $this->db->single();
		$hashed_password = $row->password_one;
		
		if(password_verify($data['oldpassword'], $hashed_password)){
			
			return $row;
		}else{
			return false;
		}
    }


    public function updatePassword($data){


        $this->db->query('UPDATE users SET password_one = :password WHERE username = :username');

        // Bind Values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['newpassword']);

        //Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
    }
    }

}
?>