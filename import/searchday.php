<?php
include 'lib/twitteroauth.php';
include 'c.php';
/////include functions
include 'import/functions.php';


//define twitter credentials as constants
//insert your data here
define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('ACCESS_TOKEN', '');
define('ACCESS_TOKEN_SECRET', '');
 
 

function search(array $query)
{
  $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
  return $toa->get('search/tweets', $query);
}

//search for today, with parameters passed
//*******TODAY
$r = $_GET['geocode'];
$querytodayT = array(
        'q'=>$_GET['q'],
        'lang'=>'en',
        'geocode'=>$_GET['geocode'],
        'count'=>$_GET['count'],   		
   		'result_type'=>$_GET['result_type']
    );

$results = search($querytodayT);
///////
$g = abbreviations($myfile);


foreach ($results->statuses as $result) {
	$id = $result->id_str;
	$name = $result->user->name;
	$userT = $result->user->screen_name;
	$userT = mysqli_real_escape_string($link, $userT);				
	$textT = $result->text;				
	$textT = mysqli_real_escape_string($link, $textT);
	$t = simple_tok($textT);
	$str = addabbreviationsAndNeg($t, $g);
	$textEval = clean($str, $spam_words);
	$sentimentT = $op->classify($textEval);	
	$followersT = $result->user->followers_count;
	$date=$result->created_at;							
	$y = gmdate('Y-m-d', strtotime($date));
	$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;
	$sql= "insert into tweetsD (user, id, text, sentiment, follwers, date, url, name) values('$userT', '$id', '$textT', '$sentimentT', '$followersT', '$y', '$url', '$name')"; 
	$resultT = mysqli_query($link, $sql);
	//if (!$resultT){
	//		print "couldn't execute insert command";
	//}     
 }
//
?>

<div class="day-container-text-and-grap">
        <!--include JavaScript to draw pie chart; it will take $arrayNum as argument  style="height:700px; width:8100px; float:left; display:block"--!>
 		<div class="piecontainer">		
 			<!--<div class="firstpiecontainer">--!>
 			<h2 class="pie-result-title">Sentiments and followers</h2>
 			<?php
 			//MYSQL OPERATION 
 			//select 'sentiment' field from table tweetsD; then get an associative array with ordered keys (negative, neutral, positive)
 	 		$sss="select sentiment, count(*) as total from tweetsD group by sentiment order by sentiment";
 	 		$coda=mysqli_query($link, $sss);
 	 		if (!$coda){
    			print "could not find sentiments";
    		}  	
	    	//declare and inizialize array to 0, for each sentiment;	
 		 	$arrayNum = array(0, 0, 0); 	 		
 	 		while ($row=mysqli_fetch_array($coda, MYSQLI_ASSOC)){
    			if ($row['sentiment'] == 'negative'){
    				$arrayNum[0] = $row['total'];
    			}
    			if ($row['sentiment'] == 'neutral'){
    				$arrayNum[1] = $row['total'];
    			}
    			if ($row['sentiment'] == 'positive'){
    				$arrayNum[2] = $row['total'];
    			}
   			}
   			
 	//include file to draw piecharts with array passed
			include 'import/pie.php';
			?>	
		<!--</div>--!>
		
		
			<!--<div class="secondpiecontainer" >
			<h2 class="pie-result-title">Audience of sentiments based on the users' followers</h2>--!>
			<?php
			$sqlfollowers="select sentiment, sum(follwers) as total from tweetsD group by sentiment order by sentiment";
			$objFollow=mysqli_query($link, $sqlfollowers);
 			if (!$objFollow){
   				 print "could not select followers";
    		}			
			//assign new values to array, and include again Javascript to print pie chart per followers
 	 		$arrayNum1 = array(0, 0, 0); 
 	 		while ($row=mysqli_fetch_array($objFollow, MYSQLI_ASSOC)){
    			if ($row['sentiment'] == 'negative'){
    				$arrayNum1[0] = $row['total'];
    			}
    			if ($row['sentiment'] == 'neutral'){
    				$arrayNum1[1] = $row['total'];
    			}
    			if ($row['sentiment'] == 'positive'){
    				$arrayNum1[2] = $row['total'];
    			}
   			}
			//include file for second piechart
			include 'import/pieabs.php';
			?>
		</div>
	
        
    
  	 <div class="results-container-day-with-title">
    	  <h2 class="pie-result-title-right">Tweets</h2>
    		  <div class="results-container-day">
		        <?php        
        	$arraySent = array('positive', 'negative', 'neutral');    
        	foreach($arraySent as $sent){
        	$sqlsent="select user, name, text, url from tweetsD where sentiment = '$sent'"; 
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
        		while ($row = $sentcomm->fetch_assoc())
                	    {
                   echo "<p class='tweet-long' ><em>".$row['name']. "</em> ( <em>@".$row['user'] . "</em> ) : " . $row['text'] . "<br /><a href='". $row['url']."' class='linkurl' target='_blank'>Go to the tweet</a><br /></p>";
                     }
        		}
        	}     
        ?>
    		</div>    
    </div>
    
    <?php
    $tot = $arrayNum[0] + $arrayNum[1] + $arrayNum[2];
    $percneg = ($arrayNum[0] * 100) /$tot;
    $percneg = number_format($percneg, 2); 
    $percneu = ($arrayNum[1] * 100) /$tot;
    $percneu = number_format($percneu, 2);
    $percpos = ($arrayNum[2] * 100) /$tot;
    $percpos = number_format($percpos, 2);
    
    ?>
   </div>	
    <div class="after">
     <h2 class="summ">Daily sum</h2> 
     <ul>
     <li>Positive:  <?php echo $percpos ."%  (and ".$arrayNum1[2] ." followers)" ?></li>
     <li>Negative:  <?php echo $percneg ."%  (and ".$arrayNum1[0] ." followers)" ?></li>
     <li>Neutral:  <?php echo $percneu ."%  (and ".$arrayNum1[1] ." followers)" ?></li>
     </ul>
    </div>