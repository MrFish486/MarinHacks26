<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["i"])) {
	$q = json_decode(file_get_contents("../data/record.json"), true);
	$i = intval($_GET["i"]);
	unset($q["msg"][$i]);
	$q["msg"] = array_values($q["msg"]);
	file_put_contents("../data/record.json", json_encode($q));
	header("Location: /home.php");
	exit;
}

?>
