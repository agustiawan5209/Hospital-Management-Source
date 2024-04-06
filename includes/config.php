<?php

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
define("BASE_URL", $base_url . "/");

$basename = basename($_SERVER["REQUEST_URI"]);
define("basename", $basename);