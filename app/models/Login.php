<?php
class Login{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


	// check username first

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

    // login in the user
    public function login($username, $password){
		
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
}




?>