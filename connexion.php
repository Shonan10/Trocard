<?php
include __DIR__ . '/inc/init.inc.php';

$errors = [];
$identifiant = '';

if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	if (empty($_POST['identifiant'])) {
		$errors[] = "L'identifiant est obligatoire";
	}

	if (empty($_POST['mdp'])) {
		$errors[] = 'Le mot de passe est obligatoire';
	}

	if (empty($errors)) {
		$query = 'SELECT * FROM membre WHERE email = :identifiant OR pseudo = :identifiant';
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(':identifiant', $_POST['identifiant']);
		$stmt->execute();

		$utilisateur = $stmt->fetch();

		if (!empty($utilisateur)) { 
			if (password_verify($_POST['mdp'], $utilisateur['mdp'])) {
				
				unset($utilisateur['mdp']);
				$_SESSION['utilisateur'] = $utilisateur;

				header('Location: index.php');
				die;
			}
		}

		$errors[] = 'Identifiant ou mot de passe incorrect';
	}
}

include __DIR__ . '/layout/header.inc.php';
?>
<div class="container">
  <div class="row">
    <h1>Connexion</h1>

<?php
if (!empty($errors)) :
?>
	<div class="alert alert-danger">
		<strong>Le formulaire contient des erreurs</strong>
		<br>
		<?= implode('<br>', $errors); ?>
	</div>
<?php
endif;
?>

	<form method="post">
		<div class="form-group">
			<label class="control-label">Pseudo ou email</label>
			<input type="text" name="identifiant" class="form-control" value="<?= $identifiant; ?>" required>
		</div>
			<div class="form-group">
			<label class="control-label">Mot de passe</label>
			<input type="password" name="mdp" class="form-control" required>
		</div>
		<button type="submit" class="btn btn-primary">Valider</button>
	</form>
  </div>	
</div>

<?php
include __DIR__ . '/layout/footer.inc.php';
?>