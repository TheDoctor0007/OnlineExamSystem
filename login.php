<?php

	session_start();

    //$intent=$_POST["intent"];
    $username=$_POST["username"];
    $password=$_POST["password"];

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

		$_SESSION['username'] = $username;


    $data = array("intent" => "login", "username" => "$username", "password" => "$password");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);

    curl_close($ch);

    $response = json_decode($result, true);
    echo $response['check'] . ', ' . $response['is_prof'];

?>