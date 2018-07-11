<?php
include __DIR__ . '/inc/init.inc.php';

$errors = [];
$civilite = $nom = $prenom = $email = $pseudo = $telephone = '';

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  if (empty($_POST['civilite'])) {
    $errors[] = 'La civilité est obligatoire';
  }

  if (empty($_POST['nom'])) {
    $errors[] = 'Le nom est obligatoire';
  }

  if (empty($_POST['prenom'])) {
    $errors[] = 'Le prénom est obligatoire';
  }

  if (empty($_POST['email'])) {
    $errors[] = "L'email est obligatoire";
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email n'est pas valide";
  } else {
    $query = 'SELECT count(*) FROM membre WHERE email = ' . $pdo->quote($_POST['email']);
    $stmt = $pdo->query($query);
    $nb = $stmt->fetchColumn();

    if ($nb != 0) {
      $errors[] = 'Cet email existe déjà';
    }
  }

  if (empty($_POST['pseudo'])) {
    $errors[] = 'Le pseudo est obligatoire';
  } elseif (strlen($_POST['pseudo']) > 20) {
    $errors[] = 'Le pseudo ne doit pas faire plus de 20 caractères';
  } else {
    $query = 'SELECT count(*) FROM membre WHERE pseudo = ' . $pdo->quote($_POST['pseudo']);
    $stmt = $pdo->query($query);
    $nb = $stmt->fetchColumn();

    if ($nb != 0) {
      $errors[] = 'Ce pseudo existe déjà';
    }
  }

  if (empty($_POST['telephone'])) {
    $errors[] = 'Le telephone est obligatoire';
  } elseif (strlen($_POST['telephone']) != 10 || !ctype_digit($_POST['telephone'])) {
    $errors[] = 'Le telephone est invalide';
  }

  if (empty($_POST['mdp'])) {
    $errors[] = 'Le mot de passe est obligatoire';
  } elseif (!preg_match('/^[a-zA-Z0-9_-]{6,20}$/', $_POST['mdp'])) {
    $errors[] = 'Le mot de passe doit faire entre 6 et 20 caractères et ne contenir que des chiffres, des lettres, et les caractères _ et -';
  }

  if (empty($_POST['mdp_confirm'])) {
    $errors[] = 'La confirmation du mot de passe est obligatoire';
  } elseif ($_POST['mdp_confirm'] != $_POST['mdp']) {
    $errors[] = 'Le mot de passe et sa confirmation ne sont pas identiques';
  }

  if (empty($errors)) {
    $encodedPassword = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    $query = 'INSERT INTO membre (nom, prenom, email, pseudo, mdp, civilite, telephone)'
      . ' VALUES (:nom, :prenom, :email, :pseudo, :mdp, :civilite, :telephone)'
    ;
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':mdp', $encodedPassword);
    $stmt->bindValue(':civilite', $civilite);
    $stmt->bindValue(':telephone', $telephone);
    $stmt->execute();

    $success = true;
  }
}
include __DIR__ . '/layout/header.inc.php';
?>

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
    <strong>Votre compte est créé</strong>
  </div>
<?php
endif;
?>
<div class="container">
  <div class="row">
   <h1>Créer un compte</h1>
      <form method="post">
        <div class="form-group">
          <label class="control-label">Civilité</label>
          <select name="civilite" class="form-control" required>
            <option value="">Choisissez...</option>
            <option value="f" <?php if ($civilite == 'f'){echo 'selected';} ?>>Madame</option>
            <option value="h" <?php if ($civilite == 'h'){echo 'selected';} ?>>Monsieur</option>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label">Nom</label>
          <input type="text" name="nom" class="form-control" value="<?= $nom; ?>" required>
        </div>
        <div class="form-group">
          <label class="control-label">Prénom</label>
          <input type="text" name="prenom" class="form-control"value="<?= $prenom; ?>" required>
        </div>
        <div class="form-group">
          <label class="control-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= $email; ?>" required>
        </div>
         <div class="form-group">
          <label class="control-label">Numèro de téléphone</label>
          <input type="text" name="telephone" class="form-control" value="<?= $telephone ?>" required>
        </div>
        <div class="form-group">
          <label class="control-label">Pseudo</label>
          <input type="text" name="pseudo" class="form-control" value="<?= $pseudo; ?>" required>
        </div>
        <div class="form-group">
          <label class="control-label">Mot de passe</label>
          <input type="password" name="mdp" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Confirmation du mot de passe</label>
          <input type="password" name="mdp_confirm" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
      </form>
  </div>
</div>

<?php
include __DIR__ . '/layout/footer.inc.php';
?>