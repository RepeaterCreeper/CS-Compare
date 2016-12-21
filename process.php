<?php
	session_start();

	if (isset($_POST["name1"]) && (isset($_POST['name2']))) {
		$_SESSION["p1"] = $_POST['name1'];
		$_SESSION["p2"] = $_POST['name2'];
	}

	if (isset($_GET['data'])) {
		if (isset($_POST['p1Times']) && (isset($_POST["p2Times"]))) {
			//$_SESSION["p1_times"] = $_POST['p1Times'];
			//$_SESSION["p2_times"] = $_POST["p2Times"];

			$yWin = 0;
			$eWin = 0;

			if (isset($_POST['p1Times'])) {
			    foreach (explode("\n", trim($_POST['p1Times'])) as $time) {
			        $yourTimeTot[] = explode(',', $time);
			    }
			    foreach (explode("\n", trim($_POST['p2Times'])) as $time) {
			        $enemyTimeTot[] = explode(',', $time);
			    }
			    for ($j = 0, $count = count($yourTimeTot); $j < $count; $j++) {
				    $delta =
				      str_replace(":", "", substr($yourTimeTot[$j][1], 6))
				      - str_replace(":", "", substr($enemyTimeTot[$j][1], 6));
				    if ($delta < 0) {
				        $winner = "{$_SESSION['p1']}";
				        $yWin += 1;
				    } else {
				        $winner = "{$_SESSION['p2']}";
				        $eWin += 1;
				    }

					$logResults[] = "[" . $yourTimeTot[$j][0] . "] " . $winner . ' has a faster time by ' . implode(':', str_split(str_pad(abs($delta), 6, '0', STR_PAD_LEFT), 2)) . ".\r";
				}
				$datas = [$logResults, ["yWin" => $yWin, "eWin" => $eWin]];
				print_r(json_encode($datas));
			}
		}
	}

	if (isset($_GET["clear"])) {
		session_destroy();
	}
?>