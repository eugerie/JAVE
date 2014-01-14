<h1>Test des fonctions de 'fonctions_import.php'</h1>
<?php
include 'fonctions_import.php';
//config
$infoBDD = ["bio12", "bio", "CIENETDB"];
$table_name = "test_brut";


//test fichier format CSV ok
echo "format fichier CSV : ";
if (checkCSVattrb("test.csv")) {
	echo "true";
} else {
	echo "false";
}
echo "<br/>";

//test attrb non déjà présent ds la bdd
echo "pas de conflit avec la bdd : ";
if (checkCSVBDD("test.csv", $infoBDD, $table_name)) {
	echo "true";
} else {
	echo "false";
}
echo "<br/>";


//test existence bdd sinon création
echo "gestion JAVE_brute : ";
if (checkExistTable($infoBDD, $table_name)) {
	echo "true";
} else {
	echo "false";
}
echo "<br/>";
?>
