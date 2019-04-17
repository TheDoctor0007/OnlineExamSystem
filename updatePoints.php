<?php

    $questionID=$_POST["quesID"];

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "update_point", "questionID" => "$questionID");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);

    curl_close($ch);

?>