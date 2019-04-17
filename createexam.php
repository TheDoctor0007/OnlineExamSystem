<?php

    //$intent=$_POST["intent"];
	$pointList=$_POST["points"];
	$qIDList=$_POST["quesID"];
	
    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "publish_exam", "pointList"=>"$pointList", "questionID"=>"$qIDList");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);
	echo $result;   

    curl_close($ch);



?>