<?php
    	session_start();

	$input = file_get_contents('php://input');
   	$json = json_decode($input, true);
	//print($input);
	echo $input;
	
	$qIDs = $json['eqids'];
	$function = $json['eqans'];
	$points = $json['eqpts'];
	$multiplier = array();
	for ($i = 0; $i < count($points); $i++) {
		$multiplier = array_pad($multiplier, ($i+1), $points[$i]/10);
		//echo $multiplier[$i];
		//echo "<br>";
	}
	//$multiplier = array($points[0]/10, $points[1]/10);
	//$user = $_SESSION['username'];
	$user = 'prm46';
    $funcName = $json['eqfname'];
    $qType = $json['eqtype'];
    $testCase1 = $json['eqins'];
    $testOut1 = $json['eqouts'];
    $eID = $json['eid'];
	$eID = 1;
	//echo json_encode($json);

/*
	//testing stuff
	$qIDs = array(77,125);
	$eID = 1;
	
	$testCase = array(5, 3);	
    $testOut = array(120, 6);
	
	$testCase2 = array(3, 6);	
    $testOut2 = array(6, 12);
	
	$testCase1 = array($testCase, $testCase2);	
    $testOut1 = array($testOut, $testOut2);


	$funcName = array('factorial', 'doubleIt');
	$points = array(25, 50);
	$multiplier = array($points[0]/10, $points[1]/10);
	$qType = array('recursion', 'none');
	$function = array('#TESTTESTTEST
def factorial(n):
    if n == 0:
        return 1
    else:
        return n * factorial(n-1)', 
'def doubleIt(n):
	return n * 2');

*/
/*
	$testCase = array(5, 3);	
    $testOut = array(120, 6);
	
	$testCase2 = array(4, 6);	
    $testOut2 = array(8, 12);
	
	$testCase1 = array($testCase);	
    $testOut1 = array($testOut);


	$funcName = array('factorial');
	$points = array(25);
    	$qType = array('recursion');
    	$function = array('#TESTTESTTEST
def factorial(n):
    if n == 0:
        return 1
    else:
        return n * factorial(n-1)');
*/

    $gradeTotal = array();
	$total = 0;
	$totPerc = 0;
	$comment = "";
	$constraintMet = false;
	$fNameRead = false;

    $x = 0;
    //run thru list of arrays 
    for ($x = 0; $x < count($funcName); $x++){
		for($i = 0; $i < count($testCase1[$x]); $i++){
			$testCase1[$x][$i] = str_replace("`", ",", $testCase1[$x][$i]);
		}

		//echo $funcName[$x];
		//$comment .= ($x+1) . ". ";
	

        $topOfFile = "import sys\n\n";
        $handle = fopen('python.py', 'w');
        fwrite($handle, $topOfFile);
        fwrite($handle, $function[$x]);
        //fwrite($handle, $botFile);
        fclose($handle);


        $output = fopen('out.txt', 'w');
        //$testOut = exec("python.py");
        //fwrite($output, $testOut);

        $grade = 0;
        //write line by to this file
        $pyRun = fopen('pyRun.py', 'w');

        $file = fopen('python.py', 'r');

        
        $funcDef = 'def ' . $funcName[$x];

        if($file){
            while(!feof($file)){
                $line = fgets($file);
                //ignore comment lines
                //if(strpos($line, '#') !== false){
                    //fwrite($pyRun, $line);
                    //continue;
                //}


            //strpos($line, $funcDef) !== false
                if (strpos($line, $funcName[$x]) !== false && $fNameRead == false) {
                    //function name is correct
					//echo "compile";
                    $grade+=1;
                    fwrite($pyRun, $line);
					//echo "correct funct name<br>";
					//echo $funcName[$x];
					//echo "<br>";
					//echo $grade;
					//echo "<br>";
					$fNameRead = true;
                    //continue;
                }
            //strpos($line, 'def /^[a-zA-Z0-9]+$/ (/^[a-zA-Z0-9]+$/):') !== false
                elseif (strpos($line, 'def') !== false) {
                    //function name is incorrect
                    $wrongFunc = substr($line, 4, strpos($line, '(')-4);
                    fwrite($pyRun, $line);
					$comment .= "-" . round(1*$multiplier[$x]) . " for wrong function name \n";
					//echo "-1 for wrong function name<br>";
					//echo $funcName[$x];
					//echo "<br>";
                    //continue;
                }

                elseif ($qType[$x] == 'for loop'){
                    if(strpos($line,  'for ') !== false){
                        $grade+=1;
						//echo "correct for loop implementation<br>";
						//echo $grade;
						//echo "<br>";
						$constraintMet = true;
                    } 

                    fwrite($pyRun, $line);
                    //continue;
                }
                elseif($qType[$x] == 'while loop'){
                    if(strpos($line,  'while ') !== false){
                        $grade+=1;
						//echo "correct while loop implementation<br>";
						//echo $grade;
						//echo "<br>";
						$constraintMet = true;
                    } 

                    fwrite($pyRun, $line);
                    //continue;
                }
                elseif($qType[$x] == 'recursion'){
                    if(strpos($line, $funcName[$x]) !== false && strpos($line, 'return ') !== false){
                        $grade+=1;
						//echo "correct recursion implementation<br>";
						//echo $grade;
						//echo "<br>";
						$constraintMet = true;
                    }
                    elseif(!empty($wrongFunc) && strpos($line, $wrongFunc) !== false){
                        $grade+=1;
						//echo "correct recursion implementation but wrong funct name<br>";
						//echo $grade;
						//echo "<br>";
						$constraintMet = true;
                    } 

                    fwrite($pyRun, $line);
                    //continue;
                }
				else{
					fwrite($pyRun, $line);
				}
                //fwrite($pyRun, $line);

            }
			if($qType[$x] == 'none'){
								//echo "compiled";
				$grade+=1;
				//echo "correct none implementation<br>";
				//echo $grade;
				//echo "<br>";
				$constraintMet = true;
			}
            //that finish dutch touch
            /*if($wrongFunc){
                $botFile = "\n\nprint(" . $wrongFunc . "(sys.argv[1]))";
            }
            else{
                $botFile = "\n\nprint(" . $funcName . "(sys.argv[1]))";
            }
            */
			/*
			testcase1 = [problem 1: ["'+',4,5", "3"], [out, out2], problem 2: [2, 3], [out, out2]]
			opeartion(op, a, b)
			op -> "'+',1,2"
			a -> null
			b -> null
			def tyun(a, b)
			*/
            if($wrongFunc){
				/*
				
				args = split(sys.argv[1]), ",")
				
				params = [];
				
				for i in range(0, len(args)):
					if (args[i] has quotes):
						params.append(args[i])
					else:
						params.append(int(args[i]))
				
				# params = ['+', 4, 5]
				
				print(functionName(*params))
				
				*/
				$botFile = "\n\nargs = sys.argv[1].split(\",\")";
				$botFile .= "\n\nparams = []\n";
				$botFile .= "
for i in range(0, len(args)):
	if (\"'\" in args[i]):
		args[i] = args[i].replace(\"'\", \"\")
		params.append(args[i])
	else:
		params.append(int(args[i]))\n";
				$botFile .= "\n\nprint(" . $wrongFunc . "(*params))";
				
                //$botFile = "\n\nprint(" . $wrongFunc . "(sys.argv[1]))";
            }
            else{
				$botFile = "\n\nargs = sys.argv[1].split(\",\")";
				$botFile .= "\n\nparams = []\n";
				$botFile .= "
for i in range(0, len(args)):
	if (\"'\" in args[i]):
		args[i] = args[i].replace(\"'\", \"\")
		params.append(args[i])
	else:
		params.append(int(args[i]))\n";
				$botFile .= "\n\nprint(" . $funcName[$x] . "(*params))";
                //$botFile = "\n\nprint(" . $funcName[$x] . "(sys.argv[1]))";
            }
            //substr_replace($testZ, $funcName, strpos($line, $wrongFunc), strlen($wrongFunc) + strpos($line, $wrongFunc));
            fwrite($pyRun, $botFile);
            //fwrite($pyRun, $testZ . ' ' . $wrongFunc . ' ' . $funcName);
            //fwrite($pyRun, strpos($line, $wrongFunc) . ' ' . strlen($wrongFunc));


		fclose($pyRun);

            //fwrite($pyRun, "#its ya boi");
            //$doCompile = passthru("python pyRun.py " . $testCase1);
		$doCompile = exec("python pyRun.py " . "\"" . $testCase1[$x][0] . "\"");
            if(!empty($doCompile)){
                //means it compiled properly
				//echo "compiled";
                $grade+=1;
				//echo "good compile<br>";
				//echo $grade;
				//echo "<br>";
                //test doCompile agaisnt the test cases to see if it actually
                //gave the right output and then give points

				$i = 0;
				$ptPerCase = 7/count($testCase1[$x]);
				for($i = 0; $i < count($testCase1[$x]); $i++){
					//testcase1
					$check = exec("python pyRun.py " . "\"" . $testCase1[$x][$i] . "\"";
					if($testOut1[$x][$i] == $check)){
						//echo "compile";
						$grade+=$ptPerCase;
						//echo "test case " . ($i+1) . " passed<br>";
						//echo $grade;
						//echo "<br>";
					} else {
						$comment .= "-" . round($ptPerCase) . " for not passing case " . ($i+1) . " \n";
						//echo "-" . $ptPerCase . " for not passing case " . ($i+1);
					}
					fwrite($output, $check);
					//fwrite($output, $grade);
				}
            }
			else {
				$comment .= "-" . round(8*$multiplier[$x]) . " for not compiling or passing any cases \n";
			}
            //fwrite($output, $grade);
            //fwrite($output, $wrongFunc);
            //fclose($pyRun);
            fclose($output);


        }
		if ($constraintMet == false) {
			$comment .= "-" . round(1*$multiplier[$x]) . " for not meeting constraint \n";
		}
		//echo $grade*$multiplier[$x];
		$grade = round($grade*$multiplier[$x]);
		$comment .= "(" . $grade . "/" . $points[$x] . ") \n";
		//echo $function[$x];
		//echo "Autograde Percent: " . $points[$x] * (((float)$grade) / 10);
		//echo "||<br>"; 
		//$gradeTotal[$x] = $grade;
		$gradeTotal = array_pad($gradeTotal, ($x+1), $grade);
		//echo $gradeTotal[$x];
		//echo "/\/\/\<br>";
		$total += $grade;
		$fNameRead = false;
		$constraintMet = false;
		/*
		echo $qIDs[$x];
		echo "<br>";
		echo $function[$x];
		echo "<br>";
		echo $gradeTotal[$x];
		echo "<br>";
		*/
		//$function[$x] = mysql_real_escape_string($function[$x]);
    }
	$totPts = 0;
	for ($i = 0; $i < count($points); $i++) {
		$totPts += $points[$i];
	}
	$percDiv = $totPts / 100;
	$comment .= "Total: (" . $total . "/" . $totPts . ") \n";
	$totPerc = ($total/$percDiv);
	//echo $total;
	//echo "<br>";
	//echo $totPerc;
	//echo "<br>";
	echo $comment;
	echo "<br>";

    $backurl = "https://web.njit.edu/~prm46/backend.php";
	$jsonSend = json_encode(array('grade'=> $totPerc, 'username'=> $user, 'intent'=> 'store_grade', 'examID'=> $eID, 
		'comment'=> $comment, 'qIDArr'=> $qIDs, 'answersArr'=> $function, 'scoresArr'=> $gradeTotal));
	
	$ch = curl_init();

    curl_setopt ($ch, CURLOPT_URL, $backurl);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
   	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt ($ch, CURLOPT_REFERER, $backurl);
   	curl_setopt ($ch, CURLOPT_POSTFIELDS, $jsonSend);

    curl_exec($ch);

        //fclose($file);
		
 
		
?>
