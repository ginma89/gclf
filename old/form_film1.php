<!DOCTYPE html>
<pre>
<?php
$formOk=false;
$allowModify=false;
//CONNECT TO DATABASE*******************************************************************
$pdo=new PDO('mysql:host=localhost;dbname=gcif;charset=UTF8','root','toor');		////
//FETCH INFO TO DISPLAY*****************************************************************
if (!empty($_GET)) {
	//echo'$_GET-ARRAY: ';
	//print_r($_GET);
	$sql="
		SELECT fil_titre,fil_filename,fil_annee,fil_affiche,fil_synopsis,fil_acteurs,fil_description
		FROM film
		WHERE fil_id=:fil_id
	";
	$pdoStatement=$pdo->prepare($sql);
	$pdoStatement->bindvalue(':fil_id',$_GET['id'],PDO::PARAM_INT);
	$execute=$pdoStatement->execute();
	$fetchedInfo=$pdoStatement->fetch();
	$allowModify=true;
	//echo'FETCHED ARRAY: ';
	//print_r($fetchedInfo);
}

//ON POST*******************************************************************************
if (!empty($_POST)&&!$allowModify) {
	
	//FORM TRIM**************************************************
	$title=strip_tags($_POST['title_post']);
	$year=strip_tags($_POST['select_year_post']);
	$synopsis=strip_tags($_POST['synopsis_post']);
	$description=strip_tags($_POST['description_post']);
	$actors=strip_tags($_POST['actors_post']);
	$file=strip_tags($_POST['file_post']);
	$poster=strip_tags($_POST['poster_post']);
	
	//FORM VALIDATION**************************************************
	$titleOk=isset($title)&&strlen($title)>2;
	$yearOk=isset($year)&&strlen($year)>3;
	$synopsisOk=isset($synopsis)&&strlen($synopsis)>2;
	$descriptionOk=isset($description)&&strlen($description)>2;
	$actorsOk=isset($actors)&&strlen($actors)>2;
	$fileOk=isset($file)&&strlen($file)>2;
	$posterOk=isset($poster)&&strlen($poster)>2;

	//FORM OKAY*********************************************************************************************
	if ($titleOk&&$yearOk&&$synopsisOk&&$descriptionOk&&$actorsOk&&$fileOk&&$posterOk) {
		$formOk=true;
	};

	if ($formOk) {
		echo '<h1>OK</h1>';
		//DEFINE QUERY**************************************************************************
		$sql="
			INSERT INTO film(fil_titre,fil_filename,fil_annee,fil_affiche,fil_synopsis,fil_acteurs,fil_description,fil_created)
			VALUES (:fil_titre,:fil_filename,:fil_annee,:fil_affiche,:fil_synopsis,:fil_acteurs,:fil_description,NOW())
		";
		//BIND VALUES************************************************************************
		$pdoStatement=$pdo->prepare($sql);
		$pdoStatement->bindvalue(':fil_titre',$title,PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_filename',$file,PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_annee',$year,PDO::PARAM_INT);
		$pdoStatement->bindvalue(':fil_affiche',$poster,PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_synopsis',$synopsis,PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_acteurs',$actors,PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_description',$description,PDO::PARAM_STR);
		//EXECUTE QUERY ************************************************************************
		$execute=$pdoStatement->execute();
		//ERROR LIST FOR DEBUG*******************************************************************
		$errorList=$pdoStatement->errorInfo();
		print_r($errorList);
		//LAST INSERT ID*********************************************************************
		$lastId=$pdo->lastInsertId();
		echo'LAST ID:'.$lastId.'<br/>';
	}else{
		echo '<h1>NOT OK</h1>';
	};
	
	

};

//GET ID FROM URL WITH $_GET**************************************************
///////
// IF AFTER A SUBMIT , CLICK ON MODIFIER***************************



if (!empty($_POST)&&$allowModify) {
		$sql="
			UPDATE film
			SET fil_titre=:fil_titre,
				fil_filename=:fil_filename,
				fil_annee=:fil_annee,
				fil_affiche=:fil_affiche,
				fil_synopsis=:fil_synopsis,
				fil_acteurs=:fil_acteurs,
				fil_description=:fil_description
			WHERE fil_id=:fil_id
		";
		$pdoStatement=$pdo->prepare($sql);
		$pdoStatement->bindvalue(':fil_titre',$_POST['title_post'],PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_filename',$_POST['file_post'],PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_annee',$_POST['select_year_post'],PDO::PARAM_INT);
		$pdoStatement->bindvalue(':fil_affiche',$_POST['poster_post'],PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_synopsis',$_POST['synopsis_post'],PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_acteurs',$_POST['actors_post'],PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_description',$_POST['description_post'],PDO::PARAM_STR);
		$pdoStatement->bindvalue(':fil_id', $_GET['id'], PDO::PARAM_INT);
		$execute=$pdoStatement->execute();
		//FETCH INFO AGAIN************************************************************
		$sql="
		SELECT fil_titre,fil_filename,fil_annee,fil_affiche,fil_synopsis,fil_acteurs,fil_description
		FROM film
		WHERE fil_id=:fil_id
		";
		$pdoStatement=$pdo->prepare($sql);
		$pdoStatement->bindvalue(':fil_id',$_GET['id'],PDO::PARAM_INT);
		$execute=$pdoStatement->execute();
		$fetchedInfo=$pdoStatement->fetch();
	}





?>
</pre>
<html>
	<head>
		<meta charset="utf-8">
		<title>formulaire film</title>
	</head>
	<body>
		<h1>GESTION DE FILM</h1>
		<div style="border:solid black 1px;padding:5px">
		<?php if (!$formOk) { ?>
			<form action="" method="post">
				Titre:
				<input type="text" name="title_post" value="<?php echo (!empty($fetchedInfo))?$fetchedInfo['fil_titre']:''; ?>"><br/>
				Année:
				<select name="select_year_post">
					<option value="">choisir année</option>
					<?php for ($i=2016; $i>1929; $i--) { 
						echo"<option value='$i'>$i</option>";
					} ?>
				</select><br/>
				Synopsis:
				<textarea type="text" name="synopsis_post"><?php echo (!empty($fetchedInfo))?$fetchedInfo['fil_synopsis']:''; ?></textarea><br/>
				Description:
				<textarea type="text" name="description_post"><?php echo (!empty($fetchedInfo))?$fetchedInfo['fil_description']:''; ?></textarea><br/>
				Acteurs:
				<input type="text" name="actors_post" value="<?php echo (!empty($fetchedInfo))?$fetchedInfo['fil_acteurs']:''; ?>"><br/>
				Fichier:
				<input type="text" name="file_post" value="<?php echo (!empty($fetchedInfo))?$fetchedInfo['fil_filename']:''; ?>"><br/>
				Affiche:
				<input type="text" name="poster_post" value="<?php echo (!empty($fetchedInfo))?$fetchedInfo['fil_affiche']:''; ?>"><br/>
				<input type="submit" value="VALIDER">
			</form>
		<?php } else{ ?>
			<a href= <?php echo"form_film.php?id=$lastId" ?> >MODIFIER</a>
		<?php } ?>
		</div>
	</body>
</html>