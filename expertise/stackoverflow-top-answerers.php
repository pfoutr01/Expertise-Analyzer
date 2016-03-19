<?php
//Using Stack.PHP library for access the StackExchange API.
require_once 'stackphp/src/api.php';
	
	//GET LANGUAGES FROM FILE*****************************************************
	
	$file = fopen("languages.txt","r");
	while($line=fgets($file)){
		//Eliminate last position of line that is the new line and we dont want to save it.
		$language=strtoupper(substr($line,0,strlen($line)-2));
		$languages[$language]=0;
		
	}
	fclose($file);
	
	//END GET LANGUAGES FROM FILE*************************************************
	


	$languages_keys = array_keys($languages);
	
	$max_answers;
	foreach($languages as $k =>$v){
		$max_answers[$k]=0;
		
	}
	
	//Change of max execution time because in some cases exceed the current time limit.
	ini_set('max_execution_time', 400);
	
	//Expertise Analyzer app key for making more api calls.
	$key="AmsSGlZ))mkTYUf1GRdeWw((";
	//Set app key. Limit is 10000 requests per day.
	API::$key=$key;
	//Select stackoverflow site of stackexchange.
	$stackoverflow = API::Site('stackoverflow');
	
	//Find max answers by language;
	foreach($languages as $k =>$v){
		$lang =$k;
	
		
		$response = $stackoverflow->Tags(urlencode($lang))->TopAnswerers("all_time")->Exec();
		
		$count =0;
		
		while($array=$response->Fetch()){
			
			$answers = $array["post_count"];
			
			if($count<$answers){
				$count = $answers;
			}
			
		}
		
		$max_answers[$lang]=$count;
		
	}
	//Print results to file
	$myfile = fopen("stackoverflow-max-answers.txt", "w");
	$text="";
	for($i=0;$i<count($languages_keys);$i++){
		$lang = $languages_keys[$i];
		$text =$lang.":".$max_answers[$lang]."-";
		if($i!=0){
			$text ="\n".$lang.":".$max_answers[$lang];
		}
		else{
			$text =$lang.":".$max_answers[$lang];
		}
		fwrite($myfile, $text);
		$text="";
	}
	
	fclose($myfile);
	
	//var_dump($max_answers);
		
?>