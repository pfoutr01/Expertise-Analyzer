<?php

//Using TwitterOauth library, https://twitteroauth.com/.
//Built by Abraham Williams for use with the Twitter API. TwitterOAuth is not affiliated Twitter, Inc.
require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
include "twitter-app-config.php";

function getTwitterData($screen_name,$languages){
	//Create twwets by language , retwwets by language, likes by language arrays.
	$languages_keys = array_keys($languages);
	$tweets_by_language;
	$retweets_by_language;
	$likes_by_language;
	foreach($languages_keys as $k){
		$tweets_by_language[$k]=0;
		$retweets_by_language[$k]=0;
		$likes_by_language[$k]=0;
	
	}
	
	//Create an application-authorized connection to Twitter API.
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	$content = $connection->get("account/verify_credentials");


	$page=1;
	//Use tweet_id for field max_id to avoid get duplicate tweets, if new tweets created during API call.
	$tweet_id;
	
	
	//This method can only return up to 3,200 of a user’s most recent Tweets. Max count per page = 200.
	/***PROBLEM HERE****/
	$statuses = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name, "count" => 200, "page"=>$page]);
	/***PROBLEM HERE****/
	
	
	//$followers = $statuses[0]->user->followers_count;
	$followers="";
	
	do{
		
		//Check if a user exists.
		//If user doesnt exist API returns an object with the proper message.
		//If user exists API returns an array with user's tweets.
		if(gettype($statuses)=='object'){
			if(property_exists($statuses, 'errors')){
				return false;
			}
		}
		
		//Check only user's tweets, not retweeted tweets.
		for($i=0;$i<count($statuses);$i++){
			$status=$statuses[$i];
			
			if($followers==""){
				$followers = $status->user->followers_count;
			}
			
			$tweet_id= $status->id_str;
			$tweet_str= $status->text;
			$retweeted=$status->retweeted;
			
			for($j=0;$j<count($languages_keys);$j++){
				
				$lang=$languages_keys[$j];
				
				
				if( ($retweeted==false) && (stristr($tweet_str,$lang)!=false) ){
					
					$tweets_by_language[$lang]++;
					$retweets_by_language[$lang]+=$status->retweet_count;
					$likes_by_language[$lang]+=$status->favorite_count;
				}
	
			}
			
		}
		
		$page++;
		
	}while($statuses = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name, "count" => 200, "page"=>$page,"max_id"=>$tweet_id]));

	return array('followers'=>$followers,'tweets_by_language'=>$tweets_by_language,'retweets_by_language'=>$retweets_by_language,
				'likes_by_language'=>$likes_by_language);
	
}


?>