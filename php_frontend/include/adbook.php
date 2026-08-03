<?php


function adbook_lookup ($address) {
	$adbook = json_decode(file_get_contents("../data/adbook.json"), true);
	if (isset($adbook["adr"][$address])) return $adbook["adr"][$address];
	return $address;
}

?>
