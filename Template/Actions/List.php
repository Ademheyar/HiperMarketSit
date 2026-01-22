<?php
function loadList($text) {
	$ret = [];
	$rv = '';
	$rl = [];
	$v = [];
	$i = 0;
	while ($i < strlen($text)) {
		if ($text[$i] === '\'' || $text[$i] === '\"') {
			$i++;
			if ($rv === "") {
				$rv = " ";
			}
			continue;
		}
		if ($text[$i] === "[") {
			$i++;
			if ($rv === " ") {
				$rv = "";
			}
			list($i, $v) = subList($text, $i);
			$rl[] = $v;
			continue;
		}
		if ($text[$i] === "]") {
			if (isset($text[$i + 1]) && ($text[$i + 1] === "]" || $text[$i + 1] === ",")) {
				if ($rv !== "") {
					$rl[] = $rv;
					$rv = " ";
				}
				$i++;
				return [$i, $rl];
			}
			$i++;
			continue;
		}
		if ($text[$i] === ",") {
			if ($rv !== "") {
				$rl[] = $rv;
			}
			$i++;
			$rv = "";
			continue;
		}
		if ($rv !== "" && (isset($text[$i + 1]) && ($text[$i + 1] === "," || $text[$i + 1] === "]"))) {
			$rv .= $text[$i];
			$rl[] = $rv;
			$i++;
			$rv = "";
			if (isset($text[$i + 1]) && $text[$i + 1] === "]") {
				return [$i, $rl];
			}
		} else {
			if ($rv === " ") {
				$rv = "";
			}
			$rv .= $text[$i];
			$i++;
		}
	}
	return [0, $rl];
}

function subList($t, $i) {
	$rv = "";
	$rl = [];
	$v = [];
	while ($i < strlen($t)) {
		if ($t[$i] === '\'' || $t[$i] === '\"') {
			$i++;
			if ($rv === "") {
				$rv = " ";
			}
			continue;
		}
		if ($t[$i] === "[") {
			$i++;
			if ($rv === " ") {
				$rv = "";
			}
			list($i, $v) = subList($t, $i);
			$rl[] = $v;
			continue;
		}
		if ($t[$i] === "]") {
			if (isset($t[$i + 1]) && ($t[$i + 1] === "]" || $t[$i + 1] === ",")) {
				if ($rv !== "") {
					$rl[] = $rv;
					$rv = " ";
				}
				$i++;
				return [$i, $rl];
			}
			$i++;
			continue;
		}
		if ($t[$i] === ",") {
			if ($rv !== "") {
				$rl[] = $rv;
			}
			$i++;
			$rv = "";
			continue;
		}
		if ($rv !== "" && (isset($t[$i + 1]) && ($t[$i + 1] === "," || $t[$i + 1] === "]"))) {
			$rv .= $t[$i];
			$rl[] = $rv;
			$i++;
			$rv = "";
			if (isset($t[$i + 1]) && $t[$i + 1] === "]") {
				return [$i, $rl];
			}
		} else {
			if ($rv === " ") {
				$rv = "";
			}
			$rv .= $t[$i];
			$i++;
		}
	}
	return [$i, $rl];
}
?>