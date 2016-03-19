<?php
session_start();


include('github-api.php');
include('stackoverflow-api.php');
include('twitter-api.php');
include('db-config.php');

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
		
			//Total repositories of user.
			$total_repos=0;
			$keys = array_keys($repos_by_language);
			
			for($i=0;$i<count($repos_by_language);$i++){
				$total_repos +=intval($repos_by_language[$keys[$i]]);
			}
			//Calculate percentages for each project's language
			$percentages = new ArrayObject($repos_by_language);
			//$percentages=$repos_by_language->getArrayCopy();
			for($i=0;$i<count($percentages);$i++){
				$percentages[$keys[$i]]=intval($percentages[$keys[$i]]/$total_repos*100);
			}
			
			//Create Github graph js code*************************************************
			$github_graph= "<script>$(function() {

			Morris.Area({
				element: 'morris-area-chart',
				data: [{
					period: '2010 Q1',
					iphone: 2666,
					ipad: null,
					itouch: 2647
				}, {
					period: '2010 Q2',
					iphone: 2778,
					ipad: 2294,
					itouch: 2441
				}, {
					period: '2010 Q3',
					iphone: 4912,
					ipad: 1969,
					itouch: 2501
				}, {
					period: '2010 Q4',
					iphone: 3767,
					ipad: 3597,
					itouch: 5689
				}, {
					period: '2011 Q1',
					iphone: 6810,
					ipad: 1914,
					itouch: 2293
				}, {
					period: '2011 Q2',
					iphone: 5670,
					ipad: 4293,
					itouch: 1881
				}, {
					period: '2011 Q3',
					iphone: 4820,
					ipad: 3795,
					itouch: 1588
				}, {
					period: '2011 Q4',
					iphone: 15073,
					ipad: 5967,
					itouch: 5175
				}, {
					period: '2012 Q1',
					iphone: 10687,
					ipad: 4460,
					itouch: 2028
				}, {
					period: '2012 Q2',
					iphone: 8432,
					ipad: 5713,
					itouch: 1791
				}],
				xkey: 'period',
				ykeys: ['iphone', 'ipad', 'itouch'],
				labels: ['iPhone', 'iPad', 'iPod Touch'],
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
	if($github_account){
		foreach($repos_by_language as $k => $v){
			if($v==0)
				continue;
			$sql="INSERT INTO `expertise_analyzer`.`github` (`username`, `language`, `projects`) VALUES ('".$github_username."', '".$k."', '".$v."')";
			$rows=mysqli_query($conn,$sql);
		}
		$sql="INSERT INTO `expertise_analyzer`.`github_user` (`username`, `followers`, `involvement_days`, `account_days`) VALUES ('".$github_username."', '".$github_followers."', '".$involvement_duration."', '".$account_duration."')";
		$rows=mysqli_query($conn,$sql);
	}
	else{
		$github_username=null;
	}
	
	if($stackoverflow_account){
		foreach($answers_about_languages as $k => $v){
			if($v==0)
				continue;
			$sql="INSERT INTO `expertise_analyzer`.`stackoverflow` (`user_id`, `language`, `answers`, `upvotes`, `badge`)VALUES ('".$stackoverflow_id."', '".$k."', '".$v."', '".$answers_upvotes_about_languages[$k]."', '".$badges_about_languages[$k]."')";
			$rows=mysqli_query($conn,$sql);
		}
		$sql="INSERT INTO `expertise_analyzer`.`stackoverflow_user` (`user_id`, `gold_badges`, `silver_badges`, `bronze_badges`, `reputation`) VALUES ('".$stackoverflow_id."', '".$gold_badges."', '".$silver_badges."', '".$bronze_badges."', '".$reputation."')";
		$rows=mysqli_query($conn,$sql);
	}
	else{
		$stackoverflow_id=null;
	}
	
	//Insert twitter's data into DB
	if($twitter_account){
		//First delete old entries of user.
			$sql="DELETE FROM `expertise_analyzer`.`twitter_user` WHERE `username`='".$twitter_account."'";
			$rows=mysqli_query($conn,$sql);
			$sql="DELETE FROM `expertise_analyzer`.`twitter` WHERE `username`='".$twitter_account."'";
			$rows=mysqli_query($conn,$sql);
			
			//Insert new entries.
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
	else{
		$twitter_username=null;
	}
	$now = date("Y-m-d");
	if($github_username!=null || $stackoverflow_id!=null || $twitter_username!=null){
		$exists = false;
		$db_github=null;
		$db_stack=null;
		$db_twitter=null;
		$db_last_update=null;
		//check if a user already exists in DB.
		if($github_username!=null){
			$sql="SELECT * FROM user WHERE github_username='".$github_username."'";
			$rows=mysqli_query($conn,$sql);
			if($rows){
				$exists=true;
				$row = mysqli_fetch_assoc($rows);
				$db_last_update =$row['last_update'];
				$db_github=$row['github_username'];
			}
		}
		else
		if($stackoverflow_id!=null){
			$sql="SELECT * FROM user WHERE stackoverflow_id='".$stackoverflow_id."'";
			$rows=mysqli_query($conn,$sql);
			if($rows){
				$exists=true;
				$row = mysqli_fetch_assoc($rows);
				$db_last_update =$row['last_update'];
				$db_stack=$row['stackoverflow_id'];
			}
		}
		else
		if($twitter_username!=null){
			$sql="SELECT * FROM user WHERE twitter_username='".$twitter_username."'";
			$rows=mysqli_query($conn,$sql);
			if($rows){
				$exists=true;
				$row = mysqli_fetch_assoc($rows);
				$db_last_update =$row['last_update'];
				$db_twitter=$row['twitter_username'];
			}
		}
		
		
		//if user doesn't exist, add him to DB
		if(!$exists){
			$sql="INSERT INTO `expertise_analyzer`.`user` (`github_username`, `stackoverflow_id`, `twitter_username`, `last_update`) VALUES ('".$github_username."', ".intval($stackoverflow_id).", '".$twitter_username."', '".$now."')";
			$rows=mysqli_query($conn,$sql);
		}

		//if user exists, update him in DB if only if last update > 5days.
		$difference_obj = date_diff(date_create($now),date_create($db_last_update));
		$update_difference_days = intval($difference_obj->days);
		
		if($exists && $update_difference_days>5){
			$sql="UPDATE `expertise_analyzer`.`user` SET ";
			$comma=false;
			if($github_username!=null){
				$sql.="`github_username`='".$github_username."'";
				$comma=true;
			}
			if($stackoverflow_id!=null){
				if($comma){
					$sql.=", ";
				}
				$sql.="`stackoverflow_id`='".intval($stackoverflow_id)."'";
				$comma=true;
			}
			if($twitter_username!=null){
				if($comma){
					$sql.=", ";
				}
				$sql.="`twitter_username`='".$twitter_username."'";
			}
			$sql.=", `last_update`='".$now."' ";
			//Query for user using the unique field provided between github, stackoverflow and twitter.
			if($db_github)
				$sql.=" WHERE `github_username`='".$db_github."'";
			else if($db_stack)
				$sql.=" WHERE `stackoverflow_id`='".$db_stack."'";
			else if($db_twitter)
				$sql.=" WHERE `twitter_username`='".$db_twitter."'";
			
			$rows=mysqli_query($conn,$sql);
		}
	}
	
	
	
	// while($row=mysqli_fetch_assoc($rows)){
		
	// }
	
	//END Database Connection******************************************************
	
	//header("Location: profile.php");
	
?>