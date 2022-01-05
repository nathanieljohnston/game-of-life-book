<?php
	function show_pattern_file($file, $file_prefix = '') {
		$file_ext_test = substr($file, -3);
		$file_main_name = substr($file, 0, -4);
		if($file_ext_test == "txt" || $file_ext_test == ".mc") {
			if(file_exists('patterns/' . $_GET['p'] . '/' . $file_main_name . '.lh')) {
				$code_type = 'LifeHistory';
				$file_ext = '.lh';
			} else if($file_ext_test == '.mc') {
				$code_type = ' MacroCell';
				$file_ext = '.mc';
				$file_main_name = substr($file, 0, -3);
			} else {
				$code_type = 'RLE';
				$file_ext = '.txt';
			}

			$file_size = filesize('patterns/' . $_GET['p'] . '/' . $file_main_name . $file_ext);
			$dl_link_large = ($file_size > 300000);

			if(!$dl_link_large) {
				$file_contents = file_get_contents('patterns/' . $_GET['p'] . '/' . $file_main_name . $file_ext);
				$name_pos = strpos($file_contents, '#N ');
			} else {
				$name_pos = FALSE;
			}

			if($name_pos === FALSE) {
				$pattern_name = str_replace('_', ' ', str_replace('solution_', '', str_replace('exercise_', '', str_replace('_exercise', '', $file_main_name))));
			} else {
				$line_end = strpos($file_contents, PHP_EOL, $name_pos+1);
				$pattern_name = trim(substr($file_contents, $name_pos+3, $line_end-$name_pos-3));
				$file_contents = trim(substr($file_contents, $line_end));
			}

			$comments = '';
			if($dl_link_large || substr($file_contents, 0, 4) == '[M2]') {
				$end_comments = '<b>Download link:</b> <a href="patterns/' . $_GET['p'] . '/' . $file_main_name . $file_ext . '">here</a> (file too large to display in-browser)';
				$num_comments = 1;
			} else {
				$end_comments = '';
				$num_comments = 0;
			}

			if(!$dl_link_large) {
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
			}

			if($num_comments > 0) {
				$comments = '<p style="margin-bottom:6px;">' . $comments . '</p>';
			}

			$file_contents = $file_contents . PHP_EOL . '#C [[ GRID THEME BOOK ]]';

			echo '<a name="' . $file_main_name . '"></a><h6 class="docs-header" style="margin-top:30px;margin-bottom:6px;">' . $file_prefix . $pattern_name . '</h6>' . $comments . $end_comments;
			if(strlen($end_comments) == 0) {
				echo '<div class="codebox"><div class="selall"><b>' . $code_type . ' code:</b> <a href="#" onclick="selectCode(this); return false;">Select all</a></div><div><code class="code-example-body rlecode" style="max-height:100px;overflow-y:scroll;overflow-x:hidden;">' . $file_contents . '</code></div></div>';
			}
		}
	}


	if($_GET['p'] == 'early_life'){
		$ch_num = 1;
		$ch_name = 'Early Life';

		$fig_nums = array(
			'Figure 1.2' => 'first_example.txt',
			'Figure 1.4' => 'random_1.txt',
			'Figure 1.5' => 'random_2.txt',
			'Figure 1.6' => 'first_objects.txt',
			'Figure 1.7' => 'pulsar.txt',
			'Figure 1.8' => 'random_oscillators.txt',
			'Figure 1.9' => 'lwss.txt',
			'Figure 1.10' => 'lwss_mwss_hwss.txt',
			'Figure 1.11' => 't_tetromino.txt',
			'Figure 1.12' => 'pre_honey_farm.txt',
			'Figure 1.13' => 'stairstep_hexomino.txt',
			'Figure 1.14' => 'pi_heptomino.txt',
			'Figure 1.15' => 'queen_bee.txt',
			'Figure 1.16' => 'beehive_block.txt',
			'Figure 1.17' => 'queen_bee_shuttle.txt',
			'Figure 1.18' => 'gosper_glider_gun.txt',
			'Figure 1.19' => 'b_heptomino.txt',
			'Figure 1.20' => 'twin_bees.txt',
			'Figure 1.21' => 'twin_bees_debris_eat.txt',
			'Figure 1.22' => 'twin_bees_shuttle.txt',
			'Figure 1.23' => 'twin_bees_gun.txt',
			'Figure 1.24' => 'switch_engine.txt',
			'Figure 1.25' => 'switch_engine_block.txt',
			'Figure 1.26' => 'switch_engine_glider.txt',
			'Figure 1.27' => 'ark_1.txt',
			'Figure 1.28' => 'r_pentomino.txt',
			'Table 1.1(5)' => '5_cell_methuselahs.txt',
			'Table 1.1(6)' => '6_cell_methuselahs.txt',
			'Table 1.1(7)' => 'acorn.txt',
			'Table 1.1(8)' => '7468M.txt',
			'Table 1.1(9)' => 'bunnies.txt',
			'Table 1.1(10)' => 'bunnies_10b.txt',
			'Table 1.1(11)' => '23334M.txt',
			'Table 1.1(12)' => 'methuselah_12.txt',
			'Table 1.1(13)' => 'lidka.txt',
			'Figure 1.29' => '52514M.txt',
			'Figure 1.30' => 'ark_736692.txt',
			'Figure 1.32' => 'block_parents.txt',
			'Figure 1.34' => 'goe_theorem_tiles_example.txt',
			'Figure 1.35' => 'goe_1.txt',
			'Figure 1.36(a)' => 'goe_record_alive.txt',
			'Figure 1.36(b)' => 'goe_record_orphan.txt',
			'Figure 1.36(c)' => 'goe_record_bb.txt',
			'Figure 1.37' => '1_row_border.txt',
			'Figure 1.40' => '1_row_eg.txt',
			'Figure 1.41' => 'goe_height_5.txt',
			'Figure 1.42' => 'grandparentless.txt',
			'Figure 1.43' => 'grandparentless_parent.txt',
			'Figure 1.46(a)' => 'nonomino.txt',
			'Figure 1.46(b)' => 'switch_engine.txt',
			'Exercise 1.1(a)' => 'exercise_random_1.txt',
			'Exercise 1.1(b)' => 'exercise_random_2.txt',
			'Exercise 1.1(c)' => 'exercise_random_3.txt',
			'Exercise 1.1(d)' => 'exercise_random_4.txt',
			'Exercise 1.3' => 'exercise_pentominoes.txt',
			'Exercise 1.4' => 'hat.txt',
			'Exercise 1.7(a)' => 'exercise_random_sym_1.txt',
			'Exercise 1.7(b)' => 'exercise_random_sym_2.txt',
			'Exercise 1.7(c)' => 'exercise_random_sym_3.txt',
			'Exercise 1.7(d)' => 'exercise_random_sym_4.txt',
			'Exercise 1.8(1)' => 'exercise_fleet.txt',
			'Exercise 1.8(2)' => 'exercise_bakery.txt',
			'Exercise 1.9' => 'beehive_pair.txt',
			'Exercise 1.10' => 'beehive_eater_1.txt',
			'Exercise 1.11' => 'exercise_bunnies.txt',
			'Exercise 1.12' => 'edna.txt',
			'Exercise 1.13' => 'exercise_8cell_meth.txt',
			'Exercise 1.14' => 'exercise_noahs_ark.txt',
			'Exercise 1.15' => 'goe_height_1_exercise.txt',
			'Exercise 1.17' => 'exercise_ark.txt',
			'Exercise 1.19' => 'exercise_goe_jls.txt',
			'Solution 1.8(a)' => 'solution_fleet.txt',
			'Solution 1.8(b)' => 'solution_bakery.txt',
			'Solution 1.9(b)' => '1_beehive_shuttle.txt',
		);
	} else if($_GET['p'] == 'still_lifes'){
		$ch_num = 2;
		$ch_name = 'Still Lifes';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'oscillators'){
		$ch_num = 3;
		$ch_name = 'Oscillators';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'spaceships'){
		$ch_num = 4;
		$ch_name = 'Spaceships and Moving Objects';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'glider_synthesis'){
		$ch_num = 5;
		$ch_name = 'Glider Synthesis';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'periodic_circuitry'){
		$ch_num = 6;
		$ch_name = 'Periodic Circuitry';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'stationary_circuitry'){
		$ch_num = 7;
		$ch_name = 'Stable Circuitry';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'glider_guns'){
		$ch_num = 8;
		$ch_name = 'Guns and Glider Streams';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'universal_computation'){
		$ch_num = 9;
		$ch_name = 'Universal Computation';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'self_support_spaceships'){
		$ch_num = 10;
		$ch_name = 'Self-Supporting Spaceships';

		$fig_nums = array(
		);
	} else if($_GET['p'] == 'universal_construction'){
		$ch_num = 11;
		$ch_name = 'Universal Construction';

		$fig_nums = array(
		);
	} else if($_GET['p'] == '0e0p'){
		$ch_num = 12;
		$ch_name = 'The 0E0P Metacell';

		$fig_nums = array(
		);
	} else {
		header('Location: https://www.conwaylife.com/book/');
	}

	if($ch_num <= 11) {
		$zip_size = filesize('patterns/' . $_GET['p'] . '/all.zip');
		$zip_size_readable = round($zip_size / 1048576, 2);
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
  <script type="text/javascript" src="https://conwaylife.com/book/js/lv-plugin.js"></script>
  <script type="text/javascript" src="https://conwaylife.com/book/js/selectCode.js"></script>

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="https://conwaylife.com/book/css/normalize.css">
  <link rel="stylesheet" href="https://conwaylife.com/book/css/skeleton.css">
  <link rel="stylesheet" href="https://conwaylife.com/book/css/custom.css">

  <!-- Scripts
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
  <link rel="stylesheet" href="css/github-prettify-theme.css">
  <script src="https://conwaylife.com/book/js/site.js"></script>

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<link rel="shortcut icon" type="image/png" href="https://conwaylife.com/book/favicon.png"/>

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
          <img src="https://conwaylife.com/book/images/logo.png" style="width:158px;height:157px;" class="bookimg">
        </div>
        <div style="overflow: hidden;">
          <h1 style="font-weight:bold;margin-bottom:0px;">Conway's Game of Life</h1>
          <h3 style="margin-top:0px;">Mathematics and Construction</h3>
          <a class="button button-primary" href="https://conwaylife.com/book/#download_pdf">Download the Book</a>
        </div>
      </div>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

    <div class="navbar-spacer"></div>
    <nav class="navbar">
      <div class="container">
        <ul class="navbar-list">
          <li class="navbar-item">&nbsp;<a class="navbar-link" href="https://conwaylife.com/book/">Back to Book Homepage</a></li>
        </ul>
      </div>
    </nav>


<span class="anchor" id="rle_files"></span>
    <div class="docs-section">
      <h6 class="docs-header">Pattern Files for Chapter <?php echo $ch_num; ?>: <?php echo $ch_name; ?></h6>
      <p>RLE, Macrocell, or LifeHistory code for all patterns that are displayed as figures in Chapter <?php echo $ch_num; ?>: <?php echo $ch_name; ?> are provided here. These patterns can be viewed in-browser by clicking on the "Show in Viewer" link near the code, or the patterns can be viewed and manipulated by copying and pasting the RLE code into Game of Life software like <a href="http://golly.sourceforge.net/">Golly</a>.</p>
      <?php
		if($ch_num <= 11) { ?>
			<center><b><a href="patterns/<?php echo $_GET['p']; ?>/all.zip">All pattern files from this chapter in a .zip archive file (<?php echo $zip_size_readable; ?> Mb)</a></b></center>
<?php
		}

		foreach($fig_nums as $fig_num => $file) {// show pattern files that have a figure number first
			show_pattern_file($file, $fig_num . ': ');
		}

		foreach(scandir('patterns/' . $_GET['p'] . '/') as $file) {
			if(array_search($file, $fig_nums) === FALSE) {// only display the file down here if we did not already display it along with its Figure number
				show_pattern_file($file);
			}
		}
?>
    </div>


  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>