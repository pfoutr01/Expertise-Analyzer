
<?php
//Use http://phphttpclient.com/ library for REST client php.

// Point to where you downloaded the phar.
include('httpful.phar');
include('github-app-config.php');

//Change of max execution time because in some cases exceed the current time limit.
ini_set('max_execution_time', 300);


//Authentication using cliend id and cliend secret.
//$client_id_secret = "&client_id=66e04a81dd7fa1a111a5&client_secret=03fa35329680862a068ccb02c15da77b045802b9";
//The user login username;
//$user_id="pfoutr01";
//The language search for.
//$language ="html";
//$extension="html";

//Returns user's information.
function getUser($user_id,$client_id_secret){
	$uri ="https://api.github.com/users/".$user_id."?".$client_id_secret;
	$response = \Httpful\Request::get($uri)->expectsJson()->send();
	$userArray = json_decode($response);
	return $userArray;

}
//Returns the followers of a user.
function followers($userArray){
	
	$followers = $userArray->{"followers"};
	
	return $followers;
}

//Returns user repositories
//Included repositories that user owns and repositories that user is a member of.
//Involvement is the days that user made his 1st repository until today.
function repositories_and_involvement($user_id, $client_id_secret,$languages){
	
	$page=1;
	$count1=0;
	$daysInvolved=0;
	$today =date_create(date("Y-m-d"));
	$languages_keys = array_keys($languages);
	$repos_name;
	$rn_counter=0;
	
	//Count repositories that user is member of.
	do{
		$uri ="https://api.github.com/users/".$user_id."/repos?type=member&page=".$page.$client_id_secret;
		$response = \Httpful\Request::get($uri)->expectsJson()->send();
		$repos1 = json_decode($response);
		if(count($repos1)==0){
			break;
		}
		for($i=0;$i<count($repos1);$i++){
			
			//Save repos name.
			$repos_name[$rn_counter]=array("name" => $repos1[$i]->{'name'}, "owner"=> $repos1[$i]->{'owner'}->{'login'} );
			$rn_counter++;
			//Increase language by 1 if project language there is in $languages array.
			$language=strtoupper($repos1[$i]->{'language'});
			
			if(in_array($language,$languages_keys)){
				
				$languages[$language]++;
			}
			$temp = split("T",$repos1[$i]->{"created_at"});
			$dateCreated = date_create($temp[0]);
			$diff = date_diff($today,$dateCreated);
			
			if($daysInvolved<$diff->{"days"}){
				$daysInvolved=$diff->{"days"};
			}
		}
		$count1+=count($repos1);
		$page++;
		
		
	}while(count($repos1)>0);
	
	
	//Count repositories of user. Doesn't count forked repositories.
	$page=1;
	$count2=0;
	do{
		$uri2="https://api.github.com/users/".$user_id."/repos?type=owner&page=".$page.$client_id_secret;
		$response2 = \Httpful\Request::get($uri2)->expectsJson()->send();
		$repos2 = json_decode($response2);
		if(count($repos2)==0){
			break;
		}
		
		for($i=0;$i<count($repos2);$i++){
			//if it's forked continue.
			if($repos2[$i]->{'fork'}){
				continue;
			}
			
			//Save repos name.
			$repos_name[$rn_counter]=array("name" => $repos2[$i]->{'name'}, "owner"=> $repos2[$i]->{'owner'}->{'login'} );
			$rn_counter++;
			//Increase language by 1 if project language there is in $languages array.
			$language=strtoupper($repos2[$i]->{'language'});
			
			if(in_array($language,$languages_keys)){
				$languages[$language]++;
			}
			$temp = split("T",$repos2[$i]->{"created_at"});
			$dateCreated = date_create($temp[0]);
			$diff = date_diff($today,$dateCreated);
			
			if($daysInvolved<$diff->{"days"}){
				$daysInvolved=$diff->{"days"};
			}
			$count2++;
		}
		
		$page++;
		
	}while(count($repos2)>0);
	
	$repos = $count1+$count2;
	
	
	return array('repos'=>$repos,'involved'=>$daysInvolved,'languages'=>$languages,'repos_name'=>$repos_name);
	
}

//Returns user commits by a language.
// function commits($user_id, $language, $extension, $client_id_secret){
	// $count = 0;
	
	
	// $uri ="https://api.github.com/search/code?q=.".$extension."+in:path+user:".$user_id."+language:".$language.$client_id_secret;
	// $response = \Httpful\Request::get($uri)->expectsJson()->send();
	// $json_response=json_decode($response);
	// //Correct the if statement cause of error.
	
		
	// // if($page==1)
	// // var_dump(json_decode($response),true);
	// var_dump($json_response);
	// $count = intval($json_response->{"total_count"});
		
	
	// return $count;
// }


//Gia na leitourgisoun ta commits prepei na apothikevw kai to onoma tou owner ka8e repository kai na to vazw
//sto uri, dioti opws einai twra xanei ta repositories pou o xristis einai member.
//Get user commits for each project.?type=member
function commits($user_id,$repos_by_name,$client_id_secret){
	$page=1;
	//Years to count commits.
	$commits_counter=array("2009"=>0,"2010"=>0,"2011"=>0,"2012"=>0,"2013"=>0,"2014"=>0,"2015"=>0,"2016"=>0);
	for($i=0;$i<count($repos_by_name);$i++){
		$repo_name=$repos_by_name[$i]['name'];
		$repo_owner=$repos_by_name[$i]['owner'];
		do{
			//Uri to get commits for a repo that user contributed to.
			$uri="https://api.github.com/repos/".$repo_owner."/".$repo_name."/commits?page=".$page.$client_id_secret;
			$response = \Httpful\Request::get($uri)->expectsJson()->send();
			$commits = json_decode($response);
			//if no commits exist break. It returns an object with a message, instead it returns an array of objects.
			if(gettype($commits)=="object"){
				break;
			}
			// echo "count ".count($commits)."<br>";
			// var_dump($commits);
			// echo"<br>----<br>";
			//For each commit in page.
			for($j=0;$j<count($commits);$j++){
				//Some author fields are returned NULL from Github API.
				if($commits[$j]->{"author"}==null){
					echo "continue <br>";
					continue;
				}
				//echo "<br>sigkrisi => ".$commits[$j]->{"author"}->{"login"}." == ".$user_id;
				if(strcmp($commits[$j]->{"author"}->{"login"},$user_id)==0){
					
					
					//get the year of commit
					$year = $commits[$j]->{"commit"}->{"author"}->{"date"};
					$year= split('-',$year);
					$year=strval($year[0]);
					$commits_counter[$year]++;
				}
			}
			$page++;
			
		}while(count($commits)>0);
	}
	return $commits_counter;
}

//Account duration are the days from the date of account creation until today.
function accountDuration($userArray){
	
	
	$dateCreated = $userArray->{"created_at"};
	$temp = split("T",$dateCreated);
	$dateCreated = date_create($temp[0]);
	
	$today = date_create(date("Y-m-d"));
	$duration = date_diff($dateCreated,$today);
	
	$days = $duration->{"days"};

	return $days;
}

function getData($user_id,$languages){
	$data=false;
	$client_id_secret = "&client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET;
	
	$userArray = getUser($user_id,$client_id_secret);
	//var_dump($userArray);
	
	//If user found, the object returned has a field 'login', otherwise doesnt have field 'login'.
	if(property_exists($userArray, 'login')){
		
		$followers = followers($userArray);
		$account_duration_days = accountDuration($userArray);
		$temp =repositories_and_involvement($user_id,$client_id_secret,$languages);
		$repositories = $temp['repos'];
		$involvement_days=$temp['involved'];
		$repos_by_language=$temp['languages'];
		$repos_by_name=$temp['repos_name'];
		//var_dump($repos_by_name);
		$commits_by_year=commits($user_id,$repos_by_name,$client_id_secret);
		//var_dump($commits_by_year);
		$data = array('repositories'=> $repositories,
					'followers'=>$followers,
					'account_duration'=>$account_duration_days,
					'involvement_duration'=>$involvement_days,
					'repos_by_language'=>$repos_by_language,
					'commits_by_year'=>$commits_by_year);
		
		
	}
	
	
	return $data;
	
}

?>

