<!DOCTYPE html>
<html>

<head>
    <title>Saved Score</title>
	<link href="style.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" type="favicon.png" href="favicon.png"/>
                <meta charset=“utf-8”> 
                <meta name="description" content="Help">
                <meta name="keywords" content="trivia,questions">
                <meta name="author" content="Antrea Chrysanthou">
</head>
<body>
	<header>
        <div class="topnav" >
                <a href="index.php">Home Page</a>
                <a href="help.php">Help</a>
                <a class="active"href="score.php">Score</a>
              </div> 
</header>
        <?php 
        //at the right path
            $file="scorefile.txt";
            $f=fopen($file,"r") or exit("<div class=\"mainDiv\">
                                            <div id=\"SavedScore\" style=\"text-align:center;\">
                                                <p class=\"wellcomeText\">Unable to open file!</p>
                                            </div>
                                        </div>");
            echo "<div class=\"mainDiv\">
                    <div id=\"SavedScore\" style=\"text-align:center;\">
                        <p class=\"wellcomeText\">Saved Score</p>";

            while(!feof($f)){
                $t = fgets($f);
                echo    "<p class=\"normalText\">".$t."<br/></p>";
            }
            echo    "</div>
                </div>";
            fclose($f);
        ?>
</body>
</html>