<?php


    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

	$difficulty=$_POST["queDif"];
    $topic=$_POST["queTopic"];
	//$difficulty = 'easy';
	//$topic = 'for loop';


    $data = array("intent" => "filter", "queDif" => "$difficulty", "queTopic" => "$topic");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);


    $response = json_decode($result, true);
	
	echo $result;

    curl_close($ch);


?>