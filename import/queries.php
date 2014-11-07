<?php
//*******2YESTERDAY
$querytoday2T = array(
  'q'=>$_GET['q'],
  "count" => 16,
'geocode'=>$_GET['geocode'],
 "result_type" => "popular",
  "lang" => "en",
  "since"=> $today2T,
  "until"=> $today1T
);
$results2T = search($querytoday2T);
foreach ($results2T->statuses as $result) {
	$userT = $result->user->screen_name;
				$userT = mysqli_real_escape_string($link, $userT);				
				$id = $result->id_str;
				$name = $result->user->name;
				$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$textT = $result->text;				
				$textT = mysqli_real_escape_string($link, $textT);
				$t = simple_tok($textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);					
				$date=$result->created_at;			
				$y2 = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y2', '$sentimentT', '$id', '$name', '$url')"; 
				//execute query
				$resultT = mysqli_query($link, $sql);
				// if (!$resultT)
// 				{
// 					print "couldn't execute insert command";
// 				}	      
}

//*******3YESTERday
$querytoday3T = array(
  'q'=>$_GET['q'],
  "count" => 16,
'geocode'=>$_GET['geocode'],
 "result_type" => "popular",
  "lang" => "en",
  "since"=> $today3T,
  "until"=> $today2T
);
$results3T = search($querytoday3T);
foreach ($results3T->statuses as $result) {
	$userT = $result->user->screen_name;
				$userT = mysqli_real_escape_string($link, $userT);				
				$id = $result->id_str;
				$name = $result->user->name;
				$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$textT = $result->text;				
				$textT = mysqli_real_escape_string($link, $textT);
				$t = simple_tok($textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);						
				$date=$result->created_at;			
				$y3 = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y3', '$sentimentT', '$id', '$name', '$url')"; 
				//execute query
				$resultT = mysqli_query($link, $sql);
				// if (!$resultT)
// 				{
// 					print "couldn't execute insert command";
// 				}	    
}


//*******4YESTERDAY
$querytoday4T = array(
  'q'=>$_GET['q'],
  "count" => 16,
 'geocode'=>$_GET['geocode'],
 "result_type" => "popular",
  "lang" => "en",
  "since"=> $today4T,
  "until"=> $today3T
);
$results4T = search($querytoday4T);
foreach ($results4T->statuses as $result) {
	$userT = $result->user->screen_name;
				$userT = mysqli_real_escape_string($link, $userT);				
				$id = $result->id_str;
				$name = $result->user->name;
				$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$textT = $result->text;				
				$textT = mysqli_real_escape_string($link, $textT);
				$t = simple_tok($textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);	
				$date=$result->created_at;			
				$y4 = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y4', '$sentimentT', '$id', '$name', '$url')"; 
				//execute query
				$resultT = mysqli_query($link, $sql);
				// if (!$resultT)
// 				{
// 					print "couldn't execute insert command";
// 				}    
}


//*******5YESTERDAY
$querytoday5T = array(
  'q'=>$_GET['q'],
  "count" => 16,
	'geocode'=>$_GET['geocode'],
 	"result_type" => "popular",
  "lang" => "en",
  "since"=> $today5T,
  "until"=> $today4T
);
$results5T = search($querytoday5T);
foreach ($results5T->statuses as $result) {
	$userT = $result->user->screen_name;
				$userT = mysqli_real_escape_string($link, $userT);				
				$id = $result->id_str;
				$name = $result->user->name;
				$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$textT = $result->text;				
				$textT = mysqli_real_escape_string($link, $textT);
				$t = simple_tok($textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);
				$date=$result->created_at;			
				$y5 = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y5', '$sentimentT', '$id', '$name', '$url')"; 
				//execute query
				$resultT = mysqli_query($link, $sql);
				// if (!$resultT)
// 				{
// 					print "couldn't execute insert command";
// 				}    
}


//*******6YESTERDAY
$querytoday6T = array(
  'q'=>$_GET['q'],
  "count" => 16,
 'geocode'=>$_GET['geocode'],
 "result_type" => "popular",
  "lang" => "en",
  "since"=> $today6T,
  "until"=> $today5T
);
$results6T = search($querytoday6T);
foreach ($results6T->statuses as $result) {
	$userT = $result->user->screen_name;
				$userT = mysqli_real_escape_string($link, $userT);				
				$textT = $result->text;				
				$id = $result->id_str;
				$name = $result->user->name;
				$url='https://twitter.com/'. $result->user->name .'/status/'.$result->id_str;	
				$textT = mysqli_real_escape_string($link, $textT);
				$t = simple_tok($textT);
				$str = addabbreviationsAndNeg($t, $g);
				$textEval = clean($str, $spam_words);
				$sentimentT = $op->classify($textEval);	
				$date=$result->created_at;			
				$y6 = gmdate('Y-m-d', strtotime($date));
				$sql= "insert into tweetsDat (user, text, date, sentiment, id, name, url) values('$userT', '$textT', '$y6', '$sentimentT', '$id', '$name', '$url')"; 
				//execute query
				$resultT = mysqli_query($link, $sql);
				// if (!$resultT)
// 				{
// 					print "couldn't execute insert command";
// 				}
}
?>
