<?php

$max_answers;
	$file = fopen("stackoverflow-max-answers.txt","r");
	while($line=fgets($file)){
		$string = explode(":",$line);
		//Eliminate last position of line that is the new line and we dont want to save it.
		$max_answers[$string[0]]=intval($string[1]);
		
		
	}
	fclose($file);
	
	var_dump($max_answers);
?>