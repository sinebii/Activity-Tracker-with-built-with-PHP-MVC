<?php include APPROOT.'/views/inc/header.php'?>
<div class="main-container">
    <div class="left-bar">

        <div class="login-container">

            <form id="login-form" action="<?php echo URLROOT?>/staff/register" method="POST">

                <input type="text"  name="name"placeholder="Enter name"><br>
                <?php if(isset($data['name_error'])){

                    echo $data['name_error'];
                }?>
                <input type="text"  name="surname"placeholder="Enter Surname"><br>

                <?php if(isset($data['surname_error'])){

                    echo $data['surname_error'];
                }?>

                <input type="text"  name="department"placeholder="Enter Department"><br>

                <?php if(isset($data['dept_error'])){

                echo $data['dept_error'];
                }?>
                <input type="email"  name="username"placeholder="Enter username"><br>
                
                <?php if(isset($data['username_error'])){

                echo $data['username_error'];
                }?>
                <input type="password"  name="password"placeholder="Enter password"><br>

                <?php if(isset($data['password_error'])){

                    echo $data['password_error'];
                    }?>
                <input type="password"  name="repassword"placeholder="Enter password again"><br>

                <?php if(isset($data['repassword_error'])){

                    echo $data['repassword_error'];
                    }?>
                <input type="submit" id="submitBtn" value="Login">

            </form>

        </div>
        
    </div>
    <div class="right-bar">

       
    </div>

    <div class="modal">

        <div class="loader"></div>

    </div>

</div>
<?php include APPROOT.'/views/inc/footer.php'?>

    
