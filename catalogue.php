<?php

require 'inc/config.php';

// Page par défaut => 1
$currentPage = 1;
$searchTerms = '';
// On souhaite afficher 4 films par page
$nbFilmsParPage = 6;
$offsetPage = 0;
// Je récupère le paramètre d'URL "page" de type integer
if (isset($_GET['page'])) {
	$currentPage = intval($_GET['page']);
	$offsetPage = ($currentPage-1)*$nbFilmsParPage;
}

// Je récupère le paramètre d'URL "q"
if (isset($_GET['q'])) {
	$searchTerms = trim($_GET['q']);
}

// J'écris ma requête dans une variable
$sql = '
	SELECT fil_id, fil_titre, fil_affiche, fil_id, fil_annee, fil_synopsis
	FROM film
';
// Je teste que la query (q) n'est pas vide
$rechercheEnCours = false;
if (!empty($searchTerms)) {
	$rechercheEnCours = true;
	$sql .= '
		WHERE fil_titre LIKE :terms
		OR fil_synopsis LIKE :terms
		OR fil_acteurs LIKE :terms
	';
}
$sql .= '
	ORDER BY fil_id DESC
	LIMIT '.$offsetPage.', '.$nbFilmsParPage.'
';
// Je prépare ma requête à MySQL et je récupère le Statement
$pdoStatement = $pdo->prepare($sql);
if ($rechercheEnCours) {
	$pdoStatement->bindValue(':terms', '%'.$searchTerms.'%');
}

// Si la requête a fonctionnée
if ($pdoStatement->execute()) {
	$filmList = $pdoStatement->fetchAll();
}

$pageTitle = 'Catalogue';
require 'html/header.php';
?>
<section class="pagination">
	<?php
	if ($currentPage >= 2) {
	?>
	<a href="?page=<?php echo $currentPage-1; ?>&q=<?php echo $searchTerms; ?>">&lt; précédent</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	}
	?>
	<a href="?page=<?php echo $currentPage+1; ?>&q=<?php echo $searchTerms; ?>">suivant &gt;</a>
</section>
<section class="filmList">
	<?php
	// Si la variable $filmList existe et si elle contient plusieurs lignes
	if (isset($filmList) && sizeof($filmList) > 0) {
		foreach ($filmList as $currentFilmInfos) {
		?>
		<article>
			<div class="content">
				<img src="<?php echo $currentFilmInfos['fil_affiche']; ?>" border="0" />
				<div class="titre">
					#<?php echo $currentFilmInfos['fil_id']; ?>&nbsp;
					<a href="details.php?id=<?php echo $currentFilmInfos['fil_id']; ?>"><?php echo $currentFilmInfos['fil_titre']; ?></a>
				</div>
				<div class="synopsis">
					<?php echo $currentFilmInfos['fil_synopsis']; ?>
				</div>
			</div>
			<div class="actions">
				<a class="btn" href="details.php?id=<?php echo $currentFilmInfos['fil_id']; ?>">Détails</a><br />
				<a class="btn" href="form_film.php?id=<?php echo $currentFilmInfos['fil_id']; ?>">Modifier</a><br />
			</div>
		</article>
		<?php
		}
	}
	?>
</section>
<?php
require 'html/footer.php';