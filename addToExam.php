<?php

    $questionID=$_POST["questID"];
    $examID=$_POST["examID"];


	//$questionID = "5";

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "insert_question", "questionID" => "$questionID", "examID" => "$examID", );
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    curl_exec($ch);

	//echo $questionID;

    curl_close($ch);

?>