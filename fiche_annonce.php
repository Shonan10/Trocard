<?php
include __DIR__ . '/inc/init.inc.php';

$query = 'SELECT * FROM annonce WHERE id_annonce = ' . (int)$_GET['id'];
$stmt = $pdo->query($query);
$annonce = $stmt->fetch();

if (false === $annonce) {
  header('HTTP/1.1 404 Not Found');
  die("La page n'existe pas");
}

$src = (!empty($annonce['photo']))
  ? PHOTO_WEB . $annonce['photo']
  : PHOTO_DEFAULT
  ;

include __DIR__ . '/layout/header.inc.php';
?>

<div class="container site">
    <h1 class="text-logo"><span class="glyphicon glyphicon-earphone"></span> Détails du troc <span class="glyphicon glyphicon-user"></span></h1>
</div>

<div class="container view">
	<div class="row">
		<div class="col-sm-6">
			<form class="text-center">
				<div class="form-group">
					<label><?= $annonce['titre']; ?></label>
				</div>
				<div class="form-group">
					<label><?= $annonce['description_longue']; ?></label>
				</div><br>
				<div class="form-group">
					<label>Adresse : <?= $annonce['adresse']; ?></label>
				</div>
				<div class="form-group">
					<label><?= $annonce['ville']; ?> - <?= $annonce['cp']; ?></label>
				</div>
				<div class="form-group betsu">
					<label><?= $annonce['prix'] . ' €'; ?></label>
				</div>
			</form><br>
			<div class="form-actions">
				<a class="btn btn-primary btn-lg" href="annonces.php"><span class="glyphicon glyphicon-circle-arrow-left"> </span> Retour aux Trocs</a>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="thumbnail">
				<a href="<?= $src; ?>" target="_blank"><img src="<?= $src; ?>" alt="photo"></a>
			</div><br>
			<div class="form-group">
				<label>Contacter le vendeur : </label>
			</div>
		</div>
	</div>
</div>

<?php
include __DIR__ . '/layout/footer.inc.php';
?>