<?php

require 'inc/config.php';


//require 'inc/fonctions.php';

// Si un formulaire a été soumis
// Attention, si plusieurs formulaires en POST sur la même page, il va falloir les distinguer
if (!empty($_POST)) {
	//print_pre($_POST);
	// Récupération et traitement des variables du formulaire d'ajout/modification
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

	// si l'id dans le formulaire est > 0 => film existant => modification
	if ($fil_id > 0) {
		// J'écris ma requête dans une variable
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
			sup_id = :sup_id,
			fil_updated = NOW()
			WHERE fil_id = :fil_id
		';
		// Je prépare ma requête
		$pdoStatement = $pdo->prepare($updateSQL);
		// Je bind toutes les variables de requête
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

		// J'exécute la requête, et ça me renvoi true ou false
		if ($pdoStatement->execute()) {
			// Je redirige sur la même page
			// Pas de formulaire soumis sur la page de redirection => pas de POST
			header('Location: form_film.php?id='.$fil_id);
			exit;
		}
	}
	// Sinon Ajout
	else {
		// J'écris ma requête dans une variable
		$insertInto = '
			INSERT INTO film (fil_titre, fil_annee, fil_synopsis, fil_description, fil_acteurs, fil_filename, fil_affiche,cat_id,sup_id,fil_updated,fil_created)
			VALUES (:titre, :annee, :synopsis, :description, :acteurs, :filename, :affiche, :cat_id, :sup_id, NOW(), NOW())
		';
		// Je prépare ma requête
		$pdoStatement = $pdo->prepare($insertInto);
		// Je bind toutes les variables de requête
		$pdoStatement->bindValue(':titre', $fil_titre);
		$pdoStatement->bindValue(':annee', $fil_annee);
		$pdoStatement->bindValue(':synopsis', $fil_synopsis);
		$pdoStatement->bindValue(':description', $fil_description);
		$pdoStatement->bindValue(':acteurs', $fil_acteurs);
		$pdoStatement->bindValue(':filename', $fil_filename);
		$pdoStatement->bindValue(':affiche', $fil_affiche);
		$pdoStatement->bindValue(':cat_id', $cat_id);
		$pdoStatement->bindValue(':sup_id', $sup_id);

		// J'exécute la requête, et ça me renvoi true ou false
		if ($pdoStatement->execute()) {
			$newId = $pdo->lastInsertId();
			// Je redirige sur la même page, à laquelle j'ajoute l'id du film créé => modification
			// Pas de formulaire soumis sur la page de redirection => pas de POST
			header('Location: form_film.php?id='.$newId);
			exit;
		}
	}
}

// J'initialise mes variables pour l'affichage du formulaire/de la page
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
$imdb = '';
$imdbCategory = '';
$imdbResultsList = array();
$noImdbResult = false;

// Si l'id est passé en paramètre de l'URL : "form_film.php?id=54" => $_GET['id'] à pour valeur 54
if (isset($_GET['id'])) {
	// Je m'assure que la valeur est un integer
	$currentId = intval($_GET['id']);

	// J'écris ma requête dans une variable
	$sql = 'SELECT cat_id, sup_id, fil_titre, fil_annee, fil_synopsis, fil_description, fil_acteurs, fil_filename, fil_affiche
	FROM film
	WHERE fil_id = '.$currentId;
	// J'envoi ma requête à MySQL et je récupère le Statement
	$pdoStatement = $pdo->query($sql);
	// Si la requête a fonctionnée et qu'on a au moins une ligne de résultat
	if ($pdoStatement && $pdoStatement->rowCount() > 0) {
		// Je "fetch" les données de la première ligne de résultat dans $resList
		$resList = $pdoStatement->fetch();

		// Je récupère toutes les valeurs que j'affecte dans les variables destinées à l'affichage du formulaire
		// => ça me permet de pré-remplir le formulaire
		$cat_id = intval($resList['cat_id']);
		$sup_id = intval($resList['sup_id']);
		$fil_titre = $resList['fil_titre'];
		$fil_annee = $resList['fil_annee'];
		$fil_synopsis = $resList['fil_synopsis'];
		$fil_description = $resList['fil_description'];
		$fil_acteurs = $resList['fil_acteurs'];
		$fil_filename = $resList['fil_filename'];
		$fil_affiche = $resList['fil_affiche'];
	}
}

// Si un titre de film IMDb est passé en paramètre de l'URL : "form_film.php?imdb=the+matrix" => $_GET['imdb'] à pour valeur "the matrix"
// => Si une recherche sur le titre IMDb a été effectuée
if (isset($_GET['imdb'])) {
	// Je traite la chaine de caractères
	$imdb = strip_tags(trim($_GET['imdb']));

	// On inclut nos packages composer, avec l'API IMDb
	require_once 'vendor/autoload.php';

	// NE PAS retenir try - catch pour l'instant
	try {
		// J'effectue d'abord une recherche sur les termes passés en paramètre d'URL
		$imdbResultsList = \Jleagle\Imdb\Imdb::search($imdb);
		//print_pre($imdbResultsList);exit;
	}
	catch (Exception $e) {
		// Si une erreur survient, alors on n'a aucun résultat
		$noImdbResult = true;
	}

	// Si un titre exact de film a été renseigné ou si on n'a qu'un seul résultat lors de la recherche
	if (isset($_GET['imdbExact']) || sizeof($imdbResultsList) == 1) {
		// On vide le tableau de résultats de la recherche
		$imdbResultsList = array();
		try {
			// On récupère les infos sur un seul film
			$movie = \Jleagle\Imdb\Imdb::retrieve($imdb);
			
			// On donne les bonnes valeurs aux variables destinées à l'affichage
			// => pré-remplir le formulaire
			$fil_titre = $movie->title;
			$fil_annee = $movie->year;
			$fil_synopsis = $movie->plot;
			$fil_description = $movie->plot;
			$fil_acteurs = $movie->actors;
			$fil_affiche = $movie->poster;
			$imdbCategory = $movie->genre;
		}
		catch (Exception $e) {
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
$pageTitle='Formulaire ajout';
require 'inc/header.php';

?>

	<form action="" method="get">
		<legend>Pré-remplir avec IMDb</legend>
		<fieldset>
			<input type="text" name="imdb" value="<?php echo $imdb; // on remplit le champ de recherche IMDb par les termes actuellement recherchés ?>" />
			<input type="submit" value="Rechercher" />
			<?php
			// Si aucun résultat, j'affiche l'information
			if ($noImdbResult) {
				echo '&nbsp;&nbsp;<strong>Aucun résultat</strong>';
			}
			// Sinon si on a fait une recherche et qu'on a plusieurs résultats, on les affiche
			else if (sizeof($imdbResultsList) > 0) {
				echo '<br />Résultats :';
				foreach ($imdbResultsList as $curMovie) {
					echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?imdb='.urlencode($curMovie->title).'&imdbExact=1">'.$curMovie->title.'</a>';
				}
			}
			?>
			<br />
		</fieldset>
	</form>

	<form action="" method="post">
		<legend>Gestion de film</legend>
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
				</select><?php if (!empty($imdbCategory)) echo '&nbsp;&nbsp;IMDb => '.$imdbCategory; ?></td>
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
					<?php for ($annee=date('Y');$annee>1930;$annee--) : ?>
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
				<td><input type="submit" value="<?php if ($currentId > 0) { echo 'Modifier'; } else { echo 'Ajouter'; } ?>"/></td>
			</tr>	
			</table>
		</fieldset>
	</form>	
<?php require 'inc/footer.php'; ?>