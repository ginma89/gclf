<pre>
<?php
require 'inc/config.php';
require 'html/header.php';
$sql="
	SELECT *
	FROM film
	WHERE fil_id=$_GET[id]
";
$pdoStatement=$pdo->query($sql);
$fetchInfo=$pdoStatement->fetch();
print_r($fetchInfo);
$title=$fetchInfo['fil_titre'];
$filename=$fetchInfo['fil_filename'];
$annee=$fetchInfo['fil_annee'];
$affiche=$fetchInfo['fil_affiche'];
$synopsis=$fetchInfo['fil_synopsis'];
$acteurs=$fetchInfo['fil_acteurs'];
$description=$fetchInfo['fil_description'];
?>



<?php
require 'html/footer.php';

?>
</pre>