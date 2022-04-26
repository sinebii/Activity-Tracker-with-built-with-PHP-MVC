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
                <button><a href="<?php echo URLROOT?>/staff/register"><i class="fa fa-user-plus"></i> CREATE STAFF</a></button>
               <button><a href="<?php echo  URLROOT?>/admin"><i class="fa fa-drivers-license-o"></i> DASHBOARD</a></button>
               <button id="clearTasks"><a href="#"><i class="fa fa-trash"></i> CLEAR TASKS</a></button>
               <button><a href="<?php echo URLROOT?>/pages/logout"><i class="fa fa-power-off"></i> LOG OUT</a></button>
               
            </div>

        </div>

        <div class="todo-container">
            <div class="todo-header"><i class="fa fa-address-card-o"></i> Staff Activity <span class="staff-activity-info">Please click on staff to view his/her activities</span></div>
            <div class="all-users">
                <div class="user-main">
                     <?php foreach($data['staff'] as $staff):?>

                     <li><a href="<?php echo URLROOT?>/admin/<?php echo $staff->user_id?>" class="viewActivity"><?php echo $staff->first_name.' '.$staff->surname?></a></li>

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

    


$('.viewActivity').click(function(e){

    e.preventDefault();
    var url = $(this).attr('href');
    var parts = url.split('/');
    var userid = parts[parts.length-1];
    var datastring = 'staff='+userid;
    modal.fadeIn('slow');
    
    setTimeout(function(){

        modal.fadeOut('slow');

        $.ajax({

            url:'<?php echo URLROOT?>/admin/staffActivity',
            type:'GET',
            dataType:'html',
            data:datastring,
            beforeSend: function(){
               
            },
            success:function(data){

               $('.staff-activity').html(data);
               
            }

        });
        modalPage.fadeIn('slow');

    }, 4000);

    
})

$('#close').click(function(){

  modalPage.fadeOut('fast');
})



clearTask.click(function(e){

e.preventDefault();

var expired = 'Expired';
var datastring = 'expired='+expired;

$.ajax({

   url:'<?php echo URLROOT?>/staff/cleartodos',
   type:'POST',
   datatype:'html',
   data:datastring,
   beforeSend:function(){
        alert('Sending Request....');
   },
   success:function(data){

       alert(data);
   }


});

});

});


</script>