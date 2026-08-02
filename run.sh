#!/bin/bash

open http://localhost:8080/index.php

{
	cd php_frontend
	PHP="/opt/local/bin/php83"
	$PHP -S localhost:8080
}
