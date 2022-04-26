<?php
class Pages extends Controller{

    public function __construct(){

        if(isLoggedIn()){

            redirect('staff/index');
        }

        $this->loginModel = $this->model('Login');
       
    }


    public function index(){


        if($_SERVER['REQUEST_METHOD']== 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [

                'username'=> trim($_POST['username']),
                'password'=> trim($_POST['password']),
                'username_error'=>'',
                'password_error'=>''
            ];

            if(empty($data['username'])){
                
                sleep(2);
                $data['username_error'] = 'Username name field cannot be blank';
            }

            if(empty($data['password'])){
                sleep(2);
                $data['password_error'] = 'Password cannot be blank';
            }

            if($this->loginModel->findUsername($data['username'])){

            }else{

                sleep(2);
                $data['username_error'] = 'Username not found';
            }

            if(empty($data['username_error']) && empty($data['password_error'])){

               $loginUser = $this->loginModel->login($data['username'], $data['password']);

               if($loginUser){
                   

                $this->createUserSession($loginUser);

               }else{

                $data['password_error'] = 'Password is Incorrect';

                $this->view('index', $data);
               }
            }else{

                $this->view('index', $data);
            }

        }else{

            $data = [

                'username'=>'',
                'password'=>'',
                'username_error'=>'',
                'password_error'=>''


            ];

            $this->view('index', $data);
        }

    }


    public function createUserSession($user){

        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_usernme'] = $user->username;
        $_SESSION['user_name'] = $user->first_name;
        $_SESSION['user_surname'] = $user->surname;

        redirect('staff/todo');

    }


    public function logout(){

        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_surname']);
        session_destroy();
        redirect('index');
    }

}

?>