<?php
function sanitizeValue(&$value)
{
	$value = trim(strip_tags($value));
}

function sanitizeArray(array &$array)
{
	array_walk($array, 'sanitizeValue');
}

function sanitizePost()
{
	sanitizeArray($_POST);
}

function isUserConnected()
{
	return isset($_SESSION['utilisateur']);
}

function getUserFullName()
{
	if (isUserConnected()) {
		return $_SESSION['utilisateur']['prenom']
			. ' ' . $_SESSION['utilisateur']['nom']
		;
	}

	return '';
}

function isUserAdmin()
{
	return isUserConnected() && $_SESSION['utilisateur']['statut'] == 1;
}

function adminSecurity()
{
	if (!isUserAdmin()) {
		if (!isUserConnected()) {
			header('Location: ' . RACINE_WEB . 'connexion.php');
		} else {
			header('HTTP/1.0 403 Forbidden');
			echo "Vous n'avez pas le droit d'accéder à cette page";
			//header('Location: ' . RACINE_WEB . 'index.php');
		}

		die;
	}
}

function setFlashMessage($message, $type = 'success')
{
	$_SESSION['flashMessage'] = [
		'message' => $message,
		'type' => $type
	];
}

function displayFlashMessage()
{
	if (isset($_SESSION['flashMessage'])) {
		$message = $_SESSION['flashMessage']['message'];
		$type = ($_SESSION['flashMessage']['type'] == 'error')
			? 'danger'
			: $_SESSION['flashMessage']['type']
		;

		echo '<div class="alert alert-' . $type . '">'
			. '<strong>' . $message . '</strong>'
			. '</div>'
		;

		unset($_SESSION['flashMessage']);
	}
}