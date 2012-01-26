<?php

define("XML_PATH", "xml");
define("TAKE_SURVEY_TITLE", "Choose a Survey");
define("TAKE_SURVEY_PAGE","take_survey.php");
define("TAKE_SURVEY_CLASS","");

function html_header($title = "Untitled", $styles = null, $scripts = null) {
	$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>$title</title>
END;
	$string .= "\n";
	if (is_array($styles)) {
		foreach ($styles as $style) {
			$string .= "<link type='text/css' rel='stylesheet' href='$style' />\n";
		}
	} else if (is_string($styles)) {
		$string .= "<link type='text/css' rel='stylesheet' href='$styles' />\n";
	}

	if (is_array($scripts)) {
		foreach ($scripts as $script) {
			$string .= "<script type='text/javascript' src='$script'></script>\n";
		}
	} else if (is_string($scripts)) {
		$string .= "<script type='text/javascript' src='$scripts'></script>\n";
	}

	$string .= <<<END
</head>
<body>\n
	<div id="page">\n
END;

	return $string;
}

function html_footer($text = "") {
	$string = <<<END
		<p><em>$text</em></p>
	</div> <!-- id=page -->
</body>
</html>
END;

	return $string;
}

function startDiv($id, $class=""){
	return "<div id='$id' class='$class'>"."\n";
}

function endDiv($id){
	return "</div> <!-- id='$id' -->"."\n";
}

// create the banner div
function addBanner() {
	// start div
	$string = "\t" . "\t" . '<div id="banner">' . "\n";

	$string .= "\t" . "\t" . '<h1>Banner</h1>' . "\n";

	// end div
	$string .= "\t" . "\t" . '</div> <!-- id=banner -->' . "\n";

	return $string;
}

function addNav() {
	$result = "\t".file_get_contents("nav.html");

	if (!$result) {
		$result = "";
	}
	
	return $result;
}

function addTakeSurveyLinks(){
	return addSurveyLinks(TAKE_SURVEY_TITLE, TAKE_SURVEY_PAGE, TAKE_SURVEY_CLASS);
}

function addSurveyLinks($title="Surveys", $page="", $class=""){
	if(!empty($class)){
		$class = " class='$class'";
	}
	
	if(!empty($page)){
		$page = " href='$page'";
	}
	
	// Setup the title
	$result = "<h2>$title</h2>";
	
	// grab all the available surveys
	$surveys = getSurveys();
	
	// setup the List
	$result = "<ul".$class.">"; 
	
	// print_r($surveys);
	
	// display each as a list item
	foreach($surveys as $survey){
		// echo "<br />".$survey."<br />";
		$result .= "<li><a".$page."&survey=$survey>$survey</a></li>";
		
		// echo htmlspecialchars($result)."\n"; 
	}
	
	// close the List
	$result .= "</ul>"; // <!-- $class -->";
	
	echo htmlspecialchars($result)."\n"; 
		
	// return
	return $result;
}

function getSurveys($dir = XML_PATH) {
	$result = array();

	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$result[] = $entry;
			}
		}
		closedir($handle);
	}

	return $result;
}
?>

<?php

?>