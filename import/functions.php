<?php
//this function tokenize and clean
function simple_tok($string){
	$string= strtolower($string);
	//thos will reduce consecutive characters >4 to 3 (is a sort of normalization that will mantain emphasys) 
	$string	= preg_replace('{( ?.)\1{4,}}','$1$1$1',$string);	
	//this will substitute each "!" with a specific string
	$patterns = array('/\,/', '/\./', '/;/', '/\"/', '/\(/', '/\)/', '/ - /', '/–/', '/_/', '/\*/');
	$string = preg_replace('/!/', ' abdgh ', $string);
	$result = preg_replace('/\?/', ' abdgf ', $string);
	/////$result = preg_replace('/:/', ' ', $result);
	$result = preg_replace($patterns, ' ', $result);
	//$result = preg_replace('/\<3/', ' muchlove ', $result);
	$a = preg_split('/ +/', $result);
	//in the sentence, each token...
	foreach ($a as $w) {
		if ((preg_match('#^http#', $w) === 1) || (preg_match('#^@#', $w) === 1)) {
			$a = array_diff($a, array($w));
		}
	}
	return $a;
}

//this functions creates an associative array with the list of abbreviation(csv) I preared. 
//It takes as argument a csv file.
//It returns a dictionary (aa)
function abbreviations ($myfile){
	$array = array();
	foreach ($myfile as $line){
    	list($key, $value) = explode(',', $line, 2) + array(NULL, NULL);
    	if ($value !== NULL){
        	$array[strtolower($key)] = strtolower($value);
    	}
	}
	return $array;
}

//take as argument an array and a dictionary (aa)
//return a string with no more abbreviations
function addabbreviationsAndNeg($t, $g){
	$arr = array();
	$i = 0;
	foreach ($t as $token){
		if (array_key_exists($token, $g)){
			$token = $g[$token];
		} 		
		$arr[$i] = $token;
		$i = $i +1;
		}
		$newstring = implode(" ", $arr);
		$result = preg_replace('/n\'t /', 'nt not', $newstring); 
		//delete any other character
		$result = preg_replace('/\W/', ' ', $result);
		return $result;
		}


//take a string and return a cleaned one
function clean($string, $list){
	//$arr2 = array();
	$a = preg_split('/ +/', $string);
	foreach ($a as $word){
		if (in_array($word, $list)) {
			$a = array_diff($a, array($word));
		}
	}
	$new = implode(" ", $a);
	return $new;
}
?>
