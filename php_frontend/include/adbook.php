<?php


function adbook_lookup ($address) {
	$adbook = json_decode(file_get_contents("../data/adbook.json"), true);
	if (isset($adbook["adr"][$address])) return $adbook["adr"][$address];
	return $address;
}

function adbook_add ($address, $name) {
	$adbook = json_decode(file_get_contents("../data/adbook.json"), true);
	$adbook["adr"][$address] = $name;
	file_put_contents("../data/adbook.json", json_encode($adbook));
}

function adbook_list () {
	$adbook = json_decode(file_get_contents("../data/adbook.json"), true);
	return $adbook["adr"];
}

?>
