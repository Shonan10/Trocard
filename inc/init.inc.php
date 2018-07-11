<?php
session_start();

define('RACINE_WEB', '/');
define('PHOTO_DIR', $_SERVER['DOCUMENT_ROOT'] . '/photo/');
define('PHOTO_WEB', RACINE_WEB . 'photo/');
define('PHOTO_DEFAULT', 'https://dummyimage.com/200x200/cccccc/ffffff&text=Pas+d\'image');
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/fonctions.inc.php';
