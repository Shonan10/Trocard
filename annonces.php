<?php
include __DIR__ . '/inc/init.inc.php';


if (isset($_GET['categorie'])) {
	$query = 'SELECT titre FROM categorie WHERE id = ' . (int)$_GET['categorie'];
	$stmt = $pdo->query($query);
	$titre = $stmt->fetchColumn();

	if (false === $titre) {
		header('HTTP/1.1 404 Not Found');
		die("La page n'existe pas");
	}

	$query = 'SELECT * FROM annonce WHERE categorie_id = ' . (int)$_GET['categorie'];
} else {
	$titre = 'Tous les trocs';
	$query = 'SELECT * FROM annonce';
}

$stmt = $pdo->query($query);
$annonces = $stmt->fetchAll();

include __DIR__ . '/layout/header.inc.php';
?>

<div class="container site">
    <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span> Tous les Trocs ! <span class="glyphicon glyphicon-leaf"></span></h1>
</div>

<form>
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label">Catégorie</label>
				<select name="filtre-categorie" class="form-control">
					<option value="">Toutes les catégories</option>
					<option value=""></option>
				</select>
			</div>

			<div class="col-lg-4">
				<label class="control-label">Ville</label>
				<select name="filtre-ville" class="form-control">
					<option value="">Toutes les villes</option>
					<option value=""></option>
				</select>
			</div>

			<div class="col-lg-4">
				<label class="control-label">Membre</label>
				<select name="filtre-membre" class="form-control">
					<option value="">Tous les membres</option>
					<option value=""></option>
				</select>
			</div>
		</div><br>

		<div class="row">
			<div class="col-lg-8">
				<label class="control-label">Trier par</label>
				<select name="tri" class="form-control">
					<option value="ascendant">Du moins cher au plus cher</option>
					<option value="descendant">Du plus cher au moins cher</option>
				</select>
			</div>
			<div class="text">
				<button type="submit" name="recherche" class="col-xs-2 col-xs-offset-5 btn btn-primary" style="margin-left:18px; margin-top: 24px;">Lancer la recherche</button>
			</div>
		</div>
	</div>
</form><br>

<div class="container">
	<div class="row">
		
		<?php
		if (count($annonces) != 0) :
			foreach ($annonces as $annonce) :
				$src = (!empty($annonce['photo']))
					? PHOTO_WEB . $annonce['photo']
					: PHOTO_DEFAULT;
		?>
		<div class="col-sm-10 col-md-6">
			<div class="thumbnail">
				<a href="<?= $src; ?>" target="_blank"><img src="<?= $src; ?>" alt="photo"></a>
				<div class="price"><?= number_format($annonce['prix'], 2, ',', ' ') . ' €'; ?></div>
				<div class="caption">
					<h4><?= $annonce['titre']; ?></h4>
					<p><?= $annonce['description_courte']; ?></p>
					<p><?= $annonce['ville']; ?> - (<?= $annonce['cp']; ?>)</p>
					<a href="fiche_annonce.php?id=<?= $annonce['id_annonce']; ?>" class=" btn btn-order" role="button"><span class="glyphicon glyphicon-eye-open"> </span> Voir ce troc </a>
				</div>
			</div>
		</div>

		<?php
		endforeach;
		else :
			echo '<p class="thumbnail"><strong> Aucun Troc </strong></p>';
		endif;
		?>
	</div>
</div>


<?php
include __DIR__ . '/layout/footer.inc.php';
?>