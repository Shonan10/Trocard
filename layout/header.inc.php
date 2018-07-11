<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trocard | No 1 d'échange entre particuliers</title>
    <link rel="icon" type="image/x-icon" href="../img/shake-hands2.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
  	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Shadows+Into+Light" rel="stylesheet">
  	<link rel="stylesheet" href="/css/style.css">
  </head>
  
  <body>
    <?php
    if (isUserAdmin()) :
    ?>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <a class="navbar-brand"> <span class="glyphicon glyphicon-king"></span> Admin <span class="glyphicon glyphicon-queen"></a>
        <ul class="nav navbar-nav">
          <li><a href="<?= RACINE_WEB ?>admin/gestion_annonces.php">Gestion Annonces</a></li>
          <li><a href="<?= RACINE_WEB ?>admin/gestion_categories.php">Gestion Categories</a></li>
          <li><a href="<?= RACINE_WEB ?>admin/gestion_membres.php">Gestion Membres</a></li>
          <li><a href="<?= RACINE_WEB ?>admin/gestion_commentaires.php">Gestion Commentaires</a></li>
          <li><a href="<?= RACINE_WEB ?>admin/gestion_notes.php">Gestion Notes</a></li>
          <li><a href="<?= RACINE_WEB ?>admin/gestion_statistiques.php">Gestion Statistiques</a></li>
        </ul>
      </div>
    </nav>
    <?php
    endif;
    ?>
    <nav class="navbar navbar-default site">
      <div class="container">
       <div class="row">
        <a class="navbar-brand" href="<?= RACINE_WEB ?>index.php"><span class="glyphicon glyphicon-thumbs-up"></span> TroCard </a>
          <ul class="nav navbar-nav navbar-right">
            <?php
            if (isUserConnected()) :
            ?>
              <li><a href="<?= RACINE_WEB ?>profil.php"><?= getUserFullName(); ?></a></li>
              <li><a href="<?= RACINE_WEB ?>ajouter_annonce.php">Déposer une annonce</a></li>
              <li><a href="<?= RACINE_WEB ?>annonces.php">Voir tous les Trocs</a></li>
              <li><a href="<?= RACINE_WEB ?>deconnexion.php">Déconnexion</a></li>
            <?php
            else :
            ?>
              <li><a href="<?= RACINE_WEB ?>connexion.php"> <span class="glyphicon glyphicon-hand-right"></span> Se connecter </a></li>
              <li><a href="<?= RACINE_WEB ?>inscription.php">S'inscrire</a></li>
            <?php
            endif;
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <main>
      <div class="container">