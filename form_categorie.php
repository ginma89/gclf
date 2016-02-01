<?php

$dsn = 'mysql:dbname=gcif;host=localhost;charset=UTF8';
$user = 'root';
$password = 'totowf3';

// Effectuer la connexion
$pdo = new PDO($dsn, $user, $password);

// Gestion du POST du formulaire
if (!empty($_POST)) {
	$cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
	$cat_nom = isset($_POST['cat_nom']) ? trim($_POST['cat_nom']) : '';

	// Si modification
	if ($cat_id > 0) {
		$sql = '
			UPDATE categorie
			SET cat_nom = :nom,
			cat_updated = NOW()
			WHERE cat_id = :cat_id
		';
		$pdoStatement = $pdo->prepare($sql);
		$pdoStatement->bindValue(':nom', $cat_nom);
		$pdoStatement->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
	}
	// Sinon ajout
	else {
		$sql = '
			INSERT INTO categorie (cat_nom, cat_created, cat_updated)
			VALUES (:nom, NOW(),  NOW())
		';
		$pdoStatement = $pdo->prepare($sql);
		$pdoStatement->bindValue(':nom', $cat_nom);
	}
	// J'exécute ma requete (quelle soit insert ou update)
	if ($pdoStatement->execute()) {
		// Redirection après modif
		if ($cat_id > 0) {
			header('Location: ?id='.$cat_id);
			exit;
		}
		// Redirection après ajout
		else {
			// On va d'abord récupérer l'ID créé
			$cat_id = $pdo->lastInsertId();
			header('Location: ?id='.$cat_id);
			exit;
		}
	}
}

// J'initialise les variables affichés (echo) dans le form pour éviter les "NOTICE"
$currentId = 0;
$cat_nom = '';

// Récupère toutes les catégories pour générer le menu déroulant des catégories
$categoriesList=getAllCat();

// Si l'id est passé en paramètre => je pré-remplis le formulaire pour la modification
if (isset($_GET['id'])) {
	$currentId = intval($_GET['id']);

	$sql = '
		SELECT cat_id, cat_nom
		FROM categorie
		WHERE cat_id = :cat_id
		LIMIT 1
	';
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':cat_id', $currentId, PDO::PARAM_INT);
	if ($pdoStatement->execute()) {
		$resList = $pdoStatement->fetch();
		$cat_nom = $resList['cat_nom'];
	}
}
require 'inc/header.php';
?>

	<section class="subHeader">
		<h1>Gestion des catégories</h1>
		<!-- je mets ce formulaire en method="get" car la donnée n'est pas à sécuriser
		et car on veut voir ?id=ID dans l'URL de la page pour la modification -->
		<form action="" method="get">
			<select name="id">
				<option value="0">ajouter une catégorie</option>
				<!-- je parcours les catégories pour remplir le menu déroulant des catégories -->
				<?php foreach ($categoriesList as $curCategorie) : ?>
				<option value="<?php echo $curCategorie['cat_id']; ?>"<?php echo $currentId == $curCategorie['cat_id'] ? ' selected="selected"' : ''; ?>><?php echo $curCategorie['cat_nom']; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="submit" value="OK"/>
		</form>
	</section>
	<form action="" method="post">
		<legend></legend>
		<fieldset>
			<input type="hidden" name="cat_id" value="<?php echo $currentId; ?>" />
			<table>
			<tr>
				<td>Nom :&nbsp;</td>
				<td><input type="text" name="cat_nom" value="<?php echo $cat_nom; ?>"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Valider"/></td>
			</tr>	
			</table>
		</fieldset>
	</form>	
<?php require 'inc/footer.html' ?>