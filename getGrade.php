<?php

	session_start();

    //$ucid=$_POST["ucid"];

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "view_all_grades");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);

    curl_close($ch);

	$_SESSION['ucid']= $result['ucids'];
	$_SESSION['grade']= $result['grades'];
	$_SESSION['comms']=$result['comms'];


    echo $result;

?>