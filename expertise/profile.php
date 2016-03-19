<?php
	session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Profile</title>
	
	
	
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME CSS -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
     <!-- FLEXSLIDER CSS -->
<link href="assets/css/flexslider.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />    
  <!-- Google	Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
	
	<!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">
	
	 <!-- DataTables CSS -->
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
	
</head>
<body >
  
 <div class="navbar navbar-inverse navbar-fixed-top " id="menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img class="logo-custom" src="assets/img/logo.png" alt=""  /></a>
            </div>
            <div class="navbar-collapse collapse move-me">
                <ul class="nav navbar-nav navbar-right">
                    <li ><a href="index.html">HOME</a></li>
                     
                    <li><a href="#github_data">MY PROFILE</a></li>
                    
                     <li><a href="#contact-sec">ABOUT US</a></li>
                </ul>
            </div>
           
        </div>
    </div>
      <!--NAVBAR SECTION END-->
	   <header class="header">
       <br>
	   
     </header>              
     
	 <!-- SIDEBAR SECTION-->
     
	  <div class="navbar-default sidebar" role="navigation">
	  
                <div class="row">
				
				<div class="col-md-3" id="leftCol">
				
                    <ul class="nav   affix" id="side-menu"  data-offset-top="255" data-offset-bottom="200">
                    
                        <li>
                            <a href="#github_data"><i class="fa fa-github fa-fw"></i> Github Data</a>
                        </li>
                        <li>
                            <a href="#stackoverflow_data"><i class="fa fa-stack-overflow fa-fw"></i> Stackoverflow Data</a>
                            
                        </li>
                        <li>
                            <a href="#twitter_data"><i class="fa fa-twitter fa-fw"></i> Twitter Data</a>
                        </li>
                        <li>
                            <a href="#user_scores"><i class="fa fa-user fa-fw"></i> User Scores</a>
                        </li>
                       
                    </ul>
                </div>
				</div>
                <!-- /.sidebar-collapse -->
            </div>
	 
	 <!-- SIDEBAR END          -->
              
           

	
	
	 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
				<div id="github_data" class="set-pad">
						
                    <h1 class="page-header text-center">Github Data</h1>
					
					</div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
	<!-- *************************Github account data***************************-->		
            <div class="row">
			<?php
				if(!isset($_SESSION['repositories'])){
					echo "<p align='center'>Github account didn't found or not provided.</p>";
				}
			?>
                <div class="col-lg-3 col-md-6">
                  
                       
                           
									<?php 
									if(isset($_SESSION['repositories'])){
											echo '
											  <div class="panel panel-primary">
											 <div class="panel-heading">
											<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-folder fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">
											'.$_SESSION['repositories'],'
												</div>
											<div>Repositories</div>
												</div>
											</div>
											</div>
											</div>
											'; 
										}
										
									
										
									?>
								
                        
                    
                    
                </div>
                <div class="col-lg-3 col-md-6">
                    
									<?php
										if(isset($_SESSION['involvement_duration'])){
											echo '
											<div class="panel panel-green">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-clock-o fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
												
											'.$_SESSION['involvement_duration'].
											"
															</div>
														<div>Involvement's Duration(days)</div>
													</div>
												</div>
											</div>
											
										</div>
											"; 
										}
										
									
										
									?>
					
                </div>
                <div class="col-lg-3 col-md-6">
                   
									<?php 
									if(isset($_SESSION['account_duration'])){
											echo '
												 <div class="panel panel-yellow">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-clock-o fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
											'.$_SESSION['account_duration'].
											"
															</div>
													<div>Account's Duration(days)</div>
													</div>
												</div>
											</div>
										 
										</div>
											"; 
										}
										
									
									?>
					
                </div>
                <div class="col-lg-3 col-md-6">
                   
									<?php 
										if(isset($_SESSION['github_followers'])){
											echo '
												 <div class="panel panel-red">
											<div class="panel-heading">
												<div class="row">
													<div class="col-xs-3">
														<i class="fa fa-users fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge">	
											'.$_SESSION['github_followers'].
											"
														</div>
														<div>Followers</div>
													</div>
												</div>
											</div>
										
										</div>
											"; 
										}
									
									?>
						
                </div>
           
			</div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 ">
				
					<?php
					if(isset($_SESSION['github_graph']))
						echo '
						<div id="graph1" class="set-pad">
						<div class="set-pad">
						<div class="panel panel-default ">
							<div   class="panel-heading ">
								<i  class="fa fa-bar-chart-o fa-fw" ></i> Commits by year
								
							</div>
							</div>
							
							<!-- /.panel-heading -->
							<div class="panel-body">
								<div id="morris-area-chart"></div>
							</div>
							<!-- /.panel-body -->
						</div>
						</div>
						<!-- /.panel -->
						';
						
					?>
					
					<?php
					if(isset($_SESSION['github_graph'])){
						echo '
								<div id="graph2" class="set-pad">
						<div class="set-pad">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-bar-chart-o fa-fw"></i> Projects by Language
							</div>
							<!-- /.panel-heading -->
							<div class="panel-body">
								<div class="row">
									
									<!-- /.col-lg-4 (nested) -->
									<div class="col-lg-12">
										<div id="repos-by-language-bar-chart"></div>
									</div>
									<!-- /.col-lg-8 (nested) -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.panel-body -->
						</div>
						</div>
						</div>
						<!-- /.panel -->
						
							';
					}
					?>
					<?php
						if(isset($_SESSION['github_graph'])){
							echo '
									<div id="graph3" class="set-pad">
									<div class="set-pad">
									 <div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i> Languages Percentage(%)
								</div>
								<div class="panel-body">
									<div id="morris-donut-chart"></div>
									<a href="#" class="btn btn-default btn-block">View Details</a>
								</div>
								<!-- /.panel-body -->
								</div>
								</div>
								</div>
							';
						}
					?>
					
					
					
                
                <!-- /.col-lg-8 -->
					
				
					
                   
                  
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
<!-- *************************************END Github Account data********************** -->

<!-- *************************************Stackoverflow Account data********************** -->
			<div class="row">
			<div id="stackoverflow_data" class="set-pad">
                <div class="col-lg-12">
                    <h1 id="stackoverflow_data" class="page-header text-center">Stackoverflow Data</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			</div>
            <!-- /.row -->
			  <div class="row">
			  
			  	<?php
				if(!isset($_SESSION['reputation'])){
					echo "<p align='center'>Stackoverflow account didn't found or not provided.</p>";
				}
			?>
                <div class="col-lg-3 col-md-6">
                  
									<?php 
									if(isset($_SESSION['reputation'])){
										echo	'
											  <div class="panel panel-primary">
											<div class="panel-heading">
												<div class="row">
													<div class="col-xs-3">
														<i class="fa fa-users fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge">	
											'. $_SESSION['reputation'].
											"
															</div>
													<div>Stackoverflow Reputation</div>
													</div>
												</div>
											</div>
										
										</div>
											"; 
										}
										
									
										
									?>
					
                </div>
                <div class="col-lg-3 col-md-6">
                   
									<?php
										if(isset($_SESSION['gold_badges'])){
											echo '
											 <div class="panel panel-gold">
											<div class="panel-heading">
												<div class="row">
													<div class="col-xs-3">
														<i class="fa fa-certificate fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge">	
											'.$_SESSION['gold_badges']."
															</div>
															<div>Gold badges</div>
														</div>
													</div>
												</div>
												
											</div>
											"; 
										}
										
									
										
									?>
						
                </div>
                <div class="col-lg-3 col-md-6">
                   
									<?php 
									if(isset($_SESSION['silver_badges'])){
											echo '
											 <div class="panel panel-silver">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-certificate fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">
											'.$_SESSION['silver_badges']."
														</div>
														<div>Silver badges</div>
													</div>
												</div>
											</div>
										 
										</div>
											"; 
										}
									
									
									?>
						
                </div>
                <div class="col-lg-3 col-md-6">
                    
									<?php 
										if(isset($_SESSION['bronze_badges'])){
											echo	'
											<div class="panel panel-bronze">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-certificate fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
											'. $_SESSION['bronze_badges']."
														</div>
														<div>Bronze badges</div>
													</div>
												</div>
											</div>
										
										</div>
											"; 
										}
										
									?>
						
                </div>
				
				<br>
				<div class="col-lg-12">
				</div>
				<!-- Row to represent badges, answers and upvotes per language-->
				<div class="row">
				<div class="col-lg-6 ">
				 <?php
				 if(isset($_SESSION['badges_about_languages'])){
				echo'
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Top Badge per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-badges">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Badge</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';
									$table=$_SESSION['badges_about_languages'];
									$i=0;
									foreach($table as $k => $v){
										
										if($v){
											echo"
											<tr>
												<td>".($i+1)."</td>
												<td>".$k."</td>
												<td>".$v."</td>
											   
											</tr>
												";
												$i++;
										}
									}
									
				echo '					  
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
               
           
			';
				 }
				 ?>
				  </div>
                <!-- /.col-lg-4 -->
				 
				 
				 
				
				 <div class="col-lg-6 ">
				 <?php
				  if(isset($_SESSION['answers_about_languages'])){
					echo'
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Answers per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-answers">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Answers</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';
									$table=$_SESSION['answers_about_languages'];
									$i=0;
									foreach($table as $k => $v){
										
										if($v){
											echo"
											<tr>
												<td>".($i+1)."</td>
												<td>".$k."</td>
												<td>".$v."</td>
											   
											</tr>
												";
												$i++;
										}
									}
									
				echo '					  
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
              
				';
				}
			?>
			
			  </div>
                <!-- /.col-lg-6 -->
				
            </div>
            <!-- /.row -->
			
			<div class="row">
				
				<div class="col-lg-6 ">
				 <?php
				  if(isset($_SESSION['answers_upvotes_about_languages'])){
					echo'
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Answer\'s Upvotes per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-upvotes">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Upvotes</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';
									$table=$_SESSION['answers_upvotes_about_languages'];
									$i=0;
									foreach($table as $k => $v){
										//if($i==10)
											//break;
										if($v){
											echo"
											<tr>
												<td>".($i+1)."</td>
												<td>".$k."</td>
												<td>".$v."</td>
											   
											</tr>
												";
												$i++;
										}
									}
									
				echo '					  
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
              
				';
				}
			?>
			
			  </div>
                <!-- /.col-lg-6 -->
				
				
            </div>
            <!-- /.row -->
<!-- *************************************END Stackoverflow Account data***************************************** -->

			
<!-- *************************************Twitter Account data***************************************** -->
			<div class="row">
			<div id="twitter_data" class="set-pad">
                <div class="col-lg-12">
                    <h1 id="stackoverflow_data" class="page-header text-center">Twitter Data</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			</div>
            <!-- /.row -->
			  <div class="row">
			  	<?php
				if(!isset($_SESSION['twitter_followers'])){
					echo "<p align='center'>Twitter account didn't found or not provided.</p>";
				}
			?>
                <div class="col-lg-3 col-md-6">
                    
									<?php 
									if(isset($_SESSION['twitter_followers'])){
											echo '
											<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-users fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
											'.$_SESSION['twitter_followers']."
														</div>
														<div>Followers</div>
													</div>
												</div>
											</div>
										
										</div>
											"; 
										}
										
									
										
									?>
						
                </div>
				
				 <div class="col-lg-3 col-md-6">
                    
									<?php
										if(isset($_SESSION['total_languages_tweets'])){
											echo '
											<div class="panel panel-green">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-twitter-square fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
											'.$_SESSION['total_languages_tweets']."
															</div>
															<div>Total tweets about Languages</div>
														</div>
													</div>
												</div>
												
											</div>
											"; 
										}
										
									
										
									?>
					
                </div>
				
				 <div class="col-lg-3 col-md-6">
                    
									<?php
										if(isset($_SESSION['total_languages_retweets'])){
											echo '
											<div class="panel panel-yellow">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-retweet fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">
											'.$_SESSION['total_languages_retweets']."
														</div>
										<div>  Total retweets about Languages</div>
											</div>
										</div>
									</div>
									
								</div>
											"; 
										}
										
									
										
									?>
						
                </div>
				
					 <div class="col-lg-3 col-md-6">
                    
									<?php
										if(isset($_SESSION['total_languages_likes'])){
											echo '
								<div class="panel panel-red">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-heart fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">
											'.$_SESSION['total_languages_likes']."
																</div>
												<div>Total likes about Languages</div>
											</div>
										</div>
									</div>
									
								</div>
											"; 
										}
									
									
										
									?>
				
                </div>
               
            </div>
            <!-- /.row -->
			
			<div class="row">
			<div class="col-lg-12">
			
			
			
			</div>
			</div>
			
			<!-- Row to represent badges, answers and upvotes per language-->
				<div class="row">
				<div class="col-lg-6 ">
				 <?php
				 if(isset($_SESSION['tweets_by_language'])){
				echo'
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Tweets per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-tweets">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Tweets</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';
									$table=$_SESSION['tweets_by_language'];
									$i=0;
									foreach($table as $k => $v){
										
										if($v){
											echo"
											<tr>
												<td>".($i+1)."</td>
												<td>".$k."</td>
												<td>".$v."</td>
											   
											</tr>
												";
												$i++;
										}
									}
									
				echo '					  
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
               
           
			';
				 }
				 ?>
				  </div>
                <!-- /.col-lg-4 -->
				 
				 
				 
				
				 <div class="col-lg-6 ">
				 <?php
				  if(isset($_SESSION['retweets_by_language'])){
					echo'
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Retweets per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-retweets">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Retweets</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';
									$table=$_SESSION['retweets_by_language'];
									$i=0;
									foreach($table as $k => $v){
										
										if($v){
											echo"
											<tr>
												<td>".($i+1)."</td>
												<td>".$k."</td>
												<td>".$v."</td>
											   
											</tr>
												";
												$i++;
										}
									}
									
				echo '					  
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
              
				';
				}
			?>
			
			  </div>
                <!-- /.col-lg-6 -->
				
            </div>
            <!-- /.row -->
			
			<div class="row">
				
				<div class="col-lg-6 ">
				 <?php
				  if(isset($_SESSION['likes_by_language'])){
					echo'
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Tweet\'s Likes per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-likes">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Likes</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';
									$table=$_SESSION['likes_by_language'];
									$i=0;
									foreach($table as $k => $v){
										//if($i==10)
											//break;
										if($v){
											echo"
											<tr>
												<td>".($i+1)."</td>
												<td>".$k."</td>
												<td>".$v."</td>
											   
											</tr>
												";
												$i++;
										}
									}
									
				echo '					  
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
              
				';
				}
			?>
			
			  </div>
                <!-- /.col-lg-6 -->
				
				
            </div>
            <!-- /.row -->
		<!-- ***********************************END Twitter Account Data***************************************************-->	
		
		
		<!-- ************************* USER SCORES data***************************-->	

			<div class="row">
			<div id="user_scores" class="set-pad">
                <div class="col-lg-12">
                    <h1  class="page-header text-center">User Scores</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			</div>
			
            <div class="row">
			<?php
				if(!isset($_SESSION['repositories'])){
					echo "<p align='center'>Github account didn't found or not provided.</p>";
				}
			?>
                <div class="col-lg-3 col-md-6">
                  
                       
                           
									<?php 
									if(isset($_SESSION['score_popularity'])){
											echo '
											  <div class="panel panel-primary">
											 <div class="panel-heading">
											<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-folder fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">
											'.$_SESSION['score_popularity'],'%
												</div>
											<div>Popularity</div>
												</div>
											</div>
											</div>
											</div>
											'; 
										}
										
									
										
									?>
								
                        
                    
                    
                </div>
                <div class="col-lg-3 col-md-6">
                    
									<?php
										if(isset($_SESSION['involvement_duration'])){
											echo '
											<div class="panel panel-green">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-clock-o fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
												
											'.$_SESSION['involvement_duration'].
											"
															</div>
														<div>Involvement's Duration(days)</div>
													</div>
												</div>
											</div>
											
										</div>
											"; 
										}
										
									
										
									?>
					
                </div>
                <div class="col-lg-3 col-md-6">
                   
									<?php 
									if(isset($_SESSION['account_duration'])){
											echo '
												 <div class="panel panel-yellow">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-clock-o fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
											'.$_SESSION['account_duration'].
											"
															</div>
													<div>Account's Duration(days)</div>
													</div>
												</div>
											</div>
										 
										</div>
											"; 
										}
										
									
									?>
					
                </div>
                <div class="col-lg-3 col-md-6">
                   
									<?php 
										if(isset($_SESSION['github_followers'])){
											echo '
												 <div class="panel panel-red">
											<div class="panel-heading">
												<div class="row">
													<div class="col-xs-3">
														<i class="fa fa-users fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge">	
											'.$_SESSION['github_followers'].
											"
														</div>
														<div>Followers</div>
													</div>
												</div>
											</div>
										
										</div>
											"; 
										}
									
									?>
						
                </div>
				
				<?php
				$score_knowledge_by_language = $_SESSION['score_knowledge_by_language'];
				$skbl_keys = array_keys($score_knowledge_by_language);
				echo'
				 <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Knowledge per Language
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Language</th>
                                            <th>Score</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>';
									for($i=0;$i<count($score_knowledge_by_language);$i++)
									echo'
                                        <tr>
                                            <td>'.($i+1).'</td>
                                            <td>'.$skbl_keys[$i].'</td>
                                            <td>'.$score_knowledge_by_language[$skbl_keys[$i]].'</td>
                                           
                                        </tr>
                                       ';
										
                                    echo '</tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
				
				';
				?>
           
			</div>
            <!-- /.row -->
          
		  
			
<!-- *************************************END USER SCORE********************** -->
		
		
		
		
			</div>
        </div>
        <!-- /#page-wrapper -->
    <!-- END Data-->
     
    <div id="contact-sec"   >
           <div class="overlay">
 <div class="container set-pad">
      <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line text-center">ABOUT US  </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      This website is made for academic purposes, as the implementation of my thesis in
					  University of Cyprus.
					  sdkjhsdjkhsdljkhsdjkl
					  slkdnklsdjklsjdksjdlks
					  skdjskldjskldjklsdjlksjdklsjdklsndlksndklsnd
					  sdklnskdnskldnklsndklskndklsndlksnd
					  skdnlksdnklsndklsndlknlskdnsdkln
                         </p>
						 </br>
						   <p data-scroll-reveal="enter from the bottom after 0.3s">
                      This website is made for academic purposes, as the implementation of my thesis in
					  University of Cyprus.
					  sdkjhsdjkhsdljkhsdjkl
					  slkdnklsdjklsjdksjdlks
					  skdjskldjskldjklsdjlksjdklsjdklsndlksndklsnd
					  sdklnskdnskldnklsndklskndklsndlksnd
					  skdnlksdnklsndklsndlknlskdnsdkln
                         </p>
						 
                 </div>

             </div>
             <!--/.HEADER LINE END-->
           <div class="row set-row-pad"  data-scroll-reveal="enter from the bottom after 0.5s" >
           
               
                 

                   
     
              
              
                
               </div>
                </div>
          </div> 
       </div>
     <div class="container">
             <div class="row set-row-pad"  >
    <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1 " data-scroll-reveal="enter from the bottom after 0.4s">

                    <h2 ><strong>Contact Us </strong></h2>
        <hr />
                    <div>
                        
                       <h4><strong>Country: </strong>Cyprus</h4>
                       
                        <h4><strong>Email: </strong>pfoutr01@cs.ucy.ac.cy</h4>
                    </div>


                </div>
                 <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1" data-scroll-reveal="enter from the bottom after 0.4s">

                    <h2 ><strong>Social Conectivity </strong></h2>
        <hr />
                    <div >
                        <a href="#">  <img src="assets/img/Social/facebook.png" alt="" /> </a>
                    
                     <a href="#"> <img src="assets/img/Social/twitter.png" alt="" /></a>
                    </div>
                    </div>


                </div>
				</div>
          
     <!-- CONTACT SECTION END-->
    <div id="footer">
          &copy 2016 Expertise Analyzer | All Rights Reserved |  <a href="http://binarytheme.com" style="color: #fff" target="_blank">Design by : binarytheme.com</a>
    </div>
     <!-- FOOTER SECTION END-->
	 
	 <!-- BOOTSTRAP MIN JS -->
	<script src="assets/js/bootstrap.min.js" type="script"></script>
	<script src="assets/js/jquery-1.12.0.min.js" type="script"></script>
   
    <!--  Jquery Core Script -->
   <!-- <script src="assets/js/jquery-1.10.2.js"></script> -->
    <!--  Core Bootstrap Script -->
    <!-- <script src="assets/js/bootstrap.js"></script> -->
    <!--  Flexslider Scripts --> 
         <script src="assets/js/jquery.flexslider.js"></script>
     <!--  Scrolling Reveal Script -->
    <script src="assets/js/scrollReveal.js"></script>
    <!--  Scroll Scripts --> 
    <script src="assets/js/jquery.easing.min.js"></script>
    <!--  Custom Scripts --> 
         <script src="assets/js/custom.js"></script>
		 
		 <!-- jQuery -->
     <script src="bower_components/jquery/dist/jquery.min.js"></script> 

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="bower_components/raphael/raphael-min.js"></script>
    <script src="bower_components/morrisjs/morris.min.js"></script>
    <!-- <script src="js/morris-data.js"></script> -->

	<!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<!-- Script to work right datatable with id=dataTables-example -->
	<!-- For stackoverflow tables-->
	  <script>
    $(document).ready(function() {
        $('#dataTables-badges').DataTable({
                responsive: true
        });
    });
    </script>
	  <script>
    $(document).ready(function() {
        $('#dataTables-answers').DataTable({
                responsive: true
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#dataTables-upvotes').DataTable({
                responsive: true
        });
    });
    </script>
	
	<!-- For twitter tables-->
	 <script>
    $(document).ready(function() {
        $('#dataTables-tweets').DataTable({
                responsive: true
        });
    });
    </script>
	 <script>
    $(document).ready(function() {
        $('#dataTables-retweets').DataTable({
                responsive: true
        });
    });
    </script>
	 <script>
    $(document).ready(function() {
        $('#dataTables-likes').DataTable({
                responsive: true
        });
    });
    </script>
	
	
	<?php
	//Print JS code to create graphs.
		if(isset($_SESSION['github_graph'])){
			echo $_SESSION['github_graph'];
		}
	?>	
		 
</body>
</html>

