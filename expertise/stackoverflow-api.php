<?php
//Using Stack.PHP library for access the StackExchange API.
require_once 'stackphp/src/api.php';


function getDataStackOverflow($user_id,$languages){
	// 2D Array with programming languages and count for each of them.
	$languages_keys = array_keys($languages);
	$badges;
	$answers;
	foreach($languages as $k =>$v){
		$answers[$k]=0;
		$badges[$k]="";
		$answers_upvotes[$k]=0;
	}
	

	//Change of max execution time because in some cases exceed the current time limit.
	ini_set('max_execution_time', 400);

	
	//Expertise Analyzer app key for making more api calls.
	$key="AmsSGlZ))mkTYUf1GRdeWw((";
	//Set app key. Limit is 10000 requests per day.
	API::$key=$key;
	//Select stackoverflow site of stackexchange.
	$stackoverflow = API::Site('stackoverflow');

	$response = $stackoverflow->Users()->SortByCreation()->Exec();
	$response=$response->Fetch();
	$last_user_id=$response["account_id"];
	//If id provided is bigger than latest user's id return false.
	if($user_id>$last_user_id){
		return false;
	}
	
	//Query to get user's answers' top tags.
	$response = $stackoverflow->Users($user_id)->TopAnswerTags()->Exec();

	$array;
	$count =0;

	//Count the tags for each language.
	//Max tags returned=1796.
	while($array=$response->Fetch()){
		//var_dump($array);
		//echo"<br>";
		$tag=strtoupper($array["tag_name"]);
		$upvotes = $array["answer_score"];
		if(in_array($tag,$languages_keys)){
			$answers[$tag]+=intval($array["answer_count"]);
			$answers_upvotes[$tag]+=$upvotes;
		}
		
		$count++;
		
		
	}
	//echo "----------count ".$count;
	//Query to get a user object.
	$response = $stackoverflow->Users($user_id)->Exec();
	$user=$response->Fetch(FALSE);
	//Get user's badges and reputation.
	$bronze_badges = $user["badge_counts"]["bronze"];
	$silver_badges = $user["badge_counts"]["silver"];
	$gold_badges = $user["badge_counts"]["gold"];

	$reputation = $user["reputation"];

	$response=$stackoverflow->Users($user_id)->Badges()->Exec();
	while($array=$response->Fetch()){
		$badge=strtoupper($array["name"]);
		$rank=$array["rank"];
		
		
			if(in_array($badge,$languages_keys))
				$badges[$badge].=$rank;
		
	}

	//Prints user's data.
	// echo "user details:<br>";
	// echo "reputation=".$reputation."<br>";
	// echo "bronze badges=".$bronze_badges."<br>";
	// echo "silver_badges=".$silver_badges."<br>";
	// echo "gold_badges=".$gold_badges."<br>";

	//Print the array of languages with counts and upvotes.
	foreach($badges as $badge => $rank){
			
			//echo	$languages[$i][0]."=".$languages[$i][1]." upvotes=".$languages[$i][2];
			
			if(stristr($rank,"gold")){
				//echo " badge_rank="."gold"."<br>";
				$badges[$badge]="gold";
			}
			else if(stristr($rank,"silver")){
				//echo " badge_rank="."silver"."<br>";
				$badges[$badge]="silver";
			}
			else if(stristr($rank,"bronze")){
				//echo " badge_rank="."bronze"."<br>";
				$badges[$badge]="bronze";
			}
			
			
				
	}
	
	return array('reputation'=>$reputation,
					'bronze_badges'=>$bronze_badges,
					'silver_badges'=>$silver_badges,
					'gold_badges'=>$gold_badges,
					'$badges'=>$badges,
					'asnwers'=>$answers,
					'answers_upvotes'=>$answers_upvotes);
}



?>






