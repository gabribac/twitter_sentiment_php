<?php
 
include 'import/dates.php';

//*******TODAY
$querytodayT = array(
  'q'=>$_GET['q'],
  "count" => 16,
 'geocode'=>$_GET['geocode'],
  "result_type" => "recent",
  "lang" => "en"
);
$results = search($querytodayT);
foreach ($results->statuses as $result) {				
		$id = $result->id_str;
		$name = $result->user->name;
		$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$userT = $result->user->screen_name;
				$userT = mysqli_real_escape_string($link, $userT);				
				$textT = $result->text;				
				$textT = mysqli_real_escape_string($link, $textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);
				$date=$result->created_at;							
				$y = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y', '$sentimentT', '$id', '$name', '$url')"; 
				$resultT = mysqli_query($link, $sql);
				//if (!$resultT)
				//{
				//	print "couldn't execute insert command";
				//}     
}


//*******YESTERDAY
$querytoday1T = array(
  'q'=>$_GET['q'],
  "count" => 16,
  'geocode'=>$_GET['geocode'],
  "result_type" => "popular",
  "lang" => "en",
  "since"=> $today1T,
  "until"=> $todayT
);
$results1T = search($querytoday1T);

foreach ($results1T->statuses as $result) {
$userT = $result->user->screen_name;
				$id = $result->id_str;
		$name = $result->user->name;
		$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$userT = mysqli_real_escape_string($link, $userT);				
				$textT = $result->text;				
				$textT = mysqli_real_escape_string($link, $textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);					
				$date=$result->created_at;			
				$y1 = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y1', '$sentimentT', '$id', '$name', '$url')"; 
				//execute query
				$resultT = mysqli_query($link, $sql);
				// if (!$resultT)
// 				{
// 					print "couldn't execute insert command";
// 				}	      
}



//import
include 'import/queries.php';

//prepare arrays for csv files
$sqlneg = "select date, count(text) as tot from tweetsDat where sentiment = 'negative' group by date order by date";
$resultneg = mysqli_query($link, $sqlneg);
				if (!$resultneg){
					echo "no negatives";
					}
$secondArray = array("negative", 0, 0, 0, 0, 0, 0, 0);
while ($row=mysqli_fetch_array($resultneg, MYSQLI_ASSOC)){
	if ($row['date'] == $y){
		$secondArray[1] = $row['tot'];
		}
	if ($row['date'] == $y1){
		$secondArray[2] = $row['tot'];
		}
	if ($row['date'] == $y2){
		$secondArray[3] = $row['tot'];
		}
	if ($row['date'] == $y3){
		$secondArray[4] = $row['tot'];
		}
	if ($row['date'] == $y4){
		$secondArray[5] = $row['tot'];
		}
	if ($row['date'] == $y5){
		$secondArray[6] = $row['tot'];
		}
	if ($row['date'] == $y6){
		$secondArray[7] = $row['tot'];
		}
}



$sqlneu = "select date, count(text) as tot from tweetsDat where sentiment = 'neutral' group by date order by date";
$resultneu = mysqli_query($link, $sqlneu);
				if (!$resultneu){
					echo "no neutrals";
					}
$thirdArray = array("neutral", 0, 0, 0, 0, 0, 0, 0);
while ($row=mysqli_fetch_array($resultneu, MYSQLI_ASSOC)){
	if ($row['date'] == $y){
		$thirdArray[1] = $row['tot'];
		}
	if ($row['date'] == $y1){
		$thirdArray[2] = $row['tot'];
		}
	if ($row['date'] == $y2){
		$thirdArray[3] = $row['tot'];
		}
	if ($row['date'] == $y3){
		$thirdArray[4] = $row['tot'];
		}
	if ($row['date'] == $y4){
		$thirdArray[5] = $row['tot'];
		}
	if ($row['date'] == $y5){
		$thirdArray[6] = $row['tot'];
		}
	if ($row['date'] == $y6){
		$thirdArray[7] = $row['tot'];
		}
}

$sqlpos = "select date, count(text) as tot from tweetsDat where sentiment = 'positive' group by date order by date";
$resultpos = mysqli_query($link, $sqlpos);
				if (!$resultpos){
					echo "no positives";
					}
$fourthArray = array("positive", 0, 0, 0, 0, 0, 0, 0);
while ($row=mysqli_fetch_array($resultpos, MYSQLI_ASSOC)){
	if ($row['date'] == $y){
		$fourthArray[1] = $row['tot'];
		}
	if ($row['date'] == $y1){
		$fourthArray[2] = $row['tot'];
		}
	if ($row['date'] == $y2){
		$fourthArray[3] = $row['tot'];
		}
	if ($row['date'] == $y3){
		$fourthArray[4] = $row['tot'];
		}
	if ($row['date'] == $y4){
		$fourthArray[5] = $row['tot'];
		}
	if ($row['date'] == $y5){
		$fourthArray[6] = $row['tot'];
		}
	if ($row['date'] == $y6){
		$fourthArray[7] = $row['tot'];
		}
}

$file = fopen("import/csv/cont.csv","w");
$list = array (
    array("State", $y, $y1, $y2, $y3, $y4, $y5, $y6),
    $secondArray,
    $thirdArray,
    $fourthArray
);

//$fp = fopen('file.csv', 'w');

foreach ($list as $fields) {
    fputcsv($file, $fields);
}

fclose($file);


////////////////////////
$sqlstack1 = "select sentiment, date, count(text) as tot from tweetsDat where sentiment = 'positive' group by date order by date";
$resultpos = mysqli_query($link, $sqlstack1);
				if (!$resultpos){
					echo "no positives";
					}
$array1 = array("positive", $y, 0);
$array2 = array("positive", $y1, 0);
$array3 = array("positive", $y2, 0);
$array4 = array("positive", $y3, 0);
$array5 = array("positive", $y4, 0);
$array6 = array("positive", $y5, 0);
$array7 = array("positive", $y6, 0);
while ($row=mysqli_fetch_array($resultpos, MYSQLI_ASSOC)){
	if ($row['date'] == $y){
		$array1[2] = $row['tot'];
		}
	if ($row['date'] == $y1){
		$array2[2] = $row['tot'];
		}
	if ($row['date'] == $y2){
		$array3[2] = $row['tot'];	
			}
	if ($row['date'] == $y3){
		$array4[2] = $row['tot'];
		}
	if ($row['date'] == $y4){
		$array5[2] = $row['tot'];
		}
	if ($row['date'] == $y5){
		$array6[2] = $row['tot'];
		}
	if ($row['date'] == $y6){
		$array7[2] = $row['tot'];
		}
}


$sqlstack2 = "select sentiment, date, count(text) as tot from tweetsDat where sentiment = 'negative' group by date order by date";
$resultneg = mysqli_query($link, $sqlstack2);
				if (!$resultneg){
					echo "no positives";
					}
$array9 = array("negative", $y, 0);
$array10 = array("negative", $y1, 0);
$array11 = array("negative", $y2, 0);
$array12 = array("negative", $y3, 0);
$array13 = array("negative", $y4, 0);
$array14 = array("negative", $y5, 0);
$array15 = array("negative", $y6, 0);
while ($row=mysqli_fetch_array($resultneg, MYSQLI_ASSOC)){
	if ($row['date'] == $y){
		$array9[2] = $row['tot'];
		}
	if ($row['date'] == $y1){
		$array10[2] = $row['tot'];
		}
	if ($row['date'] == $y2){
		$array11[2] = $row['tot'];	
			}
	if ($row['date'] == $y3){
		$array12[2] = $row['tot'];
		}
	if ($row['date'] == $y4){
		$array13[2] = $row['tot'];
		}
	if ($row['date'] == $y5){
		$array14[2] = $row['tot'];
		}
	if ($row['date'] == $y6){
		$array15[2] = $row['tot'];
		}
}




$sqlstack3 = "select sentiment, date, count(text) as tot from tweetsDat where sentiment = 'neutral' group by date order by date";
$resultneu = mysqli_query($link, $sqlstack3);
				if (!$resultneu){
					echo "no neutral";
					}
$array18 = array("neutral", $y, 0);
$array19 = array("neutral", $y1, 0);
$array20 = array("neutral", $y2, 0);
$array21 = array("neutral", $y3, 0);
$array22 = array("neutral", $y4, 0);
$array23 = array("neutral", $y5, 0);
$array24 = array("neutral", $y6, 0);
while ($row=mysqli_fetch_array($resultneu, MYSQLI_ASSOC)){
	if ($row['date'] == $y){
		$array18[2] = $row['tot'];
		}
	if ($row['date'] == $y1){
		$array19[2] = $row['tot'];
		}
	if ($row['date'] == $y2){
		$array20[2] = $row['tot'];	
			}
	if ($row['date'] == $y3){
		$array21[2] = $row['tot'];
		}
	if ($row['date'] == $y4){
		$array22[2] = $row['tot'];
		}
	if ($row['date'] == $y5){
		$array23[2] = $row['tot'];
		}
	if ($row['date'] == $y6){
		$array24[2] = $row['tot'];
		}
}


$file1 = fopen("import/csv/stackdata.csv","w");
$list1 = array (
    array("group","date","value"),
    $array7,
    $array6,
    $array5,
    $array4,
    $array3,
    $array2,
    $array1,    
    $array24,
    $array23,
    $array22,
    $array21,
    $array20,
    $array19,
    $array18,
    $array15,
    $array14,
    $array13,
    $array12,
    $array11,
    $array10,
    $array9
);
foreach ($list1 as $fields) {
    fputcsv($file1, $fields);
}
fclose($file1);

?>
 <div class="week-container-text-and-graph">
 	<div class="week-graph">
 	<h2 class="stack-result-title">Weekly trend</h2>
 	<?php
		//load csv file and draw graph
		include 'import/nuovoq.php';
		//add link to dynamic graph	
		?>
		<a class="linkf" href="import/stackdinamic.php">See a dynamic stack </a>;
		
 	</div>
 	<div class="results-container-week">
        <h2 class="stack-result-title-bottom">Tweets of the week</h2>
        <?php        
        $arraySent = array('positive', 'negative', 'neutral');    
        foreach($arraySent as $sent){
        //$sqlsent="select user, name, text, url from tweetsD where sentiment = '$sent'"; 
        $sqlsent="select user, text, date, url, name from tweetsDat where sentiment = '$sent' order by date"; 
        $sentcomm = $link->query($sqlsent);
        $numbers = $sentcomm->num_rows;
        
        if ($numbers > 0){
        	if ($numbers == 1) {
        		echo "<h3 class='sentiment-header'>". $sent ." tweet</h3>";        	
        	}
        	else
        	{
        		echo "<h3 class='sentiment-header'>". $sent ." tweets</h3>"; 
        	}
        	
        	
//        	echo $y . "<br />";
        	while ($row = $sentcomm->fetch_assoc()){
                   //if ($row['date'] == $y){
                   //echo $row['user'] . ": " . $row['text'] . " (" . $row['date']. ")<br />";
                     echo "<p class='tweet-long'>".$row['date']."  ***  <em>" .$row['name']. "</em> ( <em>@".$row['user'] . "</em> ) : " . $row['text'] . "<br /><a href='". $row['url']."' class='linkurl' target='_blank'>Go to the tweet</a><br /></p>";
                	
        	}
        }      
       }
        ?>
        </div>
		
</div>
