<?php include APPROOT.'/views/inc/header.php'?>
<div class="main-container">
        
    <div class="main-header">
    <div class="topbar-menu">
                <button><a href="<?php echo URLROOT?>/staff/todo">TO DO</a></button>
               <button><a href="<?php echo URLROOT?>/pages/logout">LOG OUT</a></button>
              
            </div>

            <div id="currentime"> </div>
    </div>
       
        <div class="sidebar">
            <div class="profile-picture">
                <img src="<?php echo URLROOT?>/img/profile-photo.png">
            </div>
            <div class="user-name">
                <p><?php echo 'Hi, '.$_SESSION['user_name'].'-'.$_SESSION['user_surname']?></p>
            </div>
            <div class="sidebar-menu">
                <button><a href="<?php echo URLROOT?>/staff/todo"><i class="fa fa-edit"></i> TO DO</a></button>
                <?php
                if($data['access']->access ==1){

                    echo '<button><a href="'.URLROOT.'/admin"><i class="fa fa-drivers-license-o"></i> DASHBOARD</a></button>';
                }

                if($data['access']->access ==2){

                    echo '<button><a href="'.URLROOT.'/staff/stafflist"><i class="fa fa-drivers-license-o"></i> VIEW STAFF</a></button>';
                }
                 ?>
                <button id="changePassword"><a href="#"><i class="fa fa-eraser"></i> EDIT PASSWORD</a></button>
               <button><a href="<?php echo URLROOT?>/pages/logout"><i class="fa fa-power-off"></i> LOG OUT</a></button>
               
            </div>

        </div>
        <div class="todo-container">

            <div class="todo-header"><i class="fa fa-align-justify"></i> Task list 
            <button><a href="<?php echo URLROOT?>/staff/stafflist"> Go Back</a></button>
        
            </div>
            <div class="todo-list">
               
            <?php

            foreach($data['todo'] as $key=> $todo):?>
                <?php
                $date_now = date("Y-m-d H:i:s");
                $start_time = new DateTime($todo->todo_time);
                $end_date = new DateTime(($date_now));
                $interval = $start_time->diff($end_date);
                ?>
                <!-- add time with span tage and with id = time !-->
                <li class="<?php echo $todo->class ?>">
                    <?php echo $todo->todo.' - '.$interval->h.' Hr(s) ago'?><span><a class="finished" href="<?php echo URLROOT?>/staff/todo/<?php echo $todo->todo_id?>"><i class="fa fa-check-square"></i> Tick</a></span>
                </li>

                <?php endforeach?>
            </div>

        </div>

        <div class="modal">

        <div class="loader"></div>
        
        </div>

        <div id="response">
        </div>

        <div class="changePasswordModal">

            <div class="changePasswordModalContent">
            <button id="close">Close</button>

                <div class="changePasswordForm">

                    <form id="changePass" method="POST" action="#">

                        <input type="password" id="oldPass" placeholder="Old password">
                        <input type="password" id="newPass" placeholder="Enter New Password">
                        <input type="password" id="repassword" placeholder="Enter Password again">
                        <input type="submit" id="changePasswordBtn" value="Change">
                        
                        <span class="password-info">New password must contain 6-20 charaters, 1 uppercase, and 1 lowercase</span>

                    </form>
                    
                </div>

            </div>

            <div class="password-response">

            </div>

        </div>
    </div>
<?php include APPROOT.'/views/inc/footer.php'?>

<script>

    $(document).ready(function(){

        if($(window).width() < 700){

            var updated = $('.updated');
            var newText = $('.pending').text();


            $('.sidebar').removeClass();
            $('.todo-container').removeClass();
            $('.todo-form-container').removeClass();

            
        }

        startTime();


        function startTime(){

            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            $('#currentime').html("Time: " + h + ":" + m + ":" + s);

            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {

            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        var todoForm = $('#todoForm');
        var todoInput = $('#todo');
        var todoBtn = $('#todoBtn');
        var pending = $('.pending');
        
        
        
        var changePassword = $('#changePassword');
        var passwordModal = $('.changePasswordModal');
        var changePasswordBtn = $('#changePasswordBtn');
        
        

        resetbtn();

        function resetbtn(){

            todoBtn.prop('disabled', true);
            todoBtn.css('background', '#dfe6e9');
            todoBtn.css('cursor','auto');
        }

        todoInput.keyup(validateField);

        function validateField(){

            validateInput($(this));

            var error = $('.error');

            
            if(error.length > 0){

                todoBtn.prop('disabled', true);
                todoBtn.css('background', '#dfe6e9');
                todoBtn.css('cursor','auto');
            }else{

                todoBtn.prop('disabled', false);
                todoBtn.css('background','#3498db');
                todoBtn.css('cursor', 'pointer');

               

            }
        };


        function validateInput(field){

            if(field.val().length < 10){

                console.log('Description too short');
                field.css('border','1px solid red');
                field.addClass('error');
               

                //Disable button
                todoBtn.prop('disabled', true);
                todoBtn.css('background', '#dfe6e9');
                todoBtn.css('color', 'color');
                todoBtn.css('cursor','auto');
                
            }else{

                field.css('border','1px solid green');
                field.removeClass('error');
                todoBtn.prop('disabled', false);
                todoBtn.css('background', 'blue');
                todoBtn.css('color', 'white');
                todoBtn.css('cursor','pointer');
            }
        }


        
        todoForm.submit(function(e){


            e.preventDefault();
            
            var datastring = 'todo='+todoInput.val();

           $.ajax({

               url:'<?php echo URLROOT?>/staff/todo',
               type:'POST',
               datatype:'html',
               data:datastring,
               beforeSend:function(){

                var modal = $('.modal');
                    modal.css('display','block');
                    todoForm.trigger('reset');
                    resetbtn();

                setTimeout(function(){

                    modal.fadeOut('slow');

                },2000);

               },

               success:function(data){

                var response = $('#response');
                response.fadeIn('fast');
                response.html(data);

                setTimeout(function(){

                    response.fadeOut('slow');
                    $(".todo-list").load(location.href+" .todo-list>*","");
                    $(".todoForm").load(location.href+" .todoForm>*","");
            

                },2000);
                 
               }

           });
            

        });


        $(".finished").click(function(e){

            e.preventDefault();
            
            var url = $(this).attr('href');
            var parts = url.split('/');
            var todo_id = parts[parts.length-1];
            $(this).parent().parent().addClass('updated');
            var doneClass = 'updated';
            var datastring = 'todo_id='+todo_id+'&class='+doneClass;
           
           

           $.ajax({

            url:'<?php echo URLROOT?>/staff/upadtetodo',
            type:'GET',
            datatype:'html',
            data:datastring,

            beforeSend:function(){

            
            },
            success:function(data){

                var finsihedResponse = $('#response');
                
                $(".todo-list").load(location.href+" .todo-list>*","");
                
                finsihedResponse.fadeIn('fast');
                finsihedResponse.html(data);

                setTimeout(function(){

                    finsihedResponse.fadeOut('slow');

                },3000)

            }


           });
        })



        changePassword.click(function(e){
            
            e.preventDefault();
            passwordModal.fadeIn('slow');

           
           

        });

        $('#close').click(function(){

           passwordModal.fadeOut('fast');
           

        });


        changePasswordBtn.click(function(e){

                e.preventDefault();
                
                var oldPassword = $('#oldPass').val();
                var newPassword = $('#newPass').val();
                var rePassword = $('#repassword').val();
                var checkpassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
                var passwordResponse = $('.password-response');

                if(oldPassword.length < 6 ){

                    passwordResponse.append('Cannot be less than six characters');
                    passwordResponse.fadeIn('slow');
                    setTimeout(function(){

                        passwordResponse.fadeOut('fast');
                        passwordResponse.empty();

                    }, 2000);
                }else if(!newPassword.match(checkpassword) || newPassword !== rePassword){

                    passwordResponse.append('Bad format or Passwords do not match');
                    passwordResponse.fadeIn('slow');
                    setTimeout(function(){

                        passwordResponse.fadeOut('fast');
                        passwordResponse.empty();

                    }, 2000)
                        
                }else{

                    var datastring = 'oldpassword='+oldPassword+'&newpassword='+newPassword+'&repassword='+rePassword;
                    
                    $.ajax({

                        url:'<?php echo URLROOT?>/staff/changePassword',
                        type:'POST',
                        datatype:'html',
                        data:datastring,
                        beforeSend:function(){

                           
                        },
                        success:function(data){

                               passwordResponse.append(data);
                               passwordResponse.fadeIn('slow');
                    

                               setTimeout(function(){

                                passwordResponse.fadeOut('fast');
                                passwordResponse.empty();

                                $(".main-container").load(location.href+" .main-container>*","");

                               },3000)
                               
                        }
                        

                    });
                }

                

        });


        
        

    });

</script>



