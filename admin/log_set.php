<?php
if(isset($update_product)){
    $event = 'Update Room';
    $logs = array();
    
    if($name != $old_name){
        array_push($logs,"name");
    }
    if($price != $old_price){
        array_push($logs,"price");;
    }
    if($stock != $old_stock){
        array_push($logs,"stock");
    }
    if($category != $old_category){
        array_push($logs,"category");
    }
    if($details != $old_details){
        array_push($logs,"details");
    }

    if(count($logs) > 1){
        $lastItem = array_pop($logs);
        $text = implode(', ', $logs); 
        $text .= ' and '.$lastItem;
    }else{
        $lastItem = array_pop($logs);
        $text .= ''.$lastItem;
    }

    $log = 'Updated the product '.$text.' of '.$name;

    $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
    $logDat->execute([$uname, $event, $log]);
}

?>