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
			'Figure 2.1' => 'small_still_lifes.txt',
			'Figure 2.2' => 'strict_non_strict.txt',
			'Figure 2.3' => 'pseudo_not_pseudo.txt',
			'Table 2.1' => 'small_still_lifes_table.txt',
			'Figure 2.4(a)' => 'triple_pseudo_still_life.txt',
			'Figure 2.4(b)' => 'quad_pseudo_still_life.txt',
			'Figure 2.5' => 'messy_pseudo_still_life.txt',
			'Figure 2.6' => 'tub_boat_ship.txt',
			'Figure 2.7' => 'snake_canoe.txt',
			'Figure 2.9' => 'hook_tail_examples.txt',
			'Figure 2.11' => 'still_life_path.txt',
			'Figure 2.12' => '5_cell_induction.txt',
			'Figure 2.13' => 'induction_coil_examples.txt',
			'Figure 2.14' => 'eater_1_glider.txt',
			'Figure 2.15' => 'eater_1_multi.txt',
			'Figure 2.16(a)' => 'eater_2.txt',
			'Figure 2.16(b)' => 'eater_5.txt',
			'Figure 2.17' => 'boat_bit.txt',
			'Figure 2.18' => 'glider_loaf_flip.txt',
			'Figure 2.19' => 'eater_3.txt',
			'Figure 2.20' => 'glider_block_move.txt',
			'Figure 2.21' => 'unstable_eater_1s.txt',
			'Figure 2.22' => 'welded_eater_1s.txt',
			'Figure 2.24(a)' => 'eater_constrained_eater_5_b.txt',
			'Figure 2.24(b)' => 'eater_constrained_done.txt',
			'Figure 2.25(a)' => 'zebra_stripes.txt',
			'Figure 2.25(b)' => 'chicken_wire.txt',
			'Figure 2.25(c)' => 'onion_rings.txt',
			'Table 2.2(2)' => 'densest_block.txt',
			'Table 2.2(3)' => 'densest_ship.txt',
			'Table 2.2(4)' => 'densest_pond.txt',
			'Table 2.2(5)' => 'densest_four_blocks.txt',
			'Table 2.2(6)' => 'densest_6.txt',
			'Table 2.2(7)' => 'densest_7.txt',
			'Table 2.2(8)' => 'densest_8.txt',
			'Table 2.2(9)' => 'densest_9.txt',
			'Table 2.2(10)' => 'densest_10.txt',
			'Figure 2.30' => 'dense_oscillator.txt',
			'Figure 2.33' => 'two_tables_on_block.txt',
			'Figure 2.34' => 'sl_hard_to_find.txt',
			'Exercise 2.1(a)' => 'exercise_strict_pseudo_1.txt',
			'Exercise 2.1(b)' => 'exercise_strict_pseudo_4.txt',
			'Exercise 2.1(c)' => 'exercise_strict_pseudo_2.txt',
			'Exercise 2.1(d)' => 'exercise_strict_pseudo_5.txt',
			'Exercise 2.1(e)' => 'exercise_strict_pseudo_3.txt',
			'Exercise 2.1(f)' => 'exercise_strict_pseudo_6.txt',
			'Exercise 2.3(a)' => 'exercise_pseudo_1.txt',
			'Exercise 2.3(b)' => 'exercise_pseudo_4.txt',
			'Exercise 2.3(c)' => 'exercise_pseudo_2.txt',
			'Exercise 2.3(d)' => 'exercise_pseudo_5.txt',
			'Exercise 2.3(e)' => 'exercise_pseudo_3.txt',
			'Exercise 2.3(f)' => 'exercise_pseudo_6.txt',
			'Exercise 2.4(a)' => 'exercise_path_1.txt',
			'Exercise 2.4(b)' => 'exercise_path_3.txt',
			'Exercise 2.4(c)' => 'exercise_path_2.txt',
			'Exercise 2.7(a)' => 'exercise_induction_coil_1.txt',
			'Exercise 2.7(b)' => 'exercise_induction_coil_3.txt',
			'Exercise 2.7(c)' => 'exercise_induction_coil_2.txt',
			'Exercise 2.9(a)' => 'exercise_weld_1.txt',
			'Exercise 2.9(b)' => 'exercise_weld_2.txt',
			'Exercise 2.9(c)' => 'exercise_weld_5.txt',
			'Exercise 2.9(d)' => 'exercise_weld_3.txt',
			'Exercise 2.9(e)' => 'exercise_weld_4.txt',
			'Exercise 2.9(f)' => 'exercise_weld_6.txt',
			'Exercise 2.12' => 'exercise_still_life_impossible.txt',
			'Exercise 2.13(a)' => 'fast_glider_eater.txt',
			'Exercise 2.13(b)' => 'fast_glider_eater_b.txt',
			'Solution 2.4(a)' => 'solution_path_1.txt',
			'Solution 2.4(b)' => 'solution_path_3.txt',
			'Solution 2.4(c)' => 'solution_path_2.txt',
			'Solution 2.7(a)' => 'solution_induction_coil_1.txt',
			'Solution 2.7(b)' => 'solution_induction_coil_3.txt',
			'Solution 2.7(c)' => 'solution_induction_coil_2.txt',
			'Solution 2.9(a)' => 'solution_weld_1.txt',
			'Solution 2.9(b)' => 'solution_weld_2.txt',
			'Solution 2.9(c)' => 'solution_weld_5.txt',
			'Solution 2.9(d)' => 'solution_weld_3.txt',
			'Solution 2.9(e)' => 'solution_weld_4.txt',
			'Solution 2.9(f)' => 'solution_weld_6.txt',
			'Solution 2.13(a)' => 'solution_fast_glider_eater.txt',
			'Solution 2.13(b)' => 'solution_fast_glider_eater_b.txt',
			'Solution 2.15' => 'solution_incomplete_glider_eater.txt',
		);
	} else if($_GET['p'] == 'oscillators'){
		$ch_num = 3;
		$ch_name = 'Oscillators';

		$fig_nums = array(
			'Figure 3.1(a)' => 'bipole.txt',
			'Figure 3.1(b)' => 'jam.txt',
			'Figure 3.1(c)' => 'mold.txt',
			'Figure 3.1(d)' => 'octagon_2.txt',
			'Figure 3.2' => 'billiard_table_start.txt',
			'Figure 3.3(a)' => 'hertz_oscillator.txt',
			'Figure 3.3(b)' => 'negentropy.txt',
			'Figure 3.4(a)' => 'burloaferimeter.txt',
			'Figure 3.4(b)' => 'cauldron.txt',
			'Figure 3.4(c)' => 'p10_billiard_table.txt',
			'Figure 3.5' => 'two_eaters.txt',
			'Figure 3.6' => 'snacker.txt',
			'Figure 3.7(a)' => 'confused_eaters.txt',
			'Figure 3.7(b)' => 'roteightor.txt',
			'Figure 3.7(c)' => 'period_22.txt',
			'Figure 3.7(d)' => 'pentoad.txt',
			'Figure 3.7(e)' => 'dinner_table.txt',
			'Figure 3.7(f)' => 'worker_bee.txt',
			'Figure 3.7(g)' => 'honey_thieves.txt',
			'Figure 3.7(h)' => 'period_52.txt',
			'Figure 3.7(i)' => 'period_36.txt',
			'Figure 3.8(a)' => 'eater_2_p6.txt',
			'Figure 3.8(b)' => 'eater_2_p12.txt',
			'Figure 3.8(c)' => 'eater_2_p13.txt',
			'Figure 3.10' => 'pentadecathlon_on_snacker.txt',
			'Figure 3.11(a)' => 'p3_domino_sparker.txt',
			'Figure 3.11(b)' => 'heavyweight_emulator.txt',
			'Figure 3.11(c)' => 'fumarole.txt',
			'Figure 3.11(d)' => 'ellison_p4.txt',
			'Figure 3.11(e)' => 'p6_domino_sparker.txt',
			'Figure 3.11(f)' => 'heavyweight_volcano.txt',
			'Figure 3.11(g)' => 'hebdarole.txt',
			'Figure 3.11(h)' => 'figure_eight.txt',
			'Figure 3.12(a)' => 'p5_pipsquirter.txt',
			'Figure 3.12(b)' => 'p6_pipsquirter.txt',
			'Figure 3.12(c)' => 'p7_pipsquirter.txt',
			'Figure 3.13(a)' => 'fountain.txt',
			'Figure 3.13(b)' => 'middleweight_volcano.txt',
			'Figure 3.13(c)' => 'sparky_p7.txt',
			'Figure 3.13(d)' => 'superfountain.txt',
			'Figure 3.13(e)' => 'middleweight_supervolcano.txt',
			'Figure 3.13(f)' => 'middleweight_emulator.txt',
			'Figure 3.13(g)' => 'blocker.txt',
			'Figure 3.13(h)' => 'rattlesnake.txt',
			'Figure 3.13(i)' => 'koks_galaxy.txt',
			'Figure 3.13(j)' => 'unix.txt',
			'Figure 3.14(a)' => 'caterer.txt',
			'Figure 3.14(b)' => 't_nosed_p4.txt',
			'Figure 3.14(c)' => 'p4_thumb.txt',
			'Figure 3.14(d)' => 'p9_thumb.txt',
			'Figure 3.15(a)' => 'p20_composite.txt',
			'Figure 3.15(b)' => 'p33_oscillator.txt',
			'Figure 3.15(c)' => 'p36_composite.txt',
			'Figure 3.16(a)' => 'twin_bees_shuttle_spark.txt',
			'Figure 3.16(b)' => 'buckaroo.txt',
			'Figure 3.17' => 'spark_glider_reflect.txt',
			'Figure 3.18' => 'honey_farm_hasslers.txt',
			'Figure 3.19(a)' => 'p32_pi_hassler.txt',
			'Figure 3.19(b)' => 'p37_pi_hassler.txt',
			'Figure 3.19(c)' => 'tanners_p46.txt',
			'Figure 3.20(a)' => 'p27_hassler.txt',
			'Figure 3.20(b)' => 'david_hilbert.txt',
			'Figure 3.21' => 't_tetromino_hassle_1.txt',
			'Figure 3.22' => 't_tetromino_hassle_2.txt',
			'Figure 3.23(a)' => 'p20_t_tetromino_hassler.txt',
			'Figure 3.23(b)' => 'p24_t_tetromino_hassler.txt',
			'Figure 3.23(c)' => 'p25_t_tetromino_hassler.txt',
			'Figure 3.24' => 'pre_pulsar.txt',
			'Figure 3.25' => 'pre_pulsar_mechanisms.txt',
			'Figure 3.26' => 'pre_pulsar_hasslers.txt',
			'Figure 3.27' => 'buckaroo_loop.txt',
			'Figure 3.28' => 'relay.txt',
			'Figure 3.29(a)' => 'silver_reflector.txt',
			'Figure 3.29(b)' => 'snark.txt',
			'Figure 3.30(a)' => 'period_43.txt',
			'Figure 3.30(b)' => 'period_53.txt',
			'Figure 3.31' => 'herschel.txt',
			'Figure 3.32' => 'b_heptomino.txt',
			'Figure 3.33' => 'R64.txt',
			'Figure 3.34(b)' => 'Fx77.txt',
			'Figure 3.35(a)' => 'herschel_track_1.txt',
			'Figure 3.35(b)' => 'herschel_track_1_109.txt',
			'Figure 3.36' => 'herschel_track_2.txt',
			'Figure 3.37' => 'phoenix.txt',
			'Figure 3.41' => 'period_3_volatile.txt',
			'Figure 3.42' => 'rich_p16.txt',
			'Figure 3.43' => 'rob_p16.txt',
			'Figure 3.44' => 'period_56_herschel.txt',
			'Exercise 3.2' => 'billiard_table_5x3.txt',
			'Exercise 3.4' => 'exercise_extend_snacker.txt',
			'Exercise 3.5' => 't_nosed_p6.txt',
			'Exercise 3.6' => 'pipsquirter_reflector.txt',
			'Exercise 3.8' => 'supervolcanoes.txt',
			'Exercise 3.9' => 'phase_shift_oscillator.txt',
			'Exercise 3.10' => 'b_heptomino_hassle.txt',
			'Exercise 3.11' => 'exercise_pi_hassle.txt',
			'Exercise 3.12(a)' => 'exercise_high_period_sparker_13.txt',
			'Exercise 3.12(b)' => 'exercise_high_period_sparker_31.txt',
			'Exercise 3.12(c)' => 'exercise_high_period_sparker_32.txt',
			'Exercise 3.13' => 'p7_duoplet_sparker.txt',
			'Exercise 3.14' => 'exercise_pi_heptomino_hassler.txt',
			'Exercise 3.18' => 'exercise_fused_snarks.txt',
			'Exercise 3.20' => 'almost_snark.txt',
			'Exercise 3.22(a)' => 'boojum_reflector.txt',
			'Exercise 3.22(b)' => 'rectifier.txt',
			'Exercise 3.24(1)' => 'traffic_jam.txt',
			'Exercise 3.24(2)' => 't_tetromino_hassle_3.txt',
			'Exercise 3.28' => 'L112.txt',
			'Exercise 3.30' => 'period_57_herschel.txt',
			'Exercise 3.34' => 'period_3_volatile_pieces.txt',
			'Solution 3.1(a)' => 'solution_billiard_table_3x3.txt',
			'Solution 3.1(b)' => 'solution_billiard_table_skew.txt',
			'Solution 3.1(c)' => 'solution_billiard_table_4x4.txt',
			'Solution 3.5(a)' => 'solution_t_sparkers_12.txt',
			'Solution 3.5(b)' => 'solution_t_sparkers_20.txt',
			'Solution 3.5(c)' => 'solution_t_sparkers_24.txt',
			'Solution 3.7' => 'solution_p32_pi_hassler_eaters.txt',
			'Solution 3.9(b)' => 'solution_phase_shift_oscillator.txt',
			'Solution 3.11' => 'pi_portraitor.txt',
			'Solution 3.12(a)' => 'solution_high_period_sparker_13.txt',
			'Solution 3.12(b)' => 'solution_high_period_sparker_31.txt',
			'Solution 3.12(c)' => 'solution_high_period_sparker_32.txt',
			'Solution 3.14' => 'solution_pi_heptomino_hassler.txt',
			'Solution 3.17' => 'solution_six_snark_relay.txt',
			'Solution 3.18(a)' => 'solution_fused_snarks.txt',
			'Solution 3.18(b)' => 'solution_four_fused_snarks.txt',
			'Solution 3.24' => 'p50_traffic_jam.txt',
			'Solution 3.25' => 'solution_traffic_jam_reflect.txt',
			'Solution 3.29' => 'solution_phoenix_bb.txt',
			'Solution 3.34' => 'solution_period_3_volatile.txt',
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

		// The next foreach loop is just for debugging purposes -- comment it out when the website is fully deployed and all patterns are properly labeled.
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