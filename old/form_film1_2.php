<pre>
<?php
//include package composer
require_once 'vendor/autoload.php';






$dsn = 'mysql:dbname=gcif;host=localhost;charset=UTF8';
$user = 'root';
$password = 'toor';

// Effectuer la connexion
$pdo = new PDO($dsn, $user, $password);
require 'inc/fonctions.php';

// outputed values
$currentId = 0;
$cat_id = 0;
$sup_id = 0;
$fil_titre = '';
$fil_annee = '';
$fil_synopsis = '';
$fil_description = '';
$fil_acteurs = '';
$fil_filename = '';
$fil_affiche = '';

//SEARCH BAR************************************

if (isset($_POST['search'])) {
	print_r($_POST);
	$movie=\Jleagle\Imdb\Imdb::retrieve($_POST['search']);
	print_r($movie);
	$fil_titre=$movie->title;
	$fil_synopsis=$movie->plot;
	$fil_acteurs=$movie->actors;
	$fil_affiche=$movie->poster;
	$fil_annee=$movie->year;
}




if (!empty($_POST['fil_titre'])) {
	//print_pre($_POST);
	$fil_id = isset($_POST['fil_id']) ? intval(trim($_POST['fil_id'])) : 0;
	$cat_id = isset($_POST['cat_id']) ? intval(trim($_POST['cat_id'])) : 0;
	$sup_id = isset($_POST['sup_id']) ? intval(trim($_POST['sup_id'])) : 0;
	$fil_titre = isset($_POST['fil_titre']) ? trim($_POST['fil_titre']) : '';
	$fil_annee = isset($_POST['fil_annee']) ? trim($_POST['fil_annee']) : 0;
	$fil_synopsis = isset($_POST['fil_synopsis']) ? trim($_POST['fil_synopsis']) : '';
	$fil_description = isset($_POST['fil_description']) ? trim($_POST['fil_description']) : '';
	$fil_acteurs = isset($_POST['fil_acteurs']) ? trim($_POST['fil_acteurs']) : '';
	$fil_filename = isset($_POST['fil_filename']) ? trim($_POST['fil_filename']) : '';
	$fil_affiche = isset($_POST['fil_affiche']) ? trim($_POST['fil_affiche']) : '';

	// update
	if ($fil_id > 0) {
		$updateSQL = '
			UPDATE film
			SET fil_titre = :titre,
			fil_annee = :annee,
			fil_synopsis = :synopsis,
			fil_description = :description,
			fil_acteurs = :acteurs,
			fil_filename = :filename,
			fil_affiche = :affiche,
			cat_id = :cat_id,
			sup_id = :sup_id
			WHERE fil_id = :fil_id
		';
		$pdoStatement = $pdo->prepare($updateSQL);
		$pdoStatement->bindValue(':titre', $fil_titre);
		$pdoStatement->bindValue(':annee', $fil_annee);
		$pdoStatement->bindValue(':synopsis', $fil_synopsis);
		$pdoStatement->bindValue(':description', $fil_description);
		$pdoStatement->bindValue(':acteurs', $fil_acteurs);
		$pdoStatement->bindValue(':filename', $fil_filename);
		$pdoStatement->bindValue(':affiche', $fil_affiche);
		$pdoStatement->bindValue(':fil_id', $fil_id);
		$pdoStatement->bindValue(':cat_id', $cat_id);
		$pdoStatement->bindValue(':sup_id', $sup_id);

		if ($pdoStatement->execute()) {
			header('Location: form_film.php?id='.$fil_id);
			exit;
		}
	}
	else {
		$insertInto = '
			INSERT INTO film (fil_titre, fil_annee, fil_synopsis, fil_description, fil_acteurs, fil_filename, fil_affiche,cat_id,sup_id)
			VALUES (:titre, :annee, :synopsis, :description, :acteurs, :filename, :affiche, :cat_id, :sup_id)
		';
		$pdoStatement = $pdo->prepare($insertInto);
		$pdoStatement->bindValue(':titre', $fil_titre);
		$pdoStatement->bindValue(':annee', $fil_annee);
		$pdoStatement->bindValue(':synopsis', $fil_synopsis);
		$pdoStatement->bindValue(':description', $fil_description);
		$pdoStatement->bindValue(':acteurs', $fil_acteurs);
		$pdoStatement->bindValue(':filename', $fil_filename);
		$pdoStatement->bindValue(':affiche', $fil_affiche);
		$pdoStatement->bindValue(':cat_id', $cat_id);
		$pdoStatement->bindValue(':sup_id', $sup_id);

		if ($pdoStatement->execute()) {
			$newId = $pdo->lastInsertId();
			header('Location: form_film.php?id='.$newId);
			exit;
		}
	}
}



if (isset($_GET['id'])) {
	$currentId = intval($_GET['id']);

	$sql = 'SELECT cat_id, sup_id, fil_titre, fil_annee, fil_synopsis, fil_description, fil_acteurs, fil_filename, fil_affiche
	FROM film
	WHERE fil_id = '.$currentId;
	$pdoStatement = $pdo->query($sql);
	if ($pdoStatement && $pdoStatement->rowCount() > 0) {
		$resList = $pdoStatement->fetch();

		foreach ($resList as $curIndex=>$curValue) {
			$$curIndex = $curValue;
		}
	}
}

// Récupère toutes les catégories pour générer le menu déroulant des catégories
$sql = '
	SELECT cat_id, cat_nom
	FROM categorie
';
$pdoStatement = $pdo->query($sql);
if ($pdoStatement && $pdoStatement->rowCount() > 0) {
	$categoriesList = $pdoStatement->fetchAll();
}
// Récupère tous les supports pour générer le menu déroulant des supports
$sql = '
	SELECT sup_id, sup_nom
	FROM support
';
$pdoStatement = $pdo->query($sql);
if ($pdoStatement && $pdoStatement->rowCount() > 0) {
	$supportsList = $pdoStatement->fetchAll();
}
?>
<html>
<head>
	<title>GCLF</title>
</head>
<body>
	<form action="" method="post">
		SEARCH MOVIE
		<input type="text" name="search" value="">
		<input type="submit" value="SEARCH">
		</form><br/>
		<legend>Gestion de film</legend>
		<form>
		<fieldset>
			<input type="hidden" name="fil_id" value="<?php echo $currentId; ?>" />
			<table>
			<tr>
				<td>Titre :&nbsp;</td>
				<td><input type="text" name="fil_titre" value="<?php echo $fil_titre; ?>"/></td>
			</tr>
			<tr>
				<td>Catégorie :&nbsp;</td>
				<td><select name="cat_id">
					<option value="">choisissez</option>
					<?php foreach ($categoriesList as $curCategorie) : ?>
					<option value="<?php echo $curCategorie['cat_id']; ?>"<?php echo $cat_id == $curCategorie['cat_id'] ? ' selected="selected"' : ''; ?>><?php echo $curCategorie['cat_nom']; ?></option>
					<?php endforeach; ?>
				</select></td>
			</tr>
			<tr>
				<td>Support :&nbsp;</td>
				<td><select name="sup_id">
					<option value="">choisissez</option>
					<?php foreach ($supportsList as $curSupport) : ?>
					<option value="<?php echo $curSupport['sup_id']; ?>"<?php echo $sup_id == $curSupport['sup_id'] ? ' selected="selected"' : ''; ?>><?php echo $curSupport['sup_nom']; ?></option>
					<?php endforeach; ?>
				</select></td>
			</tr>
			<tr>
				<td>Année :&nbsp;</td>
				<td><select name="fil_annee">
					<option value="">choisissez :</option>
					<?php for ($annee=date('Y');$annee>1970;$annee--) : ?>
					<option value="<?php echo $annee; ?>"<?php echo $fil_annee==$annee ? ' selected="selected"' : ''; ?>><?php echo $annee; ?></option>
					<?php endfor; ?>
				</select></td>	
			</tr>
			<tr>
				<td>Synopsis :&nbsp;</td>
				<td><textarea name="fil_synopsis" rows="5" cols="100"><?php echo $fil_synopsis; ?></textarea></td>
			</tr>
			<tr>
				<td>Description :&nbsp;</td>
				<td><textarea name="fil_description" rows="12" cols="100"><?php echo $fil_description; ?></textarea></td>
			</tr>
			<tr>
				<td>Acteur(s)/Actrice(s)&nbsp;:&nbsp;</td>
				<td><input type="text" name="fil_acteurs" value="<?php echo $fil_acteurs; ?>"/></td>
			</tr>
			<tr>
				<td>Fichier :&nbsp;</td>
				<td><input type="text" name="fil_filename" value="<?php echo $fil_filename; ?>"/></td>
			</tr>
			<tr>
				<td>Affiche :&nbsp;</td>
				<td><input type="text" name="fil_affiche" value="<?php echo $fil_affiche; ?>"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Valider"/></td>
			</tr>	
			</table>
		</fieldset>
	</form>	
</body>
</html>
</pre>