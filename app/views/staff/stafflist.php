<?php include APPROOT.'/views/inc/header.php'?>


    <div class="main-container">
        <div class="main-header">
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

                    if($data['access']->access ==2){

                        echo '<button><a href="'.URLROOT.'/staff/stafflist"><i class="fa fa-drivers-license-o"></i> VIEW STAFF</a></button>';
                    }
                
                ?>
                <button id="changePassword"><a href="#"><i class="fa fa-eraser"></i> EDIT PASSWORD</a></button>
               <button><a href="<?php echo URLROOT?>/pages/logout"><i class="fa fa-power-off"></i> LOG OUT</a></button>
               
            </div>

        </div>

        <div class="todo-container">
            <div class="todo-header"><i class="fa fa-address-card-o"></i> Staff Activity <span class="staff-activity-info">Please click on staff to view his/her activities</span></div>
            <div class="all-users">
                <div class="user-main">
                     <?php foreach($data['staff'] as $staff):?>

                     <li><a href="<?php echo URLROOT?>/staff/todaylist/<?php echo $staff->user_id?>" class="viewActivity"><?php echo $staff->first_name.' '.$staff->surname?></a></li>

                     <?php endforeach?>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal">
    <div class="loader"></div>
    </div>
    <div class="modal-page">

       <div class="modal-content">
          <button id="close">Close</button>

            <div class="staff-activity">
            </div>
       </div>

       <div id="response">
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

    
    var modal = $('.modal');
    var modalPage = $('.modal-page');
    var clearTask = $('#clearTasks');
    var clearResponse = $('#response');
    
    
    var d = new Date();

    var indexDate = d.getHours();

    var other = d.getHours('13:00:00');

});


</script>