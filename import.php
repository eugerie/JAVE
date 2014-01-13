<h1>Test des fonctions de 'fonctions_import.php'</h1>
<?php
//config
$infoBDD = ["login", "mdp", "BDD"];
include 'fonctions_import.php';

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
if (checkCSVBDD("test.csv", $infoBDD, "JAVE_brute")) {
	echo "true";
} else {
	echo "false";
}
echo "<br/>";


//test existence bdd sinon création
echo "gestion JAVE_brute : ";
if (checkExistTable($infoBDD, "JAVE_brute")) {
	echo "true";
} else {
	echo "false";
}
echo "<br/>";
?>