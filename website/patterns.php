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
				$comments = '<p style="margin-bottom:6px;">' . str_replace('https://www.conwaylife.com/book/patterns.php?p=0e0p', 'below', $comments) . '</p>';
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
			'Exercise 3.14' => 'period_38.txt',
			'Exercise 3.15' => 'exercise_pi_heptomino_hassler.txt',
			'Exercise 3.19' => 'exercise_fused_snarks.txt',
			'Exercise 3.21' => 'almost_snark.txt',
			'Exercise 3.23(a)' => 'boojum_reflector.txt',
			'Exercise 3.23(b)' => 'rectifier.txt',
			'Exercise 3.25(1)' => 'traffic_jam.txt',
			'Exercise 3.25(2)' => 't_tetromino_hassle_3.txt',
			'Exercise 3.29' => 'L112.txt',
			'Exercise 3.31' => 'period_57_herschel.txt',
			'Exercise 3.35' => 'period_3_volatile_pieces.txt',
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
			'Solution 3.15' => 'solution_pi_heptomino_hassler.txt',
			'Solution 3.18' => 'solution_six_snark_relay.txt',
			'Solution 3.19(a)' => 'solution_fused_snarks.txt',
			'Solution 3.19(b)' => 'solution_four_fused_snarks.txt',
			'Solution 3.25' => 'p50_traffic_jam.txt',
			'Solution 3.26' => 'solution_traffic_jam_reflect.txt',
			'Solution 3.30' => 'solution_phoenix_bb.txt',
			'Solution 3.35' => 'solution_period_3_volatile.txt',
		);
	} else if($_GET['p'] == 'spaceships'){
		$ch_num = 4;
		$ch_name = 'Spaceships and Moving Objects';

		$fig_nums = array(
			'Figure 4.1' => 'basic_spaceships.txt',
			'Figure 4.3' => 'glider_color.txt',
			'Figure 4.4' => 'reflect_glider_change.txt',
			'Figure 4.5' => 'reflect_glider_change_bees.txt',
			'Figure 4.8(a)' => 'b29.txt',
			'Figure 4.8(b)' => 'canada_goose.txt',
			'Figure 4.8(c)' => 'crab.txt',
			'Figure 4.8(d)' => 'orion_2.txt',
			'Figure 4.9' => 'b29_tagalong.txt',
			'Figure 4.10' => 'tubstretcher.txt',
			'Figure 4.11' => 'lwss_mwss_hwss.txt',
			'Figure 4.12' => 'orthogonal_destroy.txt',
			'Figure 4.13(1)' => 'hwss_eat1.txt',
			'Figure 4.13(2)' => 'hwss_eat2.txt',
			'Figure 4.13(3)' => 'killer_toads.txt',
			'Figure 4.14(a)' => 'sidecar.txt',
			'Figure 4.14(b)' => 'hwss_x66.txt',
			'Figure 4.14(c)' => 'pushalong.txt',
			'Figure 4.14(d)' => 'hivenudger.txt',
			'Figure 4.15' => 'lwss_hwss_pseudo.txt',
			'Figure 4.16' => 'lwss_mwss_flotillae.txt',
			'Figure 4.17' => 'overweight_spaceship.txt',
			'Figure 4.18' => 'owss_flotilla.txt',
			'Figure 4.19' => 'switch_engines_48.txt',
			'Figure 4.20' => 'switch_engine_infinite.txt',
			'Figure 4.21' => 'switch_engines_blocks.txt',
			'Figure 4.22' => 'switch_engines_blocks_destroy.txt',
			'Figure 4.23' => '10_engine_cordership.txt',
			'Figure 4.24' => 'cordership_reflections.txt',
			'Figure 4.25' => 'puffer_2.txt',
			'Figure 4.26' => 'ecologist.txt',
			'Figure 4.27' => 'space_rake.txt',
			'Figure 4.28' => 'back_space_rake.txt',
			'Figure 4.29' => 'schick_engine.txt',
			'Figure 4.30(a)' => 'space_rake_60.txt',
			'Figure 4.30(b)' => 'back_space_rake_60.txt',
			'Figure 4.31' => 'coe_ship.txt',
			'Figure 4.32(a)' => 'coe_ship_back_rake.txt',
			'Figure 4.32(b)' => 'coe_ship_forward_rake.txt',
			'Figure 4.33(a)' => 'coe_space_rake.txt',
			'Figure 4.33(b)' => 'coe_space_rake_stabilized.txt',
			'Figure 4.36' => 'lightspeed_signals.txt',
			'Figure 4.38(a)' => 'signal_sink.txt',
			'Figure 4.38(b)' => 'signal_oscillator.txt',
			'Figure 4.39' => 'zebra_signal_perpendicular.txt',
			'Figure 4.41(a)' => 'diagonal_2c3_signal.txt',
			'Figure 4.41(b)' => 'diagonal_5c9_signal.txt',
			'Figure 4.41(c)' => 'diagonal_c2_signal.txt',
			'Figure 4.42' => 'diagonal_2c3_almost_elbow.txt',
			'Figure 4.43(a)' => 'blinker_fuse.txt',
			'Figure 4.43(b)' => 'bi_block_fuse.txt',
			'Figure 4.44' => 'fast_forward_force_field.txt',
			'Figure 4.46' => 'diagonal_lightspeed.txt',
			'Figure 4.47(a)' => 'c3_orthogonal.txt',
			'Figure 4.47(b)' => 'spider.txt',
			'Figure 4.47(c)' => 'loafer.txt',
			'Figure 4.47(d)' => 'c4_orthogonal.txt',
			'Figure 4.47(e)' => 'c6_orthogonal.txt',
			'Figure 4.47(f)' => '2c5_orthogonal.txt',
			'Figure 4.47(g)' => 'weekender.txt',
			'Figure 4.47(h)' => 'copperhead.txt',
			'Figure 4.47(i)' => 'soba.txt',
			'Figure 4.48(a)' => 'c5_diagonal.txt',
			'Figure 4.48(b)' => 'c6_diagonal.txt',
			'Figure 4.48(c)' => 'lobster.txt',
			'Figure 4.49' => 'sir_robin.txt',
			'Figure 4.50(a)' => 'p2_spaceship.txt',
			'Figure 4.50(b)' => 'p8_puffer.txt',
			'Figure 4.51(a)' => 'p8_rake.txt',
			'Figure 4.51(b)' => 'p8_bi_blocks.txt',
			'Figure 4.52' => 'adjustable_rake.txt',
			'Figure 4.53' => 'big_glider.txt',
			'Figure 4.54' => 'almost_knightship.txt',
			'Figure 4.55' => '17c45_reaction.txt',
			'Exercise 4.1(a)' => 'exercise_color_1.txt',
			'Exercise 4.1(b)' => 'exercise_color_3.txt',
			'Exercise 4.1(c)' => 'exercise_color_2.txt',
			'Exercise 4.6' => 'swan.txt',
			'Exercise 4.7' => 'c4_tagalong0.txt',
			'Exercise 4.8' => 'c4_tagalong1.txt',
			'Exercise 4.9(a)' => 'owss4.txt',
			'Exercise 4.9(b)' => 'owss10.txt',
			'Exercise 4.9(c)' => 'owss6.txt',
			'Exercise 4.10' => 'large_owss_flotilla.txt',
			'Exercise 4.11' => 'rephaser.txt',
			'Exercise 4.15' => 'exercise_switch_engine_reaction.txt',
			'Exercise 4.16' => 'exercise_switch_engine_back.txt',
			'Exercise 4.17' => 'two_switch_engine_block_puffer.txt',
			'Exercise 4.18' => '3_engine_cordership.txt',
			'Exercise 4.20' => '2_engine_cordership.txt',
			'Exercise 4.21' => 'corderrake.txt',
			'Exercise 4.25' => '2_glider_block.txt',
			'Exercise 4.28' => 'beehive_wire.txt',
			'Exercise 4.29' => 'beehive_puffer.txt',
			'Exercise 4.36' => 'adjustable_spaceship.txt',
			'Exercise 4.37' => 'schick_engine_blinker_puffer.txt',
			'Solution 4.6(a)' => 'solution_swan_tubstretcher.txt',
			'Solution 4.6(b)' => 'solution_swan_duplicate.txt',
			'Solution 4.9(a)' => 'solution_owss4.txt',
			'Solution 4.9(b)' => 'solution_owss10.txt',
			'Solution 4.9(c)' => 'solution_owss6.txt',
			'Solution 4.10' => 'solution_large_owss_flotilla.txt',
			'Solution 4.15' => 'solution_switch_engine_reaction.txt',
			'Solution 4.16(b)' => 'solution_switch_engine_back.txt',
			'Solution 4.16(c)' => 'solution_switch_engine_back_cordership.txt',
			'Solution 4.18(b)' => 'solution_3_engine_cordership.txt',
			'Solution 4.20(a)' => 'solution_2_engine_cordership.txt',
			'Solution 4.21(b)' => 'solution_backward_corderrake.txt',
			'Solution 4.21(c)' => 'solution_lwss_corderrake.txt',
			'Solution 4.22(a)' => 'solution_six_cell_schick.txt',
			'Solution 4.23' => 'solution_back_to_forward_space_rake.txt',
			'Solution 4.32' => 'solution_c5_diagonal_reflect.txt',
		);
	} else if($_GET['p'] == 'glider_synthesis'){
		$ch_num = 5;
		$ch_name = 'Glider Synthesis';

		$fig_nums = array(
			'Figure 5.1' => 'lwss_3_gliders.txt',
			'Figure 5.2' => 'lwss_gun.txt',
			'Figure 5.3' => 'invalid_synthesis.txt',
			'Table 5.1' => '2_glider_syntheses.txt',
			'Table 5.2(1)' => 'tee.txt',
			'Table 5.2(2)' => '3_glider_lwss.txt',
			'Table 5.2(3)' => '3_glider_mwss.txt',
			'Table 5.2(4)' => '3_glider_hwss.txt',
			'Table 5.2(5)' => '3_glider_pentadecathlon.txt',
			'Table 5.2(6)' => '3_glider_pulsar.txt',
			'Table 5.2(7)' => '3_glider_queen_bee.txt',
			'Table 5.2(8)' => '3_glider_r_pentomino.txt',
			'Table 5.2(9)' => '3_glider_switch_engine.txt',
			'Table 5.2(10)' => '3_glider_switch_engine_glider.txt',
			'Figure 5.4' => 'gosper_glider_synth.txt',
			'Table 5.3(1)' => '4_glider_clock.txt',
			'Table 5.3(2)' => 'twin_bees_synth.txt',
			'Table 5.3(3)' => 'hwss_4_glider_synth.txt',
			'Table 5.3(4)' => 'eater_2_6_gliders.txt',
			'Figure 5.5' => 'fumarole_sequential.txt',
			'Table 5.4(1)' => 'tub_sequential.txt',
			'Table 5.4(2)' => 'honey_farm_incremental.txt',
			'Table 5.4(3)' => 'queen_bee_sequential.txt',
			'Table 5.4(4)' => 'hat_sequential.txt',
			'Table 5.4(5)' => 'ship_sequential.txt',
			'Table 5.4(6)' => 'tub_with_tail_sequential.txt',
			'Table 5.4(7)' => 'snake_sequential.txt',
			'Table 5.4(8)' => 't_tetromino_incremental.txt',
			'Table 5.4(9)' => 'pentadecathlon_sequential.txt',
			'Table 5.4(10)' => 'lwss_sequential.txt',
			'Table 5.4(11)' => 'mwss_sequential.txt',
			'Table 5.4(12)' => 'hwss_sequential.txt',
			'Figure 5.6' => 'gosper_sequential.txt',
			'Figure 5.7' => 'ecologist_synth.txt',
			'Figure 5.8' => 'ecologist_synth_b.txt',
			'Figure 5.9' => 'space_rake_synth.txt',
			'Figure 5.10' => 'schick_engine_synth.txt',
			'Figure 5.11' => 'coe_ship_incremental.txt',
			'Figure 5.12' => '3_engine_cordership_synthesis.txt',
			'Figure 5.13' => 'richs_p16_soup.txt',
			'Figure 5.15' => 'richs_p16_predecessor.txt',
			'Figure 5.16' => 'richs_p16_synthesis.txt',
			'Figure 5.17' => 'breeder_front.txt',
			'Figure 5.18' => 'breeder_done.txt',
			'Figure 5.20' => 'slow_salvo_splitter.txt',
			'Figure 5.21(a)' => 'block_move_1_glider.txt',
			'Figure 5.21(b)' => 'block_move_6_gliders.txt',
			'Figure 5.22(a)' => 'block_push_2_1.txt',
			'Figure 5.22(b)' => 'block_move_1_neg1.txt',
			'Figure 5.22(c)' => 'block_move_11_0.txt',
			'Figure 5.22(d)' => 'block_push_11_0.txt',
			'Figure 5.23' => 'one_time_turner.txt',
			'Figure 5.24' => 'create_one_time_turner.txt',
			'Figure 5.25' => 'unidirection_clock_synthesis.txt',
			'Figure 5.26' => 'one_time_splitter.txt',
			'Table 5.5' => '180_degree_one_time_turners.txt',
			'Figure 5.27' => 'clock_slow_salvo.txt',
			'Figure 5.28' => 'clock_inserter.txt',
			'Figure 5.29' => 'clock_inserter_effective.txt',
			'Figure 5.30(a)' => '14_cell_synth.txt',
			'Figure 5.30(b)' => '15_cell_synth.txt',
			'Figure 5.30(c)' => '16_cell_synth.txt',
			'Figure 5.30(d)' => '17_cell_synth.txt',
			'Figure 5.30(e)' => '18_cell_synth.txt',
			'Figure 5.30(f)' => '19_cell_synth.txt',
			'Figure 5.31' => '17_cell_synthesis.txt',
			'Figure 5.32' => '17_cell_synthesis_small.txt',
			'Exercise 5.1(a)' => 'exercise_glider_cleanup_1.txt',
			'Exercise 5.1(b)' => 'tumbler_synthesis.txt',
			'Exercise 5.1(c)' => 'snacker_synthesis.txt',
			'Exercise 5.8(b)' => 'glider_pusher.txt',
			'Exercise 5.22' => 'exercise_rich_p16_16.txt',
			'Exercise 5.29' => 'boatstretcher_synth.txt',
			'Exercise 5.30' => 'boat_append_barberpole.txt',
			'Exercise 5.32(b)' => 'two_time_turner.txt',
			'Exercise 5.35(a)' => 'clock_inserter_use_b.txt',
			'Exercise 5.35(b)' => 'clock_inserter_use_d.txt',
			'Exercise 5.35(c)' => 'clock_inserter_use_c.txt',
			'Exercise 5.40' => 'blockic_splitter.txt',
			'Solution 5.2(a)' => 'solution_block_destroy.txt',
			'Solution 5.2(b)' => 'solution_beehive_destroy.txt',
			'Solution 5.2(c)' => 'solution_blinker_destroy.txt',
			'Solution 5.2(d)' => 'solution_ship_destroy.txt',
			'Solution 5.2(e)' => 'solution_lwss_destroy.txt',
			'Solution 5.4' => 'solution_block_glider.txt',
			'Solution 5.5' => 'solution_twit_eater.txt',
			'Solution 5.13(a)' => 'solution_switch_engine_two_directions.txt',
			'Solution 5.13(b)' => 'solution_clock_two_directions.txt',
			'Solution 5.13(c)' => 'solution_cordership_two_directions.txt',
			'Solution 5.14(a)' => 'solution_2_engine_cordership_synthesis.txt',
			'Solution 5.14(b)' => 'solution_2_engine_cordership_synthesis_2dir.txt',
			'Solution 5.15(a)' => 'solution_switch_engine_opposite_directions.txt',
			'Solution 5.15(b)' => 'solution_clock_opposite_directions.txt',
			'Solution 5.15(c)' => 'solution_twin_bees_opposite_directions.txt',
			'Solution 5.17(a)' => 'solution_space_rake_synth.txt',
			'Solution 5.17(b)' => 'solution_p60_space_rake_synth.txt',
			'Solution 5.19' => 'solution_back_space_rake_synth.txt',
			'Solution 5.29(a)' => 'crab_synth.txt',
			'Solution 5.29(b)' => 'solution_large_still_life_synth.txt',
			'Solution 5.31(a)' => 'solution_boat_one_time.txt',
			'Solution 5.31(b)' => 'solution_eater1_one_time.txt',
			'Solution 5.31(c)' => 'solution_longboat_one_time.txt',
			'Solution 5.31(d)' => 'solution_one_time_blinker.txt',
			'Solution 5.32(a)' => 'solution_one_time_square.txt',
			'Solution 5.32(c)' => 'solution_two_time_square.txt',
			'Solution 5.33(a)' => 'solution_one_time_blinker_track.txt',
			'Solution 5.33(b)' => 'solution_one_time_boat_track.txt',
			'Solution 5.34' => 'solution_clock_inserter_block.txt',
			'Solution 5.35(a)' => 'solution_clock_inserter_use_b.txt',
			'Solution 5.35(b)' => 'solution_clock_inserter_use_d.txt',
			'Solution 5.35(c)' => 'solution_clock_inserter_use_c.txt',
			'Solution 5.36(a)' => 'solution_tee_15_ticks.txt',
			'Solution 5.36(b)' => 'solution_eater1_15_ticks.txt',
			'Solution 5.36(c)' => 'solution_clock_14_ticks.txt',
			'Solution 5.44(a)' => 'solution_2_engine_corder_seed_a.txt',
			'Solution 5.44(b)' => 'solution_2_engine_corder_seed_b.txt',
			'Solution 5.44(c)' => 'solution_2_engine_corder_seed_c.txt',
			'Solution 5.44(d)' => 'solution_2_engine_corder_seed_d.txt',
		);
	} else if($_GET['p'] == 'periodic_circuitry'){
		$ch_num = 6;
		$ch_name = 'Periodic Circuitry';

		$fig_nums = array(
			'Figure 6.2' => 'gosper_glider_gun.txt',
			'Figure 6.3' => 'buckaroo_reflect.txt',
			'Figure 6.4(a)' => 'p30_relay.txt',
			'Figure 6.4(b)' => 'p30_180_reflect.txt',
			'Figure 6.4(c)' => 'p30_90_reflect_penta.txt',
			'Figure 6.5' => 'inverter_non_inline.txt',
			'Figure 6.6(a)' => 'inline_inverter.txt',
			'Figure 6.6(b)' => 'inline_inverter_p120.txt',
			'Figure 6.7' => 'inline_inverter_bounce.txt',
			'Figure 6.8(a)' => 'inline_inverter_p120_gun.txt',
			'Figure 6.8(b)' => 'inverter_p120_gun.txt',
			'Figure 6.9' => 'stream_inverter.txt',
			'Figure 6.10' => 'glider_duplicator.txt',
			'Figure 6.11' => 'glider_pusher.txt',
			'Figure 6.12' => 'glider_to_lwss.txt',
			'Figure 6.13' => 'lwss_to_glider.txt',
			'Figure 6.14' => 'toggle.txt',
			'Figure 6.15' => 'prime_lwss_stream.txt',
			'Figure 6.16' => 'glider_lwss_destroy.txt',
			'Figure 6.18' => 'period_not_2_3_lwss_gun.txt',
			'Figure 6.20' => 'breeder_compact.txt',
			'Figure 6.21' => 'breeder_ggg_eater_1_stabilize.txt',
			'Figure 6.22' => 'primer.txt',
			'Figure 6.23' => 'twin_bees_reflect.txt',
			'Figure 6.24(a)' => 'twin_bees_p23_gun.txt',
			'Figure 6.24(b)' => 'twin_bees_p46_lwss_gun.txt',
			'Figure 6.24(c)' => 'twin_bees_lwss_to_mwss.txt',
			'Figure 6.25' => 'twin_bees_duplicate_reflector.txt',
			'Figure 6.26' => 'ticker_tape_gun.txt',
			'Figure 6.27' => 'ticker_tape_hi_gun.txt',
			'Figure 6.28' => 'p46_memory_cell.txt',
			'Figure 6.29(a)' => 'tanners_p46_edge.txt',
			'Figure 6.29(b)' => 'tanners_p46_inline_inverter.txt',
			'Figure 6.29(c)' => 'tanners_p46_mwss_gun.txt',
			'Figure 6.30' => 'p46_hwss_gun.txt',
			'Figure 6.31' => 'p46_natural_heisenburp.txt',
			'Figure 6.32' => 'mwss_out_of_the_blue.txt',
			'Figure 6.33(a)' => 'heisenburp_reaction_p35.txt',
			'Figure 6.33(b)' => 'heisenburp_reaction_p35.txt',
			'Figure 6.34' => 'p46_heisenburp_constructed.txt',
			'Figure 6.35(a)' => 'bumper.txt',
			'Figure 6.35(b)' => 'p3_bumper_b.txt',
			'Figure 6.35(c)' => 'p3_bumper_a.txt',
			'Figure 6.35(d)' => 'p4_bumper.txt',
			'Figure 6.35(e)' => 'p6_bumper.txt',
			'Figure 6.35(f)' => 'p7_bumper.txt',
			'Figure 6.35(g)' => 'p8_bumper.txt',
			'Figure 6.35(h)' => 'p9_bumper.txt',
			'Figure 6.35(i)' => 'p11_bumper.txt',
			'Figure 6.36(b)' => 'p6_bouncer.txt',
			'Figure 6.36(c)' => 'p7_bouncer.txt',
			'Figure 6.36(d)' => 'p8_bouncer.txt',
			'Figure 6.36(e)' => 'p15_bouncer.txt',
			'Figure 6.36(f)' => 'p5_bouncer.txt',
			'Figure 6.37(a)' => 'inverter_as_regulator_0.txt',
			'Figure 6.37(b)' => 'inverter_as_regulator_1.txt',
			'Figure 6.38' => 'boat_bit.txt',
			'Figure 6.39' => 'boat_bit_into_glider.txt',
			'Figure 6.40' => 'make_sync_glider.txt',
			'Figure 6.41(b)' => 'universal_regulator_periodic.txt',
			'Figure 6.42(a)' => 'prng_gun.txt',
			'Figure 6.43' => 'life_computes_pi.txt',
			'Exercise 6.5' => 'glider_to_hwss_to_glider.txt',
			'Exercise 6.6' => 'any_wss_to_glider.txt',
			'Exercise 6.9' => 'exercise_lwss_filter.txt',
			'Exercise 6.19' => 'twin_bees_large_spark.txt',
			'Exercise 6.25' => 'skewed_p29.txt',
			'Exercise 6.30' => 'minimum_snark_loop.txt',
			'Solution 6.24(a)' => 'p16_bumper.txt',
			'Solution 6.24(b)' => 'p22_bumper.txt',
			'Solution 6.24(c)' => 'p4_bumper_fountain.txt',
			'Solution 6.24(d)' => 'p15_bumper.txt',
			'Solution 6.24(e)' => 'p5_bumper.txt',
			'Solution 6.25' => 'p29_pip_reflector.txt',
			'Solution 6.30(a)' => 'solution_minimum_period_snark_loop_a.txt',
			'Solution 6.30(b)' => 'solution_minimum_period_snark_loop_b.txt',
			'Solution 6.30(c)' => 'solution_minimum_period_snark_loop_c.txt',
			'Solution 6.30(e)' => 'solution_minimum_period_snark_loop_e.txt',
		);
	} else if($_GET['p'] == 'stationary_circuitry'){
		$ch_num = 7;
		$ch_name = 'Stable Circuitry';

		$fig_nums = array(
			'Figure 7.1(a)' => 'l112.txt',
			'Figure 7.1(b)' => 'l156.txt',
			'Figure 7.1(c)' => 'p67_gun.txt',
			'Figure 7.2' => 'herschel_orientations.txt',
			'Table 7.1(F,1)' => 'f116.txt',
			'Table 7.1(F,2)' => 'f117.txt',
			'Table 7.1(Fx,1)' => 'fx77.txt',
			'Table 7.1(Fx,2)' => 'fx119.txt',
			'Table 7.1(R,1)' => 'r64.txt',
			'Table 7.1(R,2)' => 'r126.txt',
			'Table 7.1(Rx,1)' => 'rx140.txt',
			'Table 7.1(Rx,2)' => 'rx164.txt',
			'Table 7.1(B,1)' => 'b60.txt',
			'Table 7.1(B,2)' => 'b245.txt',
			'Table 7.1(Bx,1)' => 'bx106.txt',
			'Table 7.1(Bx,2)' => 'bx202.txt',
			'Table 7.1(L,1)' => 'l112_table.txt',
			'Table 7.1(L,2)' => 'l156_table.txt',
			'Table 7.1(Lx,1)' => 'lx86.txt',
			'Table 7.1(Lx,2)' => 'lx163.txt',
			'Figure 7.3(a)' => 'fx77a.txt',
			'Figure 7.3(b)' => 'fx77b.txt',
			'Figure 7.3(c)' => 'fx77c.txt',
			'Figure 7.3(d)' => 'fx77d.txt',
			'Figure 7.3(e)' => 'fx77e.txt',
			'Figure 7.4(a)' => 'fx77c_l112.txt',
			'Figure 7.4(b)' => 'fx77d_l156.txt',
			'Figure 7.5(a)' => 'H_to_G.txt',
			'Figure 7.5(b)' => 'H_to_2G.txt',
			'Figure 7.5(c)' => 'H_to_3G.txt',
			'Figure 7.6' => 'transparent_lane.txt',
			'Figure 7.7(a)' => 'herschel_to_glider_edge_3.txt',
			'Figure 7.7(b)' => 'herschel_to_glider_edge_4.txt',
			'Figure 7.7(c)' => 'herschel_to_glider_edge_1.txt',
			'Figure 7.7(d)' => 'herschel_to_glider_edge_2.txt',
			'Figure 7.8(a)' => 'syringe.txt',
			'Figure 7.8(b)' => 'syringe_modified.txt',
			'Figure 7.9' => 'color_change_stable.txt',
			'Figure 7.10' => 'bandersnatch.txt',
			'Figure 7.11(a)' => 'glider_duplicator.txt',
			'Figure 7.11(b)' => 'glider_tripler.txt',
			'Table 7.2(CP 1)' => 'phase_changer_1_0.txt',
			'Table 7.2(CP 2)' => 'phase_changer_2_0.txt',
			'Table 7.2(CP 3)' => 'phase_changer_3_0.txt',
			'Table 7.2(CP 4)' => 'phase_changer_4_0.txt',
			'Table 7.2(CP 5)' => 'phase_changer_5_0.txt',
			'Table 7.2(CP 6)' => 'phase_changer_6_0.txt',
			'Table 7.2(CP 7)' => 'phase_changer_7_0.txt',
			'Table 7.2(CC 0)' => 'phase_changer_0_1.txt',
			'Table 7.2(CC 1)' => 'phase_changer_1_1.txt',
			'Table 7.2(CC 2)' => 'phase_changer_2_1.txt',
			'Table 7.2(CC 3)' => 'phase_changer_3_1.txt',
			'Table 7.2(CC 4)' => 'phase_changer_4_1.txt',
			'Table 7.2(CC 5)' => 'phase_changer_5_1.txt',
			'Table 7.2(CC 6)' => 'phase_changer_6_1.txt',
			'Table 7.2(CC 7)' => 'phase_changer_7_1.txt',
			'Figure 7.12(a)' => 'glider_to_lwss_incomplete.txt',
			'Figure 7.12(b)' => 'glider_to_lwss_big.txt',
			'Figure 7.13(a)' => 'trombone_slide_276.txt',
			'Figure 7.13(b)' => 'trombone_slide_284.txt',
			'Figure 7.14' => 'g_to_2engine_V.txt',
			'Figure 7.15(1)' => '2engine_synchronize_1.txt',
			'Figure 7.15(2)' => '2engine_synchronize_2.txt',
			'Figure 7.15(3)' => '2engine_synchronize_3.txt',
			'Figure 7.15(4)' => '2engine_synchronize_4.txt',
			'Figure 7.16' => 'glider_to_2engine_cordership.txt',
			'Figure 7.17' => 'p80_adjustable_gun.txt',
			'Figure 7.18(a)' => 'cp_semi_snark.txt',
			'Figure 7.18(b)' => 'cc_semi_snark.txt',
			'Figure 7.19(a)' => 'p2144_gun.txt',
			'Figure 7.19(b)' => 'p_2_100_gun.txt',
			'Figure 7.20' => 'block_18_gliders.txt',
			'Figure 7.21' => 'block_18_gliders_repeatable.txt',
			'Figure 7.22' => 'p1703_gun.txt',
			'Figure 7.23' => 'p3413277319_gun.txt',
			'Figure 7.25(a)' => 'BLx19R.txt',
			'Figure 7.25(b)' => 'RF28B.txt',
			'Figure 7.26' => 'P_to_P.txt',
			'Figure 7.27(a)' => 'L_to_G.txt',
			'Figure 7.27(b)' => 'M_to_G.txt',
			'Table 7.3(H-B)' => 'HFx58B.txt',
			'Table 7.3(H-R)' => 'HLx69R.txt',
			'Table 7.3(H-P)' => 'HF95P.txt',
			'Table 7.3(B-G)' => 'BSE22T31.txt',
			'Table 7.3(B-H)' => 'BFx59H.txt',
			'Table 7.3(B-B)' => 'BRx46B.txt',
			'Table 7.3(B-R)' => 'BLx19R.txt',
			'Table 7.3(B-P)' => 'BF22P.txt',
			'Table 7.3(R-G)' => 'RNW3T46.txt',
			'Table 7.3(R-H)' => 'RR56H.txt',
			'Table 7.3(R-B)' => 'RF28B.txt',
			'Table 7.3(R-R)' => 'RFx36R.txt',
			'Table 7.3(R-P)' => 'RF29P.txt',
			'Table 7.3(P-G)' => 'P_to_G.txt',
			'Table 7.3(P-H)' => 'P_to_H.txt',
			'Table 7.3(P-B)' => 'PT9B.txt',
			'Table 7.3(P-R)' => 'P_to_R.txt',
			'Table 7.3(P-P)' => 'P_to_P.txt',
			'Figure 7.28(a)' => 'glider_stopper.txt',
			'Figure 7.28(b)' => 'beehive_stopper.txt',
			'Figure 7.29(a)' => 'H_to_beehive.txt',
			'Figure 7.29(b)' => 'H_to_loaf.txt',
			'Figure 7.30(a,1)' => 'H_to_boat_2.txt',
			'Figure 7.30(a,2)' => 'H_to_boat_3.txt',
			'Figure 7.30(b)' => 'demultiplexer.txt',
			'Figure 7.31(1)' => 'H_to_block_3.txt',
			'Figure 7.31(2)' => 'H_to_block_2.txt',
			'Figure 7.31(3)' => 'H_to_block.txt',
			'Figure 7.31(4)' => 'block_keeper.txt',
			'Figure 7.32' => 'glider_loaf_collision.txt',
			'Figure 7.33' => 'highway_robber.txt',
			'Figure 7.34' => 'mwss_ship_to_glider.txt',
			'Figure 7.35' => 'herschel_evolution.txt',
			'Figure 7.36' => 'stable_heisenburp.txt',
			'Figure 7.37' => '2g_to_h_old_callahan.txt',
			'Figure 7.38' => 'callahan_g_to_h.txt',
			'Figure 7.39' => 'herschel_transceiver.txt',
			'Figure 7.40' => 'block_pusher.txt',
			'Figure 7.41' => 'herschel_transceiver_4.txt',
			'Figure 7.42' => 'coe_to_herschel.txt',
			'Exercise 7.1(a)' => 'exercise_name_conduit_1.txt',
			'Exercise 7.1(b)' => 'exercise_name_conduit_2.txt',
			'Exercise 7.1(c)' => 'exercise_name_conduit_3.txt',
			'Exercise 7.1(d)' => 'exercise_name_conduit_4.txt',
			'Exercise 7.4' => 'H_to_G_transparent_better.txt',
			'Exercise 7.8(1)' => 'exercise_syringe_compact.txt',
			'Exercise 7.8(2)' => 'eater_5_modification.txt',
			'Exercise 7.10(1)' => 'F166.txt',
			'Exercise 7.10(2)' => 'Lx200.txt',
			'Exercise 7.20' => 'exercise_other_toolkit_from_semi_snarks.txt',
			'Exercise 7.20(c)' => 'cp_semi_cenark.txt',
			'Exercise 7.21(b)' => 'cc_semi_cenark.txt',
			'Exercise 7.22' => 'tremi_snark.txt',
			'Exercise 7.23' => 'quadri_snark.txt',
			'Exercise 7.24' => 'quinti_snark.txt',
			'Exercise 7.29' => 'exercise_H_to_4G.txt',
			'Exercise 7.30(1)' => 'BR146H.txt',
			'Exercise 7.30(2)' => 'HFx58Bb.txt',
			'Exercise 7.32(1)' => 'BFx59H_variants.txt',
			'Exercise 7.32(2)' => 'exercise_herschel_variants.txt',
			'Exercise 7.34' => 'h_to_G6.txt',
			'Exercise 7.36' => 'herschel_tee.txt',
			'Exercise 7.39' => 'exercise_toggle_better_demultiplexer.txt',
			'Exercise 7.41(1)' => 'wainwright_p72.txt',
			'Exercise 7.41(2)' => 'achims_p144.txt',
			'Exercise 7.44' => 'exercise_hwss_heisenburp_reaction.txt',
			'Solution 7.3' => 'solution_two_transparent_lanes.txt',
			'Solution 7.8' => 'solution_syringe_compact.txt',
			'Solution 7.10' => 'solution_syringe_Lx200.txt',
			'Solution 7.13(a)' => 'glider_to_4.txt',
			'Solution 7.13(b)' => 'glider_to_5.txt',
			'Solution 7.13(c)' => 'glider_to_10.txt',
			'Solution 7.17(c)' => 'solution_faster_trombone_slide.txt',
			'Solution 7.20(a)' => 'solution_other_toolkit_from_semi_snarks_a.txt',
			'Solution 7.27' => 'simkin_glider_gun.txt',
			'Solution 7.30(b)' => 'HL262B.txt',
			'Solution 7.32' => 'solution_herschel_variants.txt',
			'Solution 7.38(a)' => 'solution_p97_gun.txt',
			'Solution 7.38(b)' => 'solution_p78_gun.txt',
			'Solution 7.38(d)' => 'solution_p74_gun.txt',
		);
	} else if($_GET['p'] == 'glider_guns'){
		$ch_num = 8;
		$ch_name = 'Guns and Glider Streams';

		$fig_nums = array(
			'Figure 8.1' => 'glider_delete.txt',
			'Figure 8.2(a)' => 'p60_gun.txt',
			'Figure 8.2(b)' => 'p92_gun.txt',
			'Figure 8.3' => 'glider_delete2.txt',
			'Figure 8.4' => 'p138_gun.txt',
			'Figure 8.5(a)' => 'glider_delete4.txt',
			'Figure 8.5(b)' => 'glider_delete6.txt',
			'Figure 8.6(a)' => 'glider_delete_dot.txt',
			'Figure 8.6(b)' => 'glider_delete_domino.txt',
			'Figure 8.6(c)' => 'glider_delete_banana.txt',
			'Figure 8.7(a)' => 'blocker_glider_filter.txt',
			'Figure 8.7(b)' => 'richs_p16_glider_filter.txt',
			'Figure 8.7(c)' => 'p22_glider_filter.txt',
			'Figure 8.8(a)' => 'tee.txt',
			'Figure 8.8(b)' => 'lwss_reflect_glider.txt',
			'Figure 8.9' => 'p23_gun.txt',
			'Figure 8.10(a)' => 'lwss_squish.txt',
			'Figure 8.10(b)' => 'lwss_squish_pip.txt',
			'Figure 8.10(c)' => 'lwss_squish_blinker.txt',
			'Figure 8.10(d)' => 'lwss_squish_herschel.txt',
			'Figure 8.10(e)' => 'lwss_squish_p4.txt',
			'Figure 8.10(f)' => 'lwss_squish_p5.txt',
			'Figure 8.11' => 'p15_gun.txt',
			'Figure 8.12(a)' => 'p14_pieces_lwss.txt',
			'Figure 8.12(b)' => 'H_G_to_MWSS.txt',
			'Figure 8.13(a)' => 'p84_lwss_gun_adjustable.txt',
			'Figure 8.13(b)' => 'p84_lwss_gun.txt',
			'Figure 8.14(a)' => 'lwss_filter_tnosed_p4.txt',
			'Figure 8.14(b)' => 'lwss_filter_blocker.txt',
			'Figure 8.14(c)' => 'lwss_filter_pentadecathlon.txt',
			'Figure 8.15' => 'lwss_insertion_p18.txt',
			'Figure 8.16(a)' => 'lwss_upgrade.txt',
			'Figure 8.16(b)' => 'mwss_upgrade.txt',
			'Figure 8.17' => 'p14_pieces_p84.txt',
			'Figure 8.18' => 'p14_gun.txt',
			'Figure 8.19(a)' => 'p22_glider_gun.txt',
			'Figure 8.19(b)' => 'p45_gun.txt',
			'Figure 8.20(a)' => 'jasons_p36.txt',
			'Figure 8.20(b)' => 'p36_gun.txt',
			'Figure 8.21(a)' => 'jasons_p33.txt',
			'Figure 8.21(b)' => 'p33_gun.txt',
			'Figure 8.22(a)' => 'p24_glider_gun.txt',
			'Figure 8.22(b)' => 'p20_glider_gun.txt',
			'Figure 8.23' => 'p28_glider_gun.txt',
			'Figure 8.24' => 'p32_glider_gun.txt',
			'Figure 8.25' => 'p44_glider_gun.txt',
			'Figure 8.26' => 'p50_true_gun.txt',
			'Figure 8.27' => 'p59_glider_reaction.txt',
			'Figure 8.28' => 'p59_glider_gun.txt',
			'Figure 8.29(b)' => 'fx77_extract_p4.txt',
			'Figure 8.29(c)' => 'fx77_extract_p5.txt',
			'Figure 8.29(d)' => 'fx77_extract_p6.txt',
			'Figure 8.29(e)' => 'fx77_extract_p8.txt',
			'Figure 8.30(a)' => 'fx77_57.txt',
			'Figure 8.30(b)' => 'fx77_p5_eat.txt',
			'Figure 8.30(c)' => 'fx77_p8_eat.txt',
			'Figure 8.30(d)' => 'fx77_p9_eat.txt',
			'Figure 8.31(a)' => '2G_to_Ha.txt',
			'Figure 8.31(b)' => '2G_to_Hb.txt',
			'Figure 8.32(a)' => 'p52_gun.txt',
			'Figure 8.32(b)' => 'p57_gun.txt',
			'Figure 8.32(c)' => 'p54_gun.txt',
			'Figure 8.32(d)' => 'p55_gun.txt',
			'Figure 8.32(e)' => 'p56_gun.txt',
			'Figure 8.33(a,1)' => 'HG_to_HB.txt',
			'Figure 8.33(a,2)' => 'HG_to_BB.txt',
			'Figure 8.33(b,1)' => 'H_to_2G_quick1.txt',
			'Figure 8.33(b,2)' => 'H_to_2G_quick2.txt',
			'Figure 8.34' => 'p61_gun.txt',
			'Figure 8.35' => 'p58_herschel_track.txt',
			'Figure 8.36' => 'p58_gun.txt',
			'Figure 8.37' => 'synchronized_block_movers.txt',
			'Figure 8.38' => 'synchronized_block_reflectors.txt',
			'Figure 8.39' => 'slide_gun.txt',
			'Figure 8.40' => 'double_slide_gun.txt',
			'Figure 8.41' => 'armless_4_lane_monochrome_gun.txt',
			'Figure 8.42' => 'armless_tee.txt',
			'Figure 8.43' => 'armless_4_lane_gun.txt',
			'Figure 8.44' => '2_engine_cordership_slow_pair_synthesis.txt',
			'Figure 8.45' => 'armless_monochrome_cordership_gun.txt',
			'Figure 8.46' => 'armless_cordership_gun.txt',
			'Figure 8.47' => 'sqrtgun.txt',
			'Figure 8.48' => 'caber_tosser.txt',
			'Figure 8.49' => 'recursive_filter.txt',
			'Figure 8.51' => 'fermat_primer.txt',
			'Figure 8.53' => 'p16_gun.txt',
			'Figure 8.54' => 'quadratic_filter.txt',
			'Figure 8.55' => 'exponential_filter.txt',
			'Exercise 8.13' => 'exer_p21_oscillator.txt',
			'Exercise 8.13(b)' => 'exer_p7_oscillator.txt',
			'Exercise 8.17' => 'exer_p51_reaction.txt',
			'Exercise 8.17(b)' => 'exer_p7_dot_spark.txt',
			'Exercise 8.19' => 'exer_p50_glider_stabilize.txt',
			'Exercise 8.23(a)' => 'exercise_honey_farm_pusher.txt',
			'Exercise 8.23(b)' => 'exercise_beehive_pusher.txt',
			'Exercise 8.25' => 'exercise_edge_shoot_30n.txt',
			'Exercise 8.31(a,1)' => 'exercise_herschel_tee_387_loop.txt',
			'Exercise 8.31(a,2)' => 'exercise_herschel_tee_4_gliders.txt',
			'Exercise 8.40' => 'fermat_beehive_puffer.txt',
			'Solution 8.1' => 'solution_p28_double.txt',
			'Solution 8.3' => 'solution_p322_gun.txt',
			'Solution 8.5' => 'p80_glider_gun_a.txt',
			'Solution 8.13(b)' => 'solution_p21_gun.txt',
			'Solution 8.13(c)' => 'solution_p42_gun.txt',
			'Solution 8.19(a)' => 'solution_p50_snarks.txt',
			'Solution 8.19(b)' => 'solution_p50_bumpers.txt',
		);
	} else if($_GET['p'] == 'universal_computation'){
		$ch_num = 9;
		$ch_name = 'Universal Computation';

		$fig_nums = array(
			'Figure 9.2' => 'sliding_block_register.txt',
			'Figure 9.3' => 'add_computer.txt',
			'Figure 9.4' => 'stable_universal_regulator.txt',
			'Figure 9.5' => 'p2to_the_20_gun.txt',
			'Figure 9.6' => 'mult_computer.txt',
			'Figure 9.7' => 'binary_register.txt',
			'Figure 9.8' => 'binary_ruler.txt',
			'Figure 9.9' => 'add_component.txt',
			'Figure 9.10' => 'sub_component.txt',
			'Figure 9.11' => 'mul_component.txt',
			'Figure 9.12(a)' => 'char_printer_place_pixel.txt',
			'Figure 9.12(b)' => 'char_printer_push_cursor.txt',
			'Figure 9.13' => 'row_printer.txt',
			'Figure 9.14' => 'abracadabra_printer.txt',
			'Figure 9.15' => 'pi_calculator.txt',
			'Figure 9.17' => 'osqrtlogt.txt',
		);
	} else if($_GET['p'] == 'self_support_spaceships'){
		$ch_num = 10;
		$ch_name = 'Self-Supporting Spaceships';

		$fig_nums = array(
			'Figure 10.1' => '31c_240_reaction.txt',
			'Figure 10.2' => '31c_240_herschel_pair.txt',
			'Figure 10.3' => '31c_240_rakes_and_rephaser.txt',
			'Figure 10.4(a)' => '31c_240_track_builder.txt',
			'Figure 10.4(b)' => '31c_240_track_destroyer.txt',
			'Figure 10.5(a)' => 'g_2h_to_m.txt',
			'Figure 10.5(b)' => 'herschel_mwss_stabilize.txt',
			'Figure 10.6(a)' => 'hwss_toad_beehive.txt',
			'Figure 10.6(b)' => '31c_240_double_gun.txt',
			'Figure 10.7' => 'hwss_from_toad_beehive.txt',
			'Figure 10.8(a)' => 'R2L23.txt',
			'Figure 10.8(b)' => 'R2L25.txt',
			'Figure 10.8(c)' => 'R6L17.txt',
			'Figure 10.8(d)' => 'R1L0.txt',
			'Figure 10.8(e)' => 'R6L6.txt',
			'Figure 10.9' => 'silverfish.txt',
			'Figure 10.10' => 'reburnable_wick.txt',
			'Figure 10.11(a)' => 'pi_backward_rake.txt',
			'Figure 10.11(b)' => 'pi_forward_rake.txt',
			'Figure 10.12' => 'blinker_trail_synth.txt',
			'Figure 10.13' => 'helix_operations.txt',
			'Figure 10.14' => 'caterpillar_helix.txt',
			'Figure 10.15' => 'caterpillar.txt',
			'Figure 10.16' => '23_5c_79_reaction.txt',
			'Figure 10.17' => '50_13c_161_helix.txt',
			'Figure 10.18' => 'waterbear.txt',
			'Figure 10.19' => 'caterloopillar_loaf_pusher.txt',
			'Figure 10.21' => 'caterloopillar_loaf_puller.txt',
			'Figure 10.22(a)' => 'caterloopillar_front_end.txt',
			'Figure 10.22(b)' => 'caterloopillar_back_end.txt',
			'Figure 10.23' => 'caterloopillar.txt',
			'Figure 10.24(a)' => 'shield_bug.txt',
			'Figure 10.24(b)' => 'centipede.txt',
			'Figure 10.25(a)' => '13_1c_31_b_heptomino_climber.txt',
			'Figure 10.25(b)' => '27_1c_72_herschel_climber.txt',
			'Figure 10.25(c)' => '34_7c_156_herschel_climber.txt',
			'Figure 10.25(d)' => 'half_bakery_reaction.txt',
			'Figure 10.26' => 'half_baked_knightship_reactions.txt',
			'Figure 10.27' => 'parallel_hbk.txt',
			'Exercise 10.4' => 'R6L21.txt',
			'Exercise 10.6' => 'R3L28.txt',
			'Exercise 10.16' => 'exercise_helix_components.txt',
			'Solution 10.2(a)' => 'R4L1.txt',
			'Solution 10.5(a)' => 'R2L16_partial.txt',
			'Solution 10.5(b)' => 'R2L16.txt',
			'Solution 10.30(a)' => '34_7c_156_herschel_climber_block.txt',
		);
	} else if($_GET['p'] == 'universal_construction'){
		$ch_num = 11;
		$ch_name = 'Universal Construction';

		$fig_nums = array(
			'Figure 11.1(a)' => 'gemini_pull.txt',
			'Figure 11.1(b)' => 'gemini_push.txt',
			'Figure 11.1(c)' => 'gemini_fire_white.txt',
			'Figure 11.1(d)' => 'gemini_fire_black.txt',
			'Figure 11.2' => 'construction_arm.txt',
			'Figure 11.3' => 'mwss_universal_constructor.txt',
			'Figure 11.4' => 'gemini.txt',
			'Figure 11.5' => 'geminoid_knightship.txt',
			'Figure 11.6' => '90_degree_first_example.txt',
			'Figure 11.7(a)' => '0_degree_block_push.txt',
			'Figure 11.7(b)' => '0_degree_block_pull.txt',
			'Figure 11.8' => '90_degree_block_move.txt',
			'Figure 11.9' => 'lane_8_0degree.txt',
			'Figure 11.10' => '0degree_hand.txt',
			'Figure 11.11' => '0_degree_block_move.txt',
			'Figure 11.12' => 'snark_slow_salvo.txt',
			'Figure 11.13' => 'snarkmaker.txt',
			'Figure 11.14' => 'snarkbreaker.txt',
			'Figure 11.15' => 'scorbie_splitter.txt',
			'Figure 11.16' => 'slow_demonoid.txt',
			'Figure 11.17(a)' => 'snark_lwss_destroy.txt',
			'Figure 11.17(b)' => 'scorbie_splitter_xwss_destroy.txt',
			'Figure 11.18' => 'cordership_seed.txt',
			'Figure 11.19(1)' => 'cordership_shoot_down.txt',
			'Figure 11.19(2)' => 'cordership_shoot_down_recipe.txt',
			'Figure 11.20' => 'c256_demonoid.txt',
			'Figure 11.21' => 'boatstretcher_seed.txt',
			'Figure 11.22' => 'boatstretcher_shoot_down.txt',
			'Figure 11.23(a)' => 'snark_seeded_destroy.txt',
			'Figure 11.23(b)' => 'scorbie_splitter_seeded_destroy.txt',
			'Figure 11.24' => 'double_boatstretcher_shoot_down.txt',
			'Figure 11.25' => 'speed_demonoid.txt',
			'Figure 11.26' => 'chapman_greene_constructor.txt',
			'Figure 11.27' => 'spiral_growth.txt',
			'Exercise 11.18' => 'exercise_hwss_slow_salvo.txt',
			'Exercise 11.22' => 'exercise_single_channel_scorbie_splitter.txt',
			'Exercise 11.27' => '44hd_elbow_push.txt',
			'Exercise 11.40' => 'exercise_snark_spiral_weld.txt',
			'Appendix B.3' => 'scorbie_splitter_maker.txt',
			'Appendix B.4' => 'scorbie_splitter_destroyer.txt',
			'Appendix B.5' => 'cordership_maker.txt',
		);
	} else if($_GET['p'] == '0e0p'){
		$ch_num = 12;
		$ch_name = 'The 0E0P Metacell';

		$fig_nums = array(
			'Figure 12.1' => '0e0p_glider.txt',
			'Figure 12.2' => 'highlife_replicator.txt',
			'Figure 12.3' => 'metareplicator.txt',
			'Figure 12.4' => 'replicator_smile.txt',
			'Figure 12.5' => 'replicator_all_births.txt',
			'Figure 12.6' => 'spiral_growth_elementary.txt',
			'Figure 12.9' => 'reflectorless_rotating_oscillator.txt',
			'Figure 12.10' => 'smosmos.txt',
			'Figure 12.11(a)' => 'single_cell_orth.txt',
			'Figure 12.11(b)' => 'single_cell_knightship.txt',
			'Figure 12.12' => 'single_cell_sierpinski.txt',
			'Figure 12.16' => '0e0p_rule_em_glider.txt',
			'Figure 12.18' => '0e0p.txt',
			'Figure 12.19' => 'syringe_path_changer.txt',
			'Figure 12.20' => 'clock_path_switcher.txt',
			'Figure 12.21' => 'state_lookup_clock_gun.txt',
			'Figure 12.22' => '0e0p_subroutine.txt',
			'Figure 12.23' => 'semi_snark_self_destruct.txt',
			'Figure 12.24(1)' => 'clock_gun_full_small.txt',
			'Figure 12.24(2)' => 'clock_gun_full.mc',
			'Figure 12.25(1)' => '0e0p_timeline_0_small.txt',
			'Figure 12.25(2)' => '0e0p_timeline_0.mc',
			'Figure 12.26(1)' => '0e0p_timeline_33554432_small.txt',
			'Figure 12.26(2)' => '0e0p_timeline_33554432.mc',
			'Figure 12.27(1)' => '0e0p_timeline_50921682_small.txt',
			'Figure 12.27(2)' => '0e0p_timeline_50921682.mc',
			'Figure 12.28(1)' => '0e0p_timeline_141139967_small.txt',
			'Figure 12.28(2)' => '0e0p_timeline_141139967.mc',
			'Figure 12.29(1)' => '0e0p_timeline_367748078_small.txt',
			'Figure 12.29(2)' => '0e0p_timeline_367748078.mc',
			'Figure 12.30(1)' => '0e0p_timeline_431312741_small.txt',
			'Figure 12.30(2)' => '0e0p_timeline_431312741.mc',
			'Figure 12.31(1)' => '0e0p_timeline_431969616_small.txt',
			'Figure 12.31(2)' => '0e0p_timeline_431969616.mc',
			'Figure 12.32(1)' => '0e0p_timeline_433582348_small.txt',
			'Figure 12.32(2)' => '0e0p_timeline_433582348.mc',
			'Figure 12.33(1)' => '0e0p_timeline_434341913_small.txt',
			'Figure 12.33(2)' => '0e0p_timeline_434341913.mc',
			'Figure 12.34(1)' => '0e0p_timeline_434724270_small.txt',
			'Figure 12.34(2)' => '0e0p_timeline_434724270.mc',
			'Figure 12.35(1)' => '0e0p_timeline_435925955_small.txt',
			'Figure 12.35(2)' => '0e0p_timeline_435925955.mc',
			'Figure 12.36(1)' => '0e0p_timeline_438935522_small.txt',
			'Figure 12.36(2)' => '0e0p_timeline_438935522.mc',
			'Figure 12.37(1)' => '0e0p_timeline_968843520_small.txt',
			'Figure 12.37(2)' => '0e0p_timeline_968843520.mc',
			'Figure 12.38(1)' => '0e0p_timeline_974368517_small.txt',
			'Figure 12.38(2)' => '0e0p_timeline_974368517.mc',
			'Figure 12.39(1)' => '0e0p_timeline_1073734584_small.txt',
			'Figure 12.39(2)' => '0e0p_timeline_1073734584.mc',
			'Figure 12.40(1)' => '0e0p_timeline_1073741824_small.txt',
			'Figure 12.40(2)' => '0e0p_timeline_1073741824.mc',
			'Figure 12.41(1)' => '0e0p_timeline_2147483648_small.txt',
			'Figure 12.41(2)' => '0e0p_timeline_2147483648.mc',
			'Figure 12.42(1)' => '0e0p_timeline_6979321856_small.txt',
			'Figure 12.42(2)' => '0e0p_timeline_6979321856.mc',
			'Figure 12.43(1)' => '0e0p_timeline_7516192768_small.txt',
			'Figure 12.43(2)' => '0e0p_timeline_7516192768.mc',
			'Figure 12.44(1)' => '0e0p_timeline_7517755585_small.txt',
			'Figure 12.44(2)' => '0e0p_timeline_7517755585.mc',
			'Figure 12.45(1)' => '0e0p_timeline_8053072526_small.txt',
			'Figure 12.45(2)' => '0e0p_timeline_8053072526.mc',
			'Figure 12.46(1)' => '0e0p_timeline_8054286989_small.txt',
			'Figure 12.46(2)' => '0e0p_timeline_8054286989.mc',
			'Figure 12.47(1)' => '0e0p_timeline_8054294330_small.txt',
			'Figure 12.47(2)' => '0e0p_timeline_8054294330.mc',
			'Figure 12.48(1)' => '0e0p_timeline_8124366848_small.txt',
			'Figure 12.48(2)' => '0e0p_timeline_8124366848.mc',
			'Figure 12.49(1)' => '0e0p_timeline_17179869184_small.txt',
			'Figure 12.49(2)' => '0e0p_timeline_17179869184.mc',
			'Figure 12.50(1)' => '0e0p_timeline_34359738368_small.txt',
			'Figure 12.50(2)' => '0e0p_timeline_34359738368.mc',
			'Figure 12.52' => 'p5760_metacell.txt',
			'Figure 12.53' => 'otca_metapixel.txt',
			'Figure 12.54' => 'metablinker.txt',
			'Figure 12.55' => 'p1_megacell.txt',
			'Exercise 12.5' => 'life_like_almost_rro.txt',
			'Solution 12.10(a)' => 'solution_snark_destroyer.txt',
		);
	} else {
		header('Location: https://conwaylife.com/book/');
	}

	if($ch_num <= 11) {
		$zip_size = filesize('patterns/' . $_GET['p'] . '/all.zip');
		$zip_size_readable = round($zip_size / 1048576, 2);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Conway's Game of Life: Mathematics and Construction</title>
  <meta name="description" content="A textbook for mathematical aspects of Conway's Game of Life and methods of pattern construction.">
  <meta name="author" content="Nathaniel Johnston and Dave Greene">
<meta name="LifeViewer" content="rle code 37 hide limit">
  <script type="text/javascript" src="https://conwaylife.com/book/js/lv-plugin.js"></script>
  <script type="text/javascript" src="https://conwaylife.com/book/js/selectCode.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="https://conwaylife.com/book/css/normalize.css">
  <link rel="stylesheet" href="https://conwaylife.com/book/css/skeleton.css">
  <link rel="stylesheet" href="https://conwaylife.com/book/css/custom.css">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
  <link rel="stylesheet" href="css/github-prettify-theme.css">
  <script src="https://conwaylife.com/book/js/site.js"></script>

<link rel="shortcut icon" type="image/png" href="https://conwaylife.com/book/favicon.png" />

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
        <div style="width:158px;" class="bookimgdiv">
          <img src="https://conwaylife.com/book/images/logo.png" style="width:158px;height:157px;" class="bookimg">
        </div>
        <div style="overflow: hidden;">
          <h1 style="font-weight:bold;margin-bottom:0px;">Conway's Game of Life</h1>
          <h3 style="margin-top:0px;">Mathematics and Construction</h3>
          <a class="button button-primary" href="https://conwaylife.com/book/#download_pdf">Download the Book</a>
        </div>
      </div>


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
		//foreach(scandir('patterns/' . $_GET['p'] . '/') as $file) {
		//	if(array_search($file, $fig_nums) === FALSE) {// only display the file down here if we did not already display it along with its Figure number
		//		show_pattern_file($file);
		//	}
		//}
?>
    </div>


  </div>

</body>
</html>