<?php include APPROOT.'/views/inc/header.php'?>
<div class="main-container">
    <div class="main-header">
    </div>
       
        <div class="login-container">

            <form id="login-form" action="<?php echo URLROOT?>/index" method="POST">

                <input type="email" id="username" name="username"placeholder="Enter name"><br>
                <?php if(isset($data['username_error'])){

                    echo $data['username_error'];
                    
                }?>
                <input type="password"  id="password"name="password"placeholder="Enter password"><br>
                <?php if(isset($data['password_error'])){
                    echo $data['password_error'];
                }?>
                <input type="submit" id="submitBtn" value="Login">

            </form>

        </div>
        
    

    <div class="modal">

        <div class="loader"></div>
        

    </div>
    <div class="pageLoader">

            <div class="company-name">SKYSHORE</div>

    <div class="loader"></div>
    </div>

</div>
<?php include APPROOT.'/views/inc/footer.php'?>
<script>

$(document).ready(function(){
    
    var loginForm = $('#login-form');
    var username = $('#username');
    var password = $('#password');
    var btn = $('#submitBtn');

    var pageLoader = $('.pageLoader');
    
    pageLoader.css('display','block');

    setTimeout(function(){

        pageLoader.fadeOut('slow');

    }, 5000)
    

    // disable submit button

    btn.prop('disabled', true);
    btn.css('background', '#dfe6e9');
    btn.css('cursor', 'auto');

    username.blur(validateField);
    password.blur(validateField);


    function validateField(){

      
        validateInput($(this));

        var error = $('.error');
        

        if(username.val() !='' && password.val() != ''){

            if(error.length ==0){

                btn.prop('disabled', false);
                btn.css('background','#3498db');
                btn.css('color','white');
                btn.css('cursor', 'pointer');
            }else{
                
                
            }
        }
     
    }


    function validateInput(field){

        if(field.val() == ''){

        field.css('border','1px solid red');
        field.addClass('error');

        // disable button
        btn.prop('disabled', true);
        btn.css('background', '#dfe6e9');
        btn.css('cursor', 'auto');
        

        }else{

        field.css('border','1px solid green');
        field.removeClass('error'); 
        };

    }


    loginForm.submit(function(e){


        var modal = $('.modal');
        modal.css('display','block');

    setTimeout(function(){

        modal.fadeOut('slow');

    },4000);
       
    });
});


</script>

    
