#!/bin/bash
# Copyright (C) 2026 Laszlo Pav and Oskar Pav
# 
# Setup script for *Hemlock*

mkdir data

echo '{"msg":[]}' > data/record.json
echo '{"adr":[]}' > data/adbook.json

open http://localhost:8080/index.php

{
	cd webprompt_ui
	php -S localhost:8080
}

julia setup.jl


# End.
