<?php

require_once __DIR__.'/boot.php';

$user = null;
$_SESSION['user'] = null;
header('Location: login.php');
die;
?>