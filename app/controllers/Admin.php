<?php
class Admin extends Controller{

    public function __construct()
    {

        if(!isLoggedIn()){

            redirect('index', $data);
        };

        $this->adminModel = $this->model('Adm');
        
    }


    public function index(){

        if(isset($_GET['staff'])){

            

            $staffActivity = $this->adminModel->getUserActivity($_GET['staff']);
            

            foreach($staffActivity as $staff){

                echo '<li class="'.$staff->class.'">'.$staff->todo.' @ '.$staff->todo_time.'</li> ';
            }

            

        }else{

            $staff = $this->adminModel->getUsersForAdmin();
            $user = $this->adminModel->userAccount($_SESSION['user_id']);

            $data = [

                'title'=>'Administrator',
                'staff'=>$staff,
                'user'=>$user

            ];

            if($data['user']->access ==0){

                redirect('staff/todo');
            }else{

                
            }

            $this->view('admin/index', $data);

            }
    }


    




}

?>