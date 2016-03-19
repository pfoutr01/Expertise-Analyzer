<?php
session_start();


include('github-api.php');

	
include('stackoverflow-api.php');

include('twitter-api.php');

include('db-config.php');
include('max-values.php');
$message;

	
	$github_username="";
	$stackoverflow_id="";
	$twitter_username="";
	if(isset($_POST['github_username'])){
		$github_username=$_POST['github_username'];
		
	}
	if(isset($_POST['stackoverflow_id'])){
		$stackoverflow_id=$_POST['stackoverflow_id'];
	}
	if(isset($_POST['twitter_username'])){
		$twitter_username=$_POST['twitter_username'];
	}
	
	//****************************************************************************
	
	
	
	
	//GET LANGUAGES FROM FILE*****************************************************
	
	$file = fopen("languages.txt","r");
	while($line=fgets($file)){
		//Eliminate last position of line that is the new line and we dont want to save it.
		$language=strtoupper(substr($line,0,strlen($line)-2));
		$languages[$language]=0;
		
	}
	fclose($file);
	
	//END GET LANGUAGES FROM FILE*************************************************
	
	//Github Data Fetch***********************************************************
	$github_account=false;
	if($github_username!=""){
	
		$github_data=getData($github_username,$languages);
		if($github_data){
			$github_account=true;
			$github_followers = $github_data['followers'];
			$account_duration = $github_data['account_duration']; //in days
			$involvement_duration = $github_data['involvement_duration'];	//in days
			$repositories = $github_data['repositories'];
			$repos_by_language = $github_data['repos_by_language'];
			$commits_by_year = $github_data['commits_by_year'];
			
			//Associative array keys.
			$commits_keys = array_keys($commits_by_year);
			//Total repositories of user.
			$total_repos=0;
			//Associative array keys.
			$keys = array_keys($repos_by_language);
			
			for($i=0;$i<count($repos_by_language);$i++){
				$total_repos +=intval($repos_by_language[$keys[$i]]);
			}
			//Calculate percentages for each project's language of total repos.
			$percentages = new ArrayObject($repos_by_language);
			//$percentages=$repos_by_language->getArrayCopy();
			for($i=0;$i<count($percentages);$i++){
				$percentages[$keys[$i]]=intval($percentages[$keys[$i]]/$total_repos*100);
			}
			
			//Create Github graph js code*************************************************
			$github_graph= "<script>$(function() {

			Morris.Area({
				element: 'morris-area-chart',
				data: [
				";
				for($i=0;$i<count($commits_keys);$i++){
					$github_graph.=
					" {period: '".$commits_keys[$i]." ', commits: ".$commits_by_year[$commits_keys[$i]]." ,
						  }";
					if($i!=(count($commits_keys)-1)){
						$github_graph.=" , ";
					}
				}
				$github_graph.="],
				xkey: 'period',
				ykeys: ['commits'],
				labels: ['Commits'],
				pointSize: 2,
				hideHover: 'auto',
				resize: true
			});
			
			Morris.Donut({
				element: 'morris-donut-chart',
				data: [";
				for($i=0;$i<count($percentages);$i++){
					if($percentages[$keys[$i]]==0){
						continue;
					}
					$github_graph.=" { label: '".$keys[$i]."', value: ".$percentages[$keys[$i]]."  }";
					
					if($i<count($percentages)-1){
						$github_graph.=", ";
					}
					
				}
				$github_graph.="
					],
					 formatter: function (x) { return x + '%'},
				resize: true
			});

			Morris.Bar({
				element: 'repos-by-language-bar-chart',
				data: [";
				arsort($repos_by_language,true);
			
				$keys = array_keys($repos_by_language);
				
				for($i=0;$i<8;$i++){
					if($repos_by_language[$keys[$i]]==0){
						break;
					}
					$github_graph.=" { language: '".$keys[$i]."', count: ".$repos_by_language[$keys[$i]]." }";
					
					if($i<7){
						$github_graph.=", ";
					}
					
				}
				$github_graph.="],
				xkey: 'language',
				ykeys: ['count'],
				labels: ['Projects'],
				hideHover: 'auto',
				resize: true
			});

			});
			</script>";
			//END Create Github graph js code**********************************************

			$_SESSION['github_graph']=$github_graph;
			$_SESSION['github_followers']=$github_followers;
			$_SESSION['account_duration']=$account_duration;
			$_SESSION['involvement_duration']=$involvement_duration;
			$_SESSION['repositories']=$repositories;
		}
	}
	
	//End Github Data Fetch*******************************************************
	
	
	
	//Stackoverflow Data fetch****************************************************
	
	$stackoverflow_account=false;
	if($stackoverflow_id!='' & ctype_digit($stackoverflow_id)){
		$stackoverflow_id=intval($stackoverflow_id);
		$stackoverflow_data=getDataStackOverflow($stackoverflow_id,$languages);
		if($stackoverflow_data){
			
			$stackoverflow_account=true;
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
			//Assign values to session.
			$_SESSION['reputation']=$reputation;
			$_SESSION['bronze_badges']=$bronze_badges;
			$_SESSION['silver_badges']=$silver_badges;
			$_SESSION['gold_badges']=$gold_badges;
			$_SESSION['badges_about_languages']=$badges_about_languages;
			$_SESSION['answers_about_languages']=$answers_about_languages;
			$_SESSION['answers_upvotes_about_languages']=$answers_upvotes_about_languages;
		}
		
		
	}
	
	//END Stackoverflow Data fetch************************************************
	
	
	
	
	
	
	
	
	//Twitter Data fetch**********************************************************
	
	$twitter_account=false;
	if($twitter_username!=""){
		
		$twitter_data=getTwitterData($twitter_username, $languages);
		if($twitter_data){
			$twitter_account=true;
			$twitter_followers=$twitter_data['followers'];
			$tweets_by_language=$twitter_data['tweets_by_language'];
			$retweets_by_language=$twitter_data['retweets_by_language'];
			$likes_by_language=$twitter_data['likes_by_language'];
			
			//Calculate totals.
			$total_languages_tweets=0;
			foreach($tweets_by_language as $k => $v){
				$total_languages_tweets+=$v;
			}
			$total_languages_retweets=0;
			foreach($retweets_by_language as $k => $v){
				$total_languages_retweets+=$v;
			}
			$total_languages_likes=0;
			foreach($likes_by_language as $k => $v){
				$total_languages_likes+=$v;
			}
			//Assign values to session.
			$_SESSION['twitter_followers']=$twitter_followers;
			$_SESSION['total_languages_tweets']=$total_languages_tweets;
			$_SESSION['total_languages_retweets']=$total_languages_retweets;
			$_SESSION['total_languages_likes']=$total_languages_likes;
			
			$_SESSION['tweets_by_language']=$tweets_by_language;
			$_SESSION['retweets_by_language']=$retweets_by_language;
			$_SESSION['likes_by_language']=$likes_by_language;
		}
	}
	
	//END Twitter Data fetch******************************************************
	
	
	
	//Read file with max answers by language from Stackoverflow*******************
	$max_answers=null;
	if($stackoverflow_account){
		$file = fopen("stackoverflow-max-answers.txt","r");
		while($line=fgets($file)){
			$string = explode(":",$line);
			//Eliminate last position of line that is the new line and we dont want to save it.
			$max_answers[$string[0]]=intval($string[1]);
			
			
		}
		fclose($file);
	}
	//END Read file with max answers by language from Stackoverflow***************
	
	
	
	//**********************************************USER SCORE****************************************************
	
	//********Popularity calculation, includes: Github Followers and Total Repos, Stackoverflow Reputation.*******
	//If an account is not given, it has value 0.
	if(!(isset($github_followers) && isset($total_repos))){
		$git_popularity=0;
	}
	else{
		$git_popularity = ($github_followers/GITHUB_FOLLOWERS)*0.5 +
						($total_repos/REPOSITORIES)*0.5;
	}
	if(!isset($reputation)){
		$stack_popularity=0;
	}
	else{
		$stack_popularity = ($reputation/REPUTATION);
	}
	
	
	$score_popularity = ($git_popularity*0.6)+($stack_popularity*0.4);
	// $git_popularity = (GITHUB_FOLLOWERS/GITHUB_FOLLOWERS)*0.5 +
					// (REPOSITORIES/REPOSITORIES)*0.5;
	// $stack_popularity = (50000/REPUTATION);
	// $score_popularity = ($git_popularity*0.6)+($stack_popularity*0.4);
	
	$_SESSION['score_popularity']=number_format(($score_popularity*100),2);
	
	//*******************Knowledge for each language.****************************
	
	$badges_about_languages;
	
	
	arsort($answers_about_languages,true);
	$aal_keys = array_keys($answers_about_languages);
	
	$score_knowledge_by_language;
	
	
	for($i=0;$i<count($aal_keys);$i++){
		//Get the type of badge if the user has one.
		if($answers_about_languages[$aal_keys[$i]]==0)
			break;
		
		if(strcmp($badges_about_languages[$aal_keys[$i]],"gold")==0)
			$badge =0.30;
		else
		if(strcmp($badges_about_languages[$aal_keys[$i]],"silver")==0)
			$badge=0.20;
		else
		if(strcmp($badges_about_languages[$aal_keys[$i]],"gold")==0)
			$badge=0.10;
		else
			$badge=0;
		
		$answers=$answers_about_languages[$aal_keys[$i]];
		
		$score_knowledge_by_language[$aal_keys[$i]]=($answers/$max_answers[$aal_keys[$i]])*0.5 +
													($answers_upvotes_about_languages[$aal_keys[$i]]/
													($answers_upvotes_about_languages[$aal_keys[$i]]*$answers))*0.2+
													$badge;
		echo $aal_keys[$i]." score = ".$score_knowledge_by_language[$aal_keys[$i]]."<br>";											
	}
	$_SESSION['score_knowledge_by_language']=$score_knowledge_by_language;
	// echo "<br><br>";
	// var_dump($badges_about_languages);
	// echo "<br><br>";
	// var_dump($answers_about_languages);
	// echo "<br><br>";
	// var_dump($answers_upvotes_about_languages);
	//**********************************END USER SCORE***************************************
	
	
	
	
	//Database Connection*********************************************************
	//The analyze is false when user has last updated his profile 5 days ago.
	$analyze=false;
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if($conn->connect_error){
		die("Connection failed: ".mysql_connect_error());
	}
	
	// $sql_user="SELECT last_update FROM user WHERE github_username=".$github_username.
	// " OR stackoverflow_id=".$stackoverflow_id." OR twitter_username=".$twitter_username;
	// $rows_user=mysqli_query($conn,$sql_user);
	// $row_user=mysqli_fetch_assoc($rows_user);
	
	// Database********************************************************************************
	
	//If all accounts are invalid dont do anything.
	if($github_account || $stackoverflow_account || $twitter_account){
		$db_id;
		$db_github=null;
		$db_stack=null;
		$db_twitter=null;
		$db_last_update;
		$exist=false;
		//Today's Date.
		$now = date("Y-m-d");
		$sql;
		
		//Check if github,stackoverflow or twitter account exists in DB
		$sql="SELECT * FROM user WHERE github_username='".$github_username."' OR
		stackoverflow_id=".$stackoverflow_id." OR 
		twitter_username='".$twitter_username."'";
		//Execute query.
		$rows=mysqli_query($conn,$sql);
		
		//If user exists in DB add any new account to DB.
		if($rows){
			$exist=true;
			$row = mysqli_fetch_assoc($rows);
			$db_id= $row['id'];
			$db_github=$row['github_username'];
			$db_stack=$row['stackoverflow_id'];
			$db_twitter=$row['twitter_username'];
			$db_last_update=$row['last_update'];
			
			//If github account doesn't exists and user gave a valid github account, insert it in DB.
			if($db_github==null && $github_account){
				$sql="UPDATE `expertise_analyzer`.`user` SET `github_username`='".$github_username."' WHERE id='".$db_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			//If stackoverflow account doesn't exists and user gave a valid stackoverflow account, insert it in DB.
			if($db_stack==null && $stackoverflow_account){
				$sql="UPDATE `expertise_analyzer`.`user` SET `stackoverflow_id`='".$stackoverflow_id."' WHERE id='".$db_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			//If twitter account doesn't exists and user gave a valid twitter account, insert it in DB.
			if($db_twitter==null && $twitter_account){
				$sql="UPDATE `expertise_analyzer`.`user` SET `twitter_username`='".$twitter_username."' WHERE id='".$db_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			
		}
		//User doesn't exist in DB.
		else{
			
			$sql="INSERT INTO `expertise_analyzer`.`user` (`github_username`, `stackoverflow_id`, `twitter_username`, `last_update`)
			VALUES ('".$github_username."', '".intval($stackoverflow_id)."', '".$twitter_username."', '".$now."')";
			$rows=mysqli_query($conn,$sql);
			$db_id=mysqli_insert_id($conn);
			//If any of the accounts is not valid update them to null.
			if(!$github_account){
				$sql="UPDATE `expertise_analyzer`.`user` SET `github_username`=null WHERE id='".$db_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			if(!$stackoverflow_account){
				$sql="UPDATE `expertise_analyzer`.`user` SET `stackoverflow_id`=null WHERE id='".$db_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			if(!$twitter_account){
				$sql="UPDATE `expertise_analyzer`.`user` SET `twitter_username`=null WHERE id='".$db_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			
		}
		
		//if user exists, update him in DB if only if last update > 5days.
		// $difference_obj = date_diff(date_create($now),date_create($db_last_update));
		// $update_difference_days = intval($difference_obj->days);
		
		//Insert Github Data to DB.
		if($github_account){
			if($db_github!=null){
				//If account exists, first delete the current data and then insert.
				$sql="DELETE FROM `expertise_analyzer`.`github_user` WHERE `username`='".$db_github."'";
				$rows=mysqli_query($conn,$sql);
				$sql="DELETE FROM `expertise_analyzer`.`github` WHERE `username`='".$db_github."'";
				$rows=mysqli_query($conn,$sql);
			}
			//Insert number of repositories by language.
			foreach($repos_by_language as $k => $v){
				//If there are languages with 0 repositories, continue.
				if($v==0)
					continue;
				$sql="INSERT INTO `expertise_analyzer`.`github` (`username`, `language`, `projects`) VALUES ('".$github_username."', '".$k."', '".$v."')";
				$rows=mysqli_query($conn,$sql);
			}
			//Insert user's github data.
			$sql="INSERT INTO `expertise_analyzer`.`github_user` (`username`, `followers`, `involvement_days`, `account_days`) VALUES ('".$github_username."', '".$github_followers."', '".$involvement_duration."', '".$account_duration."')";
			$rows=mysqli_query($conn,$sql);
			
		}
		
		//Insert Stackoverflow Data to DB.
		if($stackoverflow_account){
			if($db_stack!=null){
				//If account exists, first delete the current data and then insert.
				$sql="DELETE FROM `expertise_analyzer`.`stackoverflow_user` WHERE `user_id`='".$stackoverflow_id."'";
				$rows=mysqli_query($conn,$sql);
				$sql="DELETE FROM `expertise_analyzer`.`stackoverflow` WHERE `user_id`='".$stackoverflow_id."'";
				$rows=mysqli_query($conn,$sql);
			}
			//Insert number of answers by language.
			foreach($answers_about_languages as $k => $v){
				//If there are languages with 0 answers, continue.
				if($v==0)
					continue;
				$sql="INSERT INTO `expertise_analyzer`.`stackoverflow` (`user_id`, `language`, `answers`, `upvotes`, `badge`)VALUES ('".$stackoverflow_id."', '".$k."', '".$v."', '".$answers_upvotes_about_languages[$k]."', '".$badges_about_languages[$k]."')";
				$rows=mysqli_query($conn,$sql);
			}
			//Insert user's stackoverflow data.
			$sql="INSERT INTO `expertise_analyzer`.`stackoverflow_user` (`user_id`, `gold_badges`, `silver_badges`, `bronze_badges`, `reputation`) VALUES ('".$stackoverflow_id."', '".$gold_badges."', '".$silver_badges."', '".$bronze_badges."', '".$reputation."')";
			$rows=mysqli_query($conn,$sql);
		}
		
		//Insert Twitter Data to DB.
		if($twitter_account){
			if($db_github!=null){
				//If account exists, first delete the current data and then insert.
				$sql="DELETE FROM `expertise_analyzer`.`twitter_user` WHERE `username`='".$twitter_username."'";
				$rows=mysqli_query($conn,$sql);
				$sql="DELETE FROM `expertise_analyzer`.`twitter` WHERE `username`='".$twitter_username."'";
				$rows=mysqli_query($conn,$sql);
			}
			//Insert number of tweets by language.
			foreach($tweets_by_language as $k => $v){
				//If there are languages with 0 tweets, continue.
				if($v==0)
					continue;
				$sql="INSERT INTO `expertise_analyzer`.`twitter` (`username`, `language`, `tweets`, `retweets`, `likes`) VALUES ('".$twitter_username."', '".$k."', '".$v."', '".$retweets_by_language[$k]."', '".$likes_by_language[$k]."')";
				$rows=mysqli_query($conn,$sql);
			}
			$sql="INSERT INTO `expertise_analyzer`.`twitter_user` (`username`, `followers`) VALUES ('".$twitter_username."', '".$twitter_followers."')";
			$rows=mysqli_query($conn,$sql);
		}
		
	}
	//END Database*****************************************************************************
	
	
	
	
	header("Location: profile.php");
	
?>