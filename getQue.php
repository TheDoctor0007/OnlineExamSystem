<?php

    //$intent=$_POST["intent"];

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "view_questions");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);


    $response = json_decode($result, true);
    //$testoutpls = $response[1];
	echo $result;

    $top = $response["tops"];
    $dif = $response["diffs"];
    $que = $response["qsts"];
	

	//echo json_encode(array($top, $dif, $que));

    curl_close($ch);


?>