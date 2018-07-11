<?php
include __DIR__ . '/inc/init.inc.php';

unset($_SESSION['utilisateur']);

// $_SERVER['HTTP_REFERER'] : la page de laquelle on vient
/*$redirect = (!empty($_SERVER['HTTP_REFERER']))
	? $_SERVER['HTTP_REFERER']
	: 'index.php'
;*/

header('Location: index.php');
die;