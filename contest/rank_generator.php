<?php

if (!defined('noob')) {
	exit('<h1>Invalid page request</h1>');
}

$Contestant = [];
$done = []; //key = problem + user
$Accepted = []; //key = user + problem which traces the time of accepted submission of that particular problem
$Rejected = []; //key = user + problem which counts the number of rejected submission of that particular problem
$Penalty = []; //key = user + problem which traces the calculated penalty of that particular problem
$total_penalty = []; //key = user which stores the total penalty of that user
$total_scored = []; //key = user which stores the total score of that user
$first_solved_tym = []; //key = user which store the time of first accepted submission of that user
$last_solved_tym = []; //key = user which store the time of first accepted submission of that user
$first_solver = [];

foreach ($arr as $cur_sub) {
	$user = $cur_sub['Username'];
	$problem = $cur_sub['Problem'];
	$verdict = $cur_sub['Verdict'];
	$subtym = $cur_sub['subtym'];

	$Contestant[] = $user;
	if ($verdict == 'Accepted' && !isset($done[$user.','.$problem])) {

		if (!isset($first_solved_tym[$user])) {
			$first_solved_tym[$user] = $subtym;
		}
		if (!isset($total_scored[$user])) {
			$total_scored[$user] = 0;
		}
		if (!isset($total_penalty[$user])) {
			$total_penalty[$user] = 0;
		}
		$last_solved_tym[$user] = $subtym; //updating...

		$done[$user.','.$problem] = TRUE;
		$Accepted[$user.','.$problem] = $subtym;
		$total_scored[$user] = $total_scored[$user] + $scr_arr[$problem];

		$ep = 0;
		if (!isset($Rejected[$user.','.$problem])) {
			$Rejected[$user.','.$problem] = 0;
		}
		$ep = $Rejected[$user.','.$problem] * 1200;
		$Penalty[$user.','.$problem] = $subtym + $ep;
		$total_penalty[$user] += ($subtym + $ep);

		if (!isset($first_solver[$problem])) {
			$first_solver[$problem] = $user;
		}
	}

	else if ($verdict != 'Accepted' && !isset($done[$user.','.$problem])) {
		if (!isset($Rejected[$user.','.$problem])) {$Rejected[$user.','.$problem] = 0;}
		$Rejected[$user.','.$problem]++;
	}
}

$Contestant = array_unique($Contestant);
function cmp($a, $b) {
	global $total_scored, $total_penalty, $first_solved_tym, $last_solved_tym;
	if ($total_scored[$a] == $total_scored[$b]) {
		if ($total_penalty[$a] == $total_penalty[$b] && $total_penalty[$a] == -1) {
			//both of them haven't submitted or scored yet
			$random_user = rand(1, 2);
			return ($random_user == 1) ? -1 : 1;
		}
		else if ($total_penalty[$a] == $total_penalty[$b]) {
			if ($last_solved_tym[$a] == $last_solved_tym[$b]) {
				if ($first_solved_tym[$a] == $first_solved_tym[$b]) {
					$random_user = rand(1, 2);
					return ($random_user == 1) ? -1 : 1;
				}
				else {
					return ($first_solved_tym[$a] < $first_solved_tym[$b]) ? -1 : 1;
				}
			}
			else {
				return ($last_solved_tym[$a] < $last_solved_tym[$b]) ? -1 : 1;
			}
		}
		else if ($total_penalty[$a] == -1) {
			return 1;
		}
		else if ($total_penalty[$b] == -1) {
			return -1;
		}
		else {
			return ($total_penalty[$a] < $total_penalty[$b]) ? -1 : 1;
		}
	}
	else {
		return ($total_scored[$a] > $total_scored[$b]) ? -1 : 1;
	}
}
usort($Contestant, "cmp");
?>