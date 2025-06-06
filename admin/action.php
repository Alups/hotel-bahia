<?php

include '../components/connect.php';

if(isset($_POST["action"]))
{
	// Modify this part of the script to fetch weekly bookings
$search_query = '';
if (isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '') {
    $search_query .= 'WHERE check_in >= "'.$_POST["start_date"].'" AND check_out <= "'.$_POST["end_date"].'" ';
}
// ...

}

?>
