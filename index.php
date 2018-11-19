<?php 
	session_start(); 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Question Game</title>
	<link href="style.css" rel="stylesheet" />
	<link rel="shortcut icon" type="favicon.png" href="favicon.png"/>
                <meta charset=“utf-8”> 
                <meta name="description" content="Help">
                <meta name="keywords" content="trivia,questions">
                <meta name="author" content="Antrea Chrysanthou">
</head>
<body>

	<header>
		<div class="topnav" >
			<a class="active" href="index.php">Home Page</a>
			<a href="help.php">Help</a>
			<a href="score.php">Score</a>
		</div> 
	</header>
	<?php
		$questionNumber;
		$typeOfQuestion;
		$score;
		$answer1;
		$answer2;
		$answer3;
		$answer4;
		$question;
		$correctAnswer;
		$selectButtonValue;
		$isAnswerCorrect1;
		$isAnswerCorrect2;
		$isAnswerCorrect3;
		$isAnswerCorrect4;
		$isAnswerCorrect5;
		$lastQuestion;
		$Questions = simplexml_load_file('QuestionsNew.xml');
		$Easy = $Questions->Easy;
		$EasyQuestions = $Easy->Question;
		$Medium = $Questions->Medium;
		$MediumQuestions = $Medium->Question;
		$Hard = $Questions->Hard;
		$HardQuestions = $Hard->Question;

		function generateQuestionAndAnswers($questionSet){
			$randomNum=mt_rand(1,25);
			$GLOBALS['answer1']=$questionSet[$randomNum]->A[0];
			$GLOBALS['answer2']=$questionSet[$randomNum]->A[1];
			$GLOBALS['answer3']=$questionSet[$randomNum]->A[2];
			$GLOBALS['answer4']=$questionSet[$randomNum]->A[3];
			$GLOBALS['question'] = $questionSet[$randomNum]->Q;
			$GLOBALS['correctAnswer'] = $questionSet[$randomNum]->CA;
		}

		//wellcome screen
		if($_SERVER['REQUEST_METHOD']=='GET'){
			echo "<div class=\"mainDiv\">
					<div id=\"welcome\" style=\"display:inline-block;\">
						<p class=\"wellcomeText\">Question Game</p>
						<p class=\"normalText\">You are going to be asked a general questions.</p>
						<form action=\"\" method=\"post\">

							<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"start_game\" value=\"Start\"/>
							<input name=\"first_question\" id=\"first_question\" type=\"hidden\" value=\"true\"/>
						</form>
					</div>
				</div>";
		}else{
			//start Over
			if(isset($_POST['stop_game'])||isset($_POST['again'])){
				echo "<div class=\"mainDiv\">
						<div id=\"welcome\" style=\"display:inline-block;\">
							<p class=\"wellcomeText\">Question Game</p>
							<p class=\"normalText\">You are going to be asked a general questions.</p>
							<form action=\"\" method=\"post\">

								<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"start_game\" value=\"Start\"/>
								<input name=\"first_question\" id=\"first_question\" type=\"hidden\" value=\"true\"/>
							</form>
						</div>
					</div>";
			}

			//print "hi re 1";
			if (isset($_POST['save'])){
					$user=$_POST['username'];
					$File=fopen("scorefile.txt","a");
					$userName=$user." ";
					$score=$_POST['score']."\n";
					if($File){
						fwrite($File,$userName);
						fwrite($File,$score);
						echo "<div class=\"mainDiv\">
								<div id=\"SavedScore\" style=\"text-align:center;\">
									<p class=\"wellcomeText\">Score saved successfully!</p>
								</div>
							</div>";
						echo "<meta http-equiv=\"refresh\" content=\"0.6\">";
					}else{
						echo "Something went wrong";
					}
					fclose($File);
			}

			//if you press Start or Select
			if (isset($_POST['start_game']) || isset($_POST['check_answer'])){
				//set a session as a username

				//if is the first question
				if ($_POST['first_question'] == 'true'){
					for ($i = 1 ; $i < 6; $i++){
						$GLOBALS['isAnswerCorrect'.$i]="";
					}
					$_POST['first_question']=='false';
					$GLOBALS['score'] = 0;
					$GLOBALS['typeOfQuestion']=2;
					generateQuestionAndAnswers($GLOBALS['MediumQuestions']);
					$GLOBALS['questionNumber']=$_POST['questionNumber']+1;
					$GLOBALS['selectButtonValue']="Select";
					//start Over
					if(isset($_POST['stop_game'])||isset($_POST['again'])){
						echo "<div class=\"mainDiv\">
								<div id=\"welcome\" style=\"display:inline-block;\">
									<p class=\"wellcomeText\">Question Game</p>
									<p class=\"normalText\">You are going to be asked a general questions.</p>
									<form action=\"\" method=\"post\">

										<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"start_game\" value=\"Start\"/>
										<input name=\"first_question\" id=\"first_question\" type=\"hidden\" value=\"true\"/>
									</form>
								</div>
							</div>";
					}
					//when you press select and user answer
					if(isset($_POST['check_answer']) && isset($_POST['user_answer'])){
						//if the answer is correct
						if($_POST['user_answer']==$_POST['correctAnswer']){
							if($_POST['questionNumber']==0){
								$GLOBALS['isAnswerCorrect1']="true";
							}elseif($_POST['questionNumber']==1){
								$GLOBALS['isAnswerCorrect2']="true";
							}elseif($_POST['questionNumber']==2){
								$GLOBALS['isAnswerCorrect3']="true";
							}elseif($_POST['questionNumber']==3){
								$GLOBALS['isAnswerCorrect4']="true";
							}elseif($_POST['questionNumber']==4){
								$GLOBALS['isAnswerCorrect5']="true";
							}
							if($_POST['typeOfQuestion']==1){
								$GLOBALS['score']=$_POST['score']+1;
								$_POST['typeOfQuestion']=2;
							}elseif($_POST['typeOfQuestion']==2){
								$GLOBALS['score']=$_POST['score']+2;
								$_POST['typeOfQuestion']=3;
							}elseif($_POST['typeOfQuestion']==3){
								$GLOBALS['score']=$_POST['score']+3;
								$_POST['typeOfQuestion']=3;
							}
						//if the answer is wrong 
						}else{
							if($_POST['questionNumber']==0){
								$GLOBALS['isAnswerCorrect1']="false";
							}elseif($_POST['questionNumber']==1){
								$GLOBALS['isAnswerCorrect2']="false";
							}elseif($_POST['questionNumber']==2){
								$GLOBALS['isAnswerCorrect3']="false";
							}elseif($_POST['questionNumber']==3){
								$GLOBALS['isAnswerCorrect4']="false";
							}elseif($_POST['questionNumber']==4){
								$GLOBALS['isAnswerCorrect5']="false";
							}
							if($_POST['typeOfQuestion']==1){
								$_POST['typeOfQuestion']=1;
							}elseif($_POST['typeOfQuestion']==2){
								$_POST['typeOfQuestion']=1;
							}elseif($_POST['typeOfQuestion']==3){
								$_POST['typeOfQuestion']=2;
							}
						}
						$GLOBALS['typeOfQuestion'] = $_POST['typeOfQuestion'];
						$GLOBALS['questionNumber']=$_POST['questionNumber']+1;
						$GLOBALS['isAnswerCorrect1']=$_POST['isAnswerCorrect1'];
						$GLOBALS['isAnswerCorrect2']=$_POST['isAnswerCorrect2'];
						$GLOBALS['isAnswerCorrect3']=$_POST['isAnswerCorrect3'];
						$GLOBALS['isAnswerCorrect4']=$_POST['isAnswerCorrect4'];
						$GLOBALS['isAnswerCorrect5']=$_POST['isAnswerCorrect5'];
					}
					
					//print the layout
					echo "
					<div class=\"normalDiv\">
					<div id=\"game\" style=\"display:inline-block\">
					<p id=\"questions\" class=\"wellcomeText\">".$GLOBALS['question']."</p>
					
					<form action=\"\" method=\"post\">
					<div>
					<input type=\"radio\" id=\"a0\" value=\"".$GLOBALS['answer1']."\" name=\"user_answer\" />
					<label id=\"questions\" for=\"a0\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer1']."</label>
					<input type=\"radio\" id=\"a1\" value=\"".$GLOBALS['answer2']."\" name=\"user_answer\" />
					<label id=\"questions\" for=\"a1\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer2']."</label>
					<input type=\"radio\" id=\"a2\" value=\"".$GLOBALS['answer3']."\" name=\"user_answer\" />
					<label id=\"questions\" for=\"a2\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer3']."</label>
					<input type=\"radio\" id=\"a3\" value=\"".$GLOBALS['answer4']."\" name=\"user_answer\" />
					<label id=\"questions\" for=\"a3\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer4']."</label>
					</div>
					<br>
					<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"check_answer\" value=\"".$GLOBALS['selectButtonValue']."\"/>
					<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"stop_game\" value=\"Stop Game\"/>
					<br>
					<p class=\"normalText\">".$GLOBALS['questionNumber']."/5</p>
					
					<input type=\"hidden\" name=\"questionNumber\" value=\"". $GLOBALS['questionNumber']."\"/>
					<input type=\"hidden\" name=\"typeOfQuestion\" value=\"". $GLOBALS['typeOfQuestion']."\"/>
					<input type=\"hidden\" name=\"correctAnswer\" value=\"". $GLOBALS['correctAnswer']."\" />
					<input type=\"hidden\" name=\"isAnswerCorrect1\" value=\"". $GLOBALS['isAnswerCorrect1']."\" />
					<input type=\"hidden\" name=\"isAnswerCorrect2\" value=\"". $GLOBALS['isAnswerCorrect2']."\" />
					<input type=\"hidden\" name=\"isAnswerCorrect3\" value=\"". $GLOBALS['isAnswerCorrect3']."\" />
					<input type=\"hidden\" name=\"isAnswerCorrect4\" value=\"". $GLOBALS['isAnswerCorrect4']."\" />
					<input type=\"hidden\" name=\"isAnswerCorrect5\" value=\"". $GLOBALS['isAnswerCorrect5']."\" />
					<input type=\"hidden\" name=\"score\" value=\"".$GLOBALS['score']."\"/>
					</form>
					</div>
					</div>";
				}else{
					for ($i = 1 ; $i < 6; $i++){
						$GLOBALS['isAnswerCorrect'.$i]=$_POST['isAnswerCorrect'.$i];
					}
					$GLOBALS['typeOfQuestion'] = $_POST['typeOfQuestion'];
					$GLOBALS['score'] = $_POST['score'];
					//if the question is 
					if($_POST['questionNumber']<5){
						//is it the last question
						if($_POST['questionNumber']==4){
							$GLOBALS['selectButtonValue']="Finish";
						//Not the last question
						}else{
							$GLOBALS['selectButtonValue']="Select";
						}
						if($_POST['typeOfQuestion']==2){
							generateQuestionAndAnswers($GLOBALS['MediumQuestions']);
						}elseif($_POST['typeOfQuestion']==1){
							generateQuestionAndAnswers($GLOBALS['EasyQuestions']);
						}elseif($_POST['typeOfQuestion']==3){
							generateQuestionAndAnswers($GLOBALS['HardQuestions']);
						}


						//start Over
						if(isset($_POST['stop_game'])||isset($_POST['again'])){
							echo "<div class=\"mainDiv\">
									<div id=\"welcome\" style=\"display:inline-block;\">
											<p class=\"wellcomeText\">Question Game</p>
											<p class=\"normalText\">You are going to be asked a general questions.</p>
											<form action=\"\" method=\"post\">

												<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"start_game\" value=\"Start\"/>
												<input name=\"first_question\" id=\"first_question\" type=\"hidden\" value=\"true\"/>
											</form>
									</div>
 								</div>";
						}
						//if you press select and the user answer
						if(isset($_POST['check_answer']) && isset($_POST['user_answer'])){
							//correct answer
							if($_POST['user_answer']==$_POST['correctAnswer']){
								$GLOBALS['isAnswerCorrect'.$_POST['questionNumber']]="true";
								if($_POST['typeOfQuestion']==1){
									$GLOBALS['score']=$_POST['score']+1;
									$_POST['typeOfQuestion']=2;
								}elseif($_POST['typeOfQuestion']==2){
									$GLOBALS['score']=$_POST['score']+2;
									$_POST['typeOfQuestion']=3;
								}elseif($_POST['typeOfQuestion']==3){
									$GLOBALS['score']=$_POST['score']+3;
									$_POST['typeOfQuestion']=3;
								}
							//incorrect answer
							}else{
								$GLOBALS['isAnswerCorrect'.$_POST['questionNumber']]="false";
								if($_POST['typeOfQuestion']==1){
									$_POST['typeOfQuestion']=1;
								}elseif($_POST['typeOfQuestion']==2){
									$_POST['typeOfQuestion']=1;
								}elseif($_POST['typeOfQuestion']==3){
									$_POST['typeOfQuestion']=2;
								}
							}
							$GLOBALS['typeOfQuestion'] = $_POST['typeOfQuestion'];
							$GLOBALS['questionNumber']=$_POST['questionNumber']+1;
						}

						//print the layout
						echo "
						<div class=\"normalDiv\">
						<div id=\"game\" style=\"display:inline-block;\">
						<p id=\"questions\" class=\"wellcomeText\">".$GLOBALS['question']."</p>
						
						<form action=\"\" method=\"post\">
						<div>
						<input type=\"radio\" id=\"a0\" value=\"".$GLOBALS['answer1']."\" name=\"user_answer\" />
						<label id=\"questions\" for=\"a0\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer1']."</label>
						<input type=\"radio\" id=\"a1\" value=\"".$GLOBALS['answer2']."\" name=\"user_answer\" />
						<label id=\"questions\" for=\"a1\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer2']."</label>
						<input type=\"radio\" id=\"a2\" value=\"".$GLOBALS['answer3']."\" name=\"user_answer\" />
						<label id=\"questions\" for=\"a2\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer3']."</label>
						<input type=\"radio\" id=\"a3\" value=\"".$GLOBALS['answer4']."\" name=\"user_answer\" />
						<label id=\"questions\" for=\"a3\"  class=\"normalText\" style=\"display:inline-block;margin-right:4%\">".$GLOBALS['answer4']."</label>
						</div>
						<br>
						<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"check_answer\" value=\"".$GLOBALS['selectButtonValue']."\"/>
						<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"stop_game\" value=\"Stop Game\"/>
						<br>
						<p class=\"normalText\">".$GLOBALS['questionNumber']."/5</p>
						
						<input type=\"hidden\" name=\"questionNumber\" value=\"". $GLOBALS['questionNumber']."\"/>
						<input type=\"hidden\" name=\"typeOfQuestion\" value=\"". $GLOBALS['typeOfQuestion']."\"/>
						<input type=\"hidden\" name=\"correctAnswer\" value=\"". $GLOBALS['correctAnswer']."\" />
						<input type=\"hidden\" name=\"isAnswerCorrect1\" value=\"". $GLOBALS['isAnswerCorrect1']."\" />
						<input type=\"hidden\" name=\"isAnswerCorrect2\" value=\"". $GLOBALS['isAnswerCorrect2']."\" />
						<input type=\"hidden\" name=\"isAnswerCorrect3\" value=\"". $GLOBALS['isAnswerCorrect3']."\" />
						<input type=\"hidden\" name=\"isAnswerCorrect4\" value=\"". $GLOBALS['isAnswerCorrect4']."\" />
						<input type=\"hidden\" name=\"isAnswerCorrect5\" value=\"". $GLOBALS['isAnswerCorrect5']."\" />
						<input type=\"hidden\" name=\"score\" value=\"".$GLOBALS['score']."\"/>
						</form>
						</div>
						</div>";
					}else{
						//start Over
						if(isset($_POST['stop_game'])||isset($_POST['again'])){
							echo "<div class=\"mainDiv\">
									<div id=\"welcome\" style=\"display:inline-block;\">
										<p class=\"wellcomeText\">Question Game</p>
										<p class=\"normalText\">You are going to be asked a general questions.</p>
										<form action=\"\" method=\"post\">

											<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"start_game\" value=\"Start\"/>
											<input name=\"first_question\" id=\"first_question\" type=\"hidden\" value=\"true\"/>
										</form>
									</div>
								</div>";
						}
						//check the last question
						if(isset($_POST['check_answer']) && isset($_POST['user_answer'])){
							//correct answer
							if($_POST['user_answer']==$_POST['correctAnswer']){
								$GLOBALS['isAnswerCorrect'.$_POST['questionNumber']]="true";
								if($_POST['typeOfQuestion']==1){
									$GLOBALS['score']=$_POST['score']+1;
									$_POST['typeOfQuestion']=2;
								}elseif($_POST['typeOfQuestion']==2){
									$GLOBALS['score']=$_POST['score']+2;
									$_POST['typeOfQuestion']=3;
								}elseif($_POST['typeOfQuestion']==3){
									$GLOBALS['score']=$_POST['score']+3;
									$_POST['typeOfQuestion']=3;
								}
							//incorect answer
							}else{
								$GLOBALS['isAnswerCorrect'.$_POST['questionNumber']]="false";
								if($_POST['typeOfQuestion']==1){
									$_POST['typeOfQuestion']=1;
								}elseif($_POST['typeOfQuestion']==2){
									$_POST['typeOfQuestion']=1;
								}elseif($_POST['typeOfQuestion']==3){
									$_POST['typeOfQuestion']=2;
								}
							}
							$GLOBALS['typeOfQuestion'] = $_POST['typeOfQuestion'];
							$GLOBALS['questionNumber']=$_POST['questionNumber']+1;
						}

						//print it when you press finish 
						echo "
						<div class=\"normalDiv\">
							<div style=\"display:inline-block;\">
								<div id=\"welcome\" style=\"display:inline-block;\">
									<p class=\"wellcomeText\">Question Game</p>
									<p class=\"normalText\">Question 1: ". $GLOBALS['isAnswerCorrect1']."</p>
									<p class=\"normalText\">Question 2: ". $GLOBALS['isAnswerCorrect2']."</p>
									<p class=\"normalText\">Question 3: ". $GLOBALS['isAnswerCorrect3']."</p>
									<p class=\"normalText\">Question 4: ". $GLOBALS['isAnswerCorrect4']."</p>
									<p class=\"normalText\">Question 5: ". $GLOBALS['isAnswerCorrect5']."</p>
									<p class=\"normalText\">Your score is:". $GLOBALS['score']."</p>
									<p class=\"normalText\">Do you want to save you score?</p>
									<form action=\"index.php\" method=\"post\">
										<input type=\"submit\" class=\"btn start_button btn-secondary\" name=\"save\" value=\"Save Score\"/>
										<input type=\"submit\" class=\"btn start_button btn-secondary\" style=\"width:30%;\" name=\"again\" value=\"Try Again\"/>
										<br>
										<input type=\"text\" name=\"username\" class=\"textBox-Style\" placeholder=\"Give Username\"/>
										<input type=\"hidden\" name=\"score\" value=\"".$GLOBALS['score']."\"/>
									</form>
								</div>
							</div>
						</div>";
					}
				}	
			}
		}
	?>
		
</body>
</html>