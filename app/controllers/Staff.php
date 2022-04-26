<?php

class Staff extends Controller{

    public function __construct()
    {

        if(!isLoggedIn()){

            redirect('index', $data);
        }
        
        $this->staffModel = $this->model('User');
    }

    public function index(){

        redirect('staff/todo');
    }


    public function todo(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $user = $this->staffModel->userAccount($_SESSION['user_id']);

            $data = [

                'user_id'=>$user->user_id,
                'todo'=>trim($_POST['todo']),
                'class'=>'pending'           
            ];
            

            if($this->staffModel->addTodo($data)){

                sleep(1);
                echo 'Task was sucessfully added';
            }


        }else{


                $user = $this->staffModel->getUsertodos($_SESSION['user_id']);
                $access = $this->staffModel->getAccesslevel($_SESSION['user_id']);

                $data = [

                    'todo'=>$user,
                    'access'=>$access
                ];
        
                $this->view('staff/todo', $data);

            }
            
        
    }


    public function stafflist(){

            $staff = $this->staffModel->getUsersForAdmin();
            $user = $this->staffModel->userAccount($_SESSION['user_id']);
            $access = $this->staffModel->getAccesslevel($_SESSION['user_id']);

            $data = [

                'title'=>'Administrator',
                'staff'=>$staff,
                'user'=>$user,
                'access'=>$access

            ];

            if($data['user']->access ==0){

                redirect('staff/todo');
            }else{

                
            }

            $this->view('staff/stafflist', $data);

    }


    public function todaylist($id){

        $user = $this->staffModel->getStaffTodos($id);
        $access = $this->staffModel->getAccesslevel($_SESSION['user_id']);

                $data = [

                    'todo'=>$user,
                    'access'=>$access,
                    
                ];
        $this->view('staff/todaylist', $data);
    }


    public function cleartodos(){


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['expired']) && !empty($_POST['expired'])){

                 $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                 $data = [

                     'expired'=>trim($_POST['expired'])

                 ];

                 if($this->staffModel->upadateAllTasks($data)){

                     echo "Tasks have been cleared";
                 }

            }

         }



    }


    public function register(){

        

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //process form


            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [

                    'name'=>trim($_POST['name']),
                    'surname'=>trim($_POST['surname']),
                    'dept'=>trim($_POST['department']),
                    'username'=>trim($_POST['username']),
                    'password'=>trim($_POST['password']),
                    'repassword'=>trim($_POST['repassword']),
                    'name_error'=>'',
                    'surname_error'=>'',
                    'dept_error'=>'',
                    'username_error'=>'',
                    'password_error'=>'',
                    'repassword_erro'=>''

            ];


            // Validation

            // validate name

            if(empty($data['name'])){

                $data['name_error'] = 'Please enter a valid name';
            }

            //validate surname

            if(empty($data['surname'])){

                $data['surname_error'] = 'Please enter a valid surname';
            }

            //validate dept

            if(empty($data['dept'])){

                $data['dept_error'] = 'Please enter a valid Department';
            }

            //validate username
            if(empty($data['username'])){

                $data['username_error'] = 'Please enter a valid username';
            }else{

                if($this->staffModel->findUsername($data['username'])){

                    $data['username_error'] = 'username already exist';

                }
            }

            //validate password
            if(empty($data['password'])){

                $data['password_error'] = 'Please enter a valid password';
            }elseif(strlen($data['password']) < 6){

                $data['password_error'] = 'Password must be greater than 6';
            }

            if(empty($data['repassword'])){

                $data['repassword_error'] = 'Please Confirm password';
            }else{

                if($data['password']!== $data['repassword']){

                    $data['repassword_error'] = 'Passwords do not match';
                }
            }


            if(empty($data['name_error']) && empty($data['surname_error']) && empty($data['dept_error']) && empty($data['username_error']) && empty($data['password_error']) && empty($data['repassword_error'])){

                // Validated

                //has the password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if($this->staffModel->register($data)){

                    redirect('admin');

                }else{

                    die("Something Went wrong");
                };
                
            }else{
                $this->view('staff/register', $data);
            }
        }else{

            $data = [

                'name'=>'',
                'surname'=>'',
                'dept'=>'',
                'username'=>'',
                'password'=>'',
                'repassword'=>''

            ];
            $this->view('staff/register', $data);
        }
    }


    public function upadtetodo(){


        if(isset($_GET['todo_id']) && isset($_GET['class'])){

           $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
           
           $data = [

                'todo_id'=>trim($_GET['todo_id']),
                'class'=>trim($_GET['class'])
                
           ];

           if($this->staffModel->updateTodo($data)){

                echo 'Updated Successfully ';
           }


        }else{

            echo 'BAD REQUEST';
        }
    }


    public function changePassword(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [

                'username'=>$_SESSION['user_usernme'],
                'oldpassword'=>trim($_POST['oldpassword']),
                'newpassword'=>trim($_POST['newpassword'])

            ];

            $verifyAccount = $this->staffModel->verifyAccount($data);

            if($verifyAccount){

                $data['newpassword'] = password_hash($data['newpassword'], PASSWORD_DEFAULT);

                if($this->staffModel->updatePassword($data)){

                        echo 'Password was changed successfully';
                }


            }else{

                echo 'Old password incorrect';
                return false;
            }

            
        }


    }
}

?>