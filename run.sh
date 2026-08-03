#!/bin/bash

PHP="/opt/local/bin/php83"

open http://localhost:8080/index.php

{
	cd php_frontend
	$PHP -S localhost:8080
} &
