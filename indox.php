<!DOCTYPE html>
<html  lang="en">
<head>
<link rel="stylesheet" href="import/css/style.css" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Sentiment </title>
<script type="text/javascript" src="d3/d3.js"></script>
</head>
<body>
<div class="main-wrapper">
<!--FORM -->

<div class="formspace">
<h1> Tweets analyser</h1>
<form class="form-text" method="GET">
   <label>What are you curious about? </label><br />   
    <input type="text" name="q" /> 
    <!--submit -->
    <br />  
    <label>From: </label> 
    <select name="geocode"> 
      <option value="">Globally</option>
      <option value="53.3498053,-6.260309699999993,18km">Dublin</option>
      <option value="37.781157,-122.398720,30km">San Francisco</option>
      <option value="51.5073509,-0.12775829999998223,30km">London</option>
      <option value="19.0759837,72.87765590000004,30km">Mumbay</option>
      <option value="-33.8674869,151.20699020000006,12km">Sydney</option>
      <option value="40.7127837,-74.00594130000002,30km">New York</option>
      <option value="50.8503396,4.351710300000036,12km">Bruxelles</option>
      <option value="41.8723889,12.48018019999995,22km">Rome</option> 
    </select>  
    <br /> 
    
    <label>Number of tweets: </label> 
    <select name="count"> 
      <option value="3">15</option>
      <option value="30">30</option>
      <option value="60">60</option>
      <option value="100">100</option>
      <option value="200">200</option>
    </select>
    <br />
     
    <label>Popular or recent? </label>
    <select name="result_type"> 
      <option value="mixed"> --- </option>
      <option value="popular">popular</option>
      <option value="recent">recent</option>
    </select>
     <br />      
        <input type="submit" value="go!" />
 </form>
</div>

<?php
	if(isset($_GET['q']) && $_GET['q']!='') { 
		include 'connection.php';
		
		///////list of stop words
		$spam_words = file('import/data/genericlist.txt', FILE_IGNORE_NEW_LINES);
		/////////dictionary of abbreviations
		$myfile = file('import/data/dictio.csv');
		/////////////
		
		$sqldelete = "delete from tweetsD";
		$delete = mysqli_query($link, $sqldelete);
				if (!$delete)
				{
					print "couldn't delete";
				}
		$sqldelete1 = "delete from tweetsDat";
		$delete1 = mysqli_query($link, $sqldelete1);
				if (!$delete1)
				{
					print "couldn't delete";
				}
		
		//select tweets and store tweets from today, bsed on form
		include 'import/searchday.php';
		
		//select and store tweets from the previous 7 days
		include 'import/dd.php';	
				
}else{
	echo "Please insert a value";
	}
?>
</div>
</body>
</html>

