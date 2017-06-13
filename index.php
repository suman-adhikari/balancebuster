<?php

session_start();

$url = isset($_GET['url'])?$_GET['url']:"";
include_once("conf/config.php");
require_once("conf/bootstrap.php");