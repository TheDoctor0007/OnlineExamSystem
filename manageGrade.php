<?php


    $ucid=$_POST["ucid"];

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    //$data = array("intent" => "manage_grade", "username"=> $ucid);

    $data = array("intent" => "manage_grade", "username"=> $ucid);

    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);

    curl_close($ch);


    echo $result;

?>