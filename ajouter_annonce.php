<?php
include __DIR__ . '/inc/init.inc.php';


// select de catégorie
$stmt = $pdo->query('SELECT * FROM categorie');
$categories = $stmt->fetchAll();

$errors = [];
$titre = $descriptionCourte = $descriptionLongue = $prix = $categorieId = $adresse = $ville = $cp = $photo = '';


if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	$categorieId = $_POST['categorie'];

	if (empty($_POST['titre'])) {
		$errors[] = 'Le titre est obligatoire';
	}

	if (empty($_POST['descriptionCourte'])) {
		$errors[] = 'La description courte est obligatoire';
	}

	if (empty($_POST['descriptionLongue'])) {
		$errors[] = 'La description longue est obligatoire';
	}

	if (empty($_POST['prix'])) {
		$errors[] = 'Le prix est obligatoire';
	} elseif (!is_numeric($prix)) {
		$errors[] = "Le prix n'est pas un nombre";
	}

	if (empty($_POST['categorie'])) {
		$errors[] = 'La catégorie est obligatoire';
	}

	if (empty($_POST['adresse'])) {
		$errors[] = 'L\'adresse est obligatoire';
	}

	if (empty($_POST['ville'])) {
		$errors[] = 'La ville est obligatoire';
	}

	if (empty($_POST['cp'])) {
    $errors[] = 'Le code postal est obligatoire';
  		} elseif (strlen($_POST['cp']) != 5 || !ctype_digit($_POST['cp'])) {
    	$errors[] = 'Le code postal est invalide';
  	}

	if (!empty($_FILES['photo']['tmp_name'])) {
		if ($_FILES['photo']['size'] > 1000000) {
			$errors[] = 'La photo ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = [
			'image/jpeg',
			'image/gif',
			'image/png'
		];

		if (!in_array($_FILES['photo']['type'], $allowedMimeTypes)) {
			$errors[] = 'La photo doit être une image JPG, GIF, ou PNG';
		}
	}

	if (empty($errors)) {
		if (!empty($_FILES['photo']['tmp_name'])) {
			// on retrouve l'extension du fichier à partir de son nom d'origine (ex: .jpg pour pull-vert.jpg)
			$extension = substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'], '.'));
			// on définit le nom du fichier qu'on va enregistrer à partir de la référence et de l'extension
			$nomPhoto = $_POST['titre'] . $extension;
			// on enregistre le fichier dans le répertoire photo
			move_uploaded_file($_FILES['photo']['tmp_name'], PHOTO_DIR . $nomPhoto);
		} else {
			$nomPhoto = $photoActuelle;
		}

			$query = 'INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, ville, adresse, cp, categorie_id )' . ' VALUES (:titre, :description_courte, :description_longue, :prix, :photo, :ville, :adresse, :cp, :categorie_id )'
			;
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':titre', $titre);
			$stmt->bindValue(':description_courte', $descriptionCourte);
			$stmt->bindValue(':description_longue', $descriptionLongue);
			$stmt->bindValue(':prix', $prix);
			$stmt->bindValue(':photo', $nomPhoto);
			$stmt->bindValue(':ville', $ville);
			$stmt->bindValue(':adresse', $adresse);
			$stmt->bindValue(':cp', $cp);
			$stmt->bindValue(':categorie_id',$categorieId);
			$stmt->execute();

			$success = true;
		}

	}

include __DIR__ . '/layout/header.inc.php';
?>

<h1>Ajouter une annonce</h1>

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
if (!empty($success)) :
?>
  <div class="alert alert-success">
    <strong>Votre annonce est créé</strong>
  </div>
<?php
endif;
?>

<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label">Titre</label>
		<input type="text" name="titre" class="form-control" value="<?= $titre; ?>" required>
	</div>
	<div class="form-group">
		<label class="control-label">Description courte</label>
		<input type="text" name="descriptionCourte" class="form-control" value="<?= $descriptionCourte; ?>" required>
	</div>
	<div class="form-group">
		<label class="control-label">Description longue</label>
		<textarea name="descriptionLongue" class="form-control" value="<?= $descriptionLongue; ?>" required></textarea>
	</div>
	<div class="form-group">
		<label class="control-label">Prix</label>
		<input type="text" name="prix" class="form-control" value="<?= $prix; ?>" required>
	</div>
		<div class="form-group">
		<label class="control-label">Catégorie</label>
		<select name="categorie" class="form-control">
			<option value=""></option>
			<?php
			foreach ($categories as $categorie) :
			?>
			<option value="<?= $categorie['id']; ?>" <?php if ($categorieId == $categorie['id']){echo 'selected';} ?>>
			<?= $categorie['titre']; ?>
			</option>
			<?php
			endforeach;
			?>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">Photo principale</label>
		<input type="file" name="photo">
	</div>
	<?php
	if (!empty($photoActuelle)) :
		echo '<p><img src="' . PHOTO_WEB . $photoActuelle . '"></p>';
	endif;
	?>
	<input type="hidden" name="photoActuelle" value="<?= $photoActuelle; ?>">

    <div class="form-group">
        <label class="control-label">Adresse</label>
        <input type="text" name="adresse" class="form-control" value="<?= $adresse ?>" required>
    </div>
	<div class="form-group">
        <label class="control-label">Ville</label>
        <input type="text" name="ville" class="form-control" value="<?= $ville ?>" required>
    </div>
    <div class="form-group">
        <label class="control-label">Code Postal</label>
        <input type="text" name="cp" class="form-control" value="<?= $cp ?>" required>
    </div>

	<button type="submit" class="btn btn-primary">Valider</button>
	<a class="btn btn-default" href="ajouter_annonce.php">Retour</a>
</form>

<?php
include __DIR__ . '/layout/footer.inc.php';
?>
