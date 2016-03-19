<?php

function($github_data,$stackoverflow_data,$twitter_data,$max_answers){
	//Github**************************************************************************************************************
		$github_followers = $github_data['followers'];
		$account_duration = $github_data['account_duration']; //in days
		$involvement_duration = $github_data['involvement_duration'];	//in days
		$repositories = $github_data['repositories'];
		$repos_by_language = $github_data['repos_by_language'];
	//END Github**********************************************************************************************************
	
	
	//StackOverflow*******************************************************************************************************
		$reputation=$stackoverflow_data['reputation'];
		$bronze_badges=$stackoverflow_data['bronze_badges'];
		$silver_badges=$stackoverflow_data['silver_badges'];
		$gold_badges=$stackoverflow_data['gold_badges'];
		//$badges is an associative array that contains the type of badges for each language. 
		$badges_about_languages=$stackoverflow_data['$badges'];
		//$answers is an associative array that contains the number of answers for each language. 
		$answers_about_languages=$stackoverflow_data['asnwers'];
		//$answers_upvotes is an associative array that contains the number of upvotes for each answer about a language. 
		$answers_upvotes_about_languages=$stackoverflow_data['answers_upvotes'];
	//END StackOverflow***************************************************************************************************
	
	//Twitter*************************************************************************************************************
		$twitter_followers=$twitter_data['followers'];
		$tweets_by_language=$twitter_data['tweets_by_language'];
		$retweets_by_language=$twitter_data['retweets_by_language'];
		$likes_by_language=$twitter_data['likes_by_language'];
	//END Twitter*********************************************************************************************************
}

?>