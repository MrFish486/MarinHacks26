<?php

$sock = socket_create(AF_INET, SOCK_DGRAM, 0);

$make_sure_socket_is_configured = $sock;

$make_sure_socket_is_configured or DIE("Uh oh bad sock!");

socket_bind(


?>
