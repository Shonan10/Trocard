<?php
include __DIR__ . '/inc/init.inc.php';

$query = 'SELECT * FROM membre WHERE id_membre = ' . (int)$_GET['id'];
$stmt = $pdo->query($query);
$membres = $stmt->fetch();

/*if (false === $membre) {
  header('HTTP/1.1 404 Not Found');
  die("La page n'existe pas");
}*/

include __DIR__ . '/layout/header.inc.php';
?>

<div class="container site">
    <h1 class="text-logo"><span class="glyphicon glyphicon-wrench"></span> Mon profil <span class="glyphicon glyphicon-user"></span></h1>
</div>

<div class="container view2">
	<div class="row">
		<div class="col-md-4">
			<form>
				<div class="form-group">
					<label>Pseudo : <?= $membre['pseudo']; ?></label>
				</div><br>
				<div class="form-group">
					<label>Nom : <?= $membre['nom']; ?></label>
				</div><br>
				<div class="form-group">
					<label>Prénom : <?= $membre['prenom']; ?></label>
				</div><br>
				<div class="form-group">
					<label>Email : <?= $membre['email']; ?></label>
				</div><br>
				<div class="form-group">
					<label>Téléphone : <?= $membre['telephone']; ?></label>
				</div><br>
			</form>
		</div>
	</div>
</div>

<?php
include __DIR__ . '/layout/footer.inc.php';
?>