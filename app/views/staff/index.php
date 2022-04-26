<?php include APPROOT.'/views/inc/header.php'?>
<div class="main-container">
    <div class="left-bar">

        <div class="login-container">

            <form id="login-form" action="<?php echo URLROOT?>/index" method="POST">

                <input type="email" id="username" placeholder="Enter username"><br>
                <input type="password" id="password" placeholder="Enter password"><br>
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
    
