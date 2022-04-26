<?php

function returnTime($user){

    foreach($user as $staff):

        $date_now = date("Y-m-d H:i:s");
        $start_time = new DateTime($staff->todo_time);
        $end_date = new DateTime(($date_now));
        $interval = $start_time->diff($end_date);

        
    return $interval->h;

    endforeach;

   


}

?>