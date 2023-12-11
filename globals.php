<?php

session_start();

// echo '<pre>';
// var_dump($_SERVER);
// die();

$BASE_URL = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']. '?') . '/';