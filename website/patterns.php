<?php
	if($_GET['p'] == 'early_life'){
		$ch_num = 1;
		$ch_name = 'Early Life';
	} else if($_GET['p'] == 'still_lifes'){
		$ch_num = 2;
		$ch_name = 'Still Lifes';
	} else if($_GET['p'] == 'oscillators'){
		$ch_num = 3;
		$ch_name = 'Oscillators';
	} else if($_GET['p'] == 'spaceships'){
		$ch_num = 4;
		$ch_name = 'Spaceships and Moving Objects';
	} else if($_GET['p'] == 'glider_synthesis'){
		$ch_num = 5;
		$ch_name = 'Glider Synthesis';
	} else if($_GET['p'] == 'periodic_circuitry'){
		$ch_num = 6;
		$ch_name = 'Periodic Circuitry';
	} else if($_GET['p'] == 'stationary_circuitry'){
		$ch_num = 7;
		$ch_name = 'Stable Circuitry';
	} else if($_GET['p'] == 'glider_guns'){
		$ch_num = 8;
		$ch_name = 'Guns and Glider Streams';
	} else if($_GET['p'] == 'universal_computation'){
		$ch_num = 9;
		$ch_name = 'Universal Computation';
	} else {
		header('Location: http://www.conwaylife.com/book/');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Conway's Game of Life: Mathematics and Construction</title>
  <meta name="description" content="A textbook for mathematical aspects of Conway's Game of Life and methods of pattern construction.">
  <meta name="author" content="Nathaniel Johnston and Dave Greene">
<meta name="LifeViewer" content="rle code 37 hide limit">
  <script type="text/javascript" src="js/lv-plugin.js"></script>
  <script type="text/javascript" src="js/selectCode.js"></script>

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/custom.css">

  <!-- Scripts
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
  <link rel="stylesheet" href="css/github-prettify-theme.css">
  <script src="js/site.js"></script>

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<link rel="shortcut icon" type="image/png" href="/favicon.png"/>
<link rel="shortcut icon" type="image/png" href="http://www.conwaylife.com/book/favicon.png"/>

<style>
.anchor{
  display: block;
  height: 60px; /*same height as header*/
  margin-top: -60px; /*same height as header*/
  visibility: hidden;
}
.rlecode {
  background: #fff;
  font-family: Menlo, 'Bitstream Vera Sans Mono', 'DejaVu Sans Mono', Monaco, Consolas, monospace;
  font-size: 1.2rem;
  padding: 1rem 1.2rem;
  -webkit-font-smoothing: antialiased;
  display:block;
  margin-bottom:2rem;
}
</style>

</head>
<body class="code-snippets-visible">

    <div class="container">
      <div class="row" style="padding-top:4rem;padding-bottom:1rem;">
        <div style="float:right;width:158px;margin-left:10px;max-width:30%;">
          <img src="images/logo.png" style="width:158px;height:157px;" class="bookimg">
        </div>
        <div style="overflow: hidden;">
          <h1 style="font-weight:bold;margin-bottom:0px;">Conway's Game of Life</h1>
          <h3 style="margin-top:0px;">Mathematics and Construction</h3>
          <a class="button button-primary" href="index.html#download_pdf">Download the Book</a>
        </div>
      </div>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

    <div class="navbar-spacer"></div>
    <nav class="navbar">
      <div class="container">
        <ul class="navbar-list">
          <li class="navbar-item">&nbsp;<a class="navbar-link" href="index.html">Back to Book Homepage</a></li>
        </ul>
      </div>
    </nav>


<span class="anchor" id="rle_files"></span>
    <div class="docs-section">
      <h6 class="docs-header">Pattern Files for Chapter <?php echo $ch_num; ?>: <?php echo $ch_name; ?></h6>
      <p>RLE, Macrocell, or LifeHistory code for all patterns that are displayed as figures in Chapter <?php echo $ch_num; ?>: <?php echo $ch_name; ?> are provided here. These patterns can be viewed in-browser by clicking on the "Show in Viewer" link near the code, or the patterns can be viewed and manipulated by copying and pasting the RLE code into Game of Life software like <a href="http://golly.sourceforge.net/">Golly</a>.</p>
      <p>Note that these RLE codes are <em>not</em> listed in the same order as the figures in the book; you may find it helpful to use your browser's search-in-page function to find the RLE code that you want.</p>

<?php
	foreach(scandir('patterns/' . $_GET['p'] . '/') as $file) {
		$file_ext_test = substr($file, -4);
		$file_main_name = substr($file, 0, -4);
		if($file_ext_test == ".txt") {
			if(file_exists('patterns/' . $_GET['p'] . '/' . $file_main_name . '.lh')) {
				$code_type = 'LifeHistory';
				$file_ext = '.lh';
			} else {
				$code_type = 'RLE';
				$file_ext = '.txt';
			}

			$file_contents = file_get_contents('patterns/' . $_GET['p'] . '/' . $file_main_name . $file_ext);

			$name_pos = strpos($file_contents, '#N ');
			if($name_pos === FALSE) {
				$pattern_name = str_replace('_', ' ', $file_main_name);
			} else {
				$line_end = strpos($file_contents, PHP_EOL, $name_pos+1);
				$pattern_name = trim(substr($file_contents, $name_pos+3, $line_end-$name_pos-3));
				$file_contents = trim(substr($file_contents, $line_end));
			}

			$comments = '';
			if(substr($file_contents, 0, 4) == '[M2]') {
				$end_comments = '<b>Download link:</b> <a href="patterns/' . $_GET['p'] . '/' . $file_main_name . '.txt">here</a> (file too large to display in-browser)';
				$num_comments = 1;
			} else {
				$end_comments = '';
				$num_comments = 0;
			}

			$comment_pos = strpos($file_contents, '#C ');
			while($comment_pos !== FALSE) {
				$line_end = strpos($file_contents, PHP_EOL, $comment_pos+1);
				if(substr($file_contents, $comment_pos, 5) == '#C [[') {
					$comment_pos = FALSE;
				} else if(substr($file_contents, $comment_pos, 7) == '#C http' || substr($file_contents, $comment_pos, 7) == '#C www.') {
					$link_url = trim(substr($file_contents, $comment_pos+3, $line_end-$comment_pos-3));
					if(substr($link_url, 0, 4) != 'http') {
						$link_url = 'https://' . $link_url;
					}
					$link_url = str_replace('http://', 'https://', $link_url);

					$comments = $comments . '<br /><b>More info:</b> <a href="' . $link_url . '">' . $link_url . '</a>' . PHP_EOL;
					$file_contents = trim(substr($file_contents, $line_end));
					$comment_pos = strpos($file_contents, '#C ');
					$num_comments = $num_comments + 1;
				} else {
					$comments = $comments . trim(substr($file_contents, $comment_pos+3, $line_end-$comment_pos-3)) . PHP_EOL;
					$file_contents = trim(substr($file_contents, $line_end));
					$comment_pos = strpos($file_contents, '#C ');
					$num_comments = $num_comments + 1;
				}
			}

			if($num_comments > 0) {
				$comments = '<p style="margin-bottom:6px;">' . $comments . '</p>';
			}

			$file_contents = $file_contents . PHP_EOL . '#C [[ GRID GRIDMAJOR 0 COLOR GRID 192 192 192 COLOR DEADRAMP 255 220 192 COLOR ALIVE 0 0 0 COLOR DEAD 192 220 255 COLOR BACKGROUND 255 255 255 ]]';

			echo '<a name="' . $file_main_name . '"></a><h6 class="docs-header" style="margin-top:30px;margin-bottom:6px;">' . $pattern_name . '</h6>' . $comments . $end_comments;
			if(strlen($end_comments) == 0) {
				echo '<div class="codebox"><div class="selall"><b>' . $code_type . ' code:</b> <a href="#" onclick="selectCode(this); return false;">Select all</a></div><div><code class="code-example-body rlecode" style="max-height:100px;overflow-y:scroll;overflow-x:hidden;">' . $file_contents . '</code></div></div>';
			}
		}
	}
?>
    </div>


  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>