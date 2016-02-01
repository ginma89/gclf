<?php

function getAllCat(){
	global $pdo;
	$myList=array();
	$sql="
		SELECT cat_id,cat_nom
		FROM categorie
	";
	$pdoStatement=$pdo->query($sql);
	if ($pdoStatement&&$pdoStatement->rowCount()>0) {
		$myList=$pdoStatement->fetchAll();
	}
	return $myList;
}

?>