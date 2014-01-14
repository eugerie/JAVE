<?php


// Vérification des entêtes du fichier CSV et format.
function checkCSVattrb($file){
	//format de l'entête du fichier CSV
	$formatHeader = "#^pz\d+_\d+(_\d+)?$#";
	$formatcol1 = "#^OTU_\d+$#";
	$formatcoln = "#^[0-9]{1,}$#";
	if (($handle = fopen($file, "r")) != FALSE) {
		$row = 0;
		while (($data = fgetcsv($handle, 1000, ",")) != FALSE) {
	    	$nb = count($data);
	    	if ($nb > 1) {
	    		if ($row == 0) { // check header
	    			$col = 1;
	    			while ($col < $nb) {
	    				if (!preg_match($formatHeader, $data[$col])) {
	    					fclose($handle);
	    					return FALSE;
	    				}
	    				$col++;
	    			}
	    		} else {
	    			$col = 0;
	    			while ($col < $nb) {
	    				if (!(($col == 0 && preg_match($formatcol1, $data[$col])) || ($col > 0 && preg_match($formatcoln, $data[$col])))) {
	    					fclose($handle);
	    					return FALSE;
	    				}
	    				$col++;
	    			}
	    		}
	    		
	    	} else {
	    		echo "Erreur fichier : pas assez de colonnes<br>";
	    	}
	        $row++;
	    }
	    fclose($handle);
	} else {
		echo "Pb à l'ouverture du fichier.";
		return FALSE;	
	}
	return TRUE;
}

//vérification table existe sinon la crée
function checkExistTable($infoBDD, $table){
	$table = strtoupper($table);
	$reqCheck = "SELECT table_name FROM all_tables WHERE table_name='".$table."'";
	$reqCreateTable = "CREATE TABLE ".$table." (
		ESPECE varchar2(20) PRIMARY KEY
	)";
	$connexion = oci_connect($infoBDD[0], $infoBDD[1], $infoBDD[2]);
	if(!$connexion) {
		$e = oci_error();
		var_dump($e);
		return FALSE;
	}
	$checkstat = oci_parse($connexion, $reqCheck);
	if(!$checkstat){
		$e = oci_error($connexion);
		var_dump($e);
		oci_close($connexion);
		return FALSE;
	}
	$exec = oci_execute($checkstat);
	if(!$exec){
		$e = oci_error($checkstat);
		var_dump($e);
		oci_close($connexion);
		return FALSE;
	}
	$nb = oci_fetch($checkstat);
	oci_free_statement($checkstat);
	if ($nb != 0) {
		//la table existe
		oci_close($connexion);
		return TRUE;
	} else {
		$createTableStat = oci_parse($connexion, $reqCreateTable);
		if(!$createTableStat){
			$e = oci_error($connexion);
			var_dump($e);
			return FALSE;
		}
		$exec = oci_execute($createTableStat);
		if(!$exec){
			$e = oci_error($createTableStat);
			var_dump($e);
			oci_close($connexion);
			return FALSE;
		}
		oci_free_statement($createTableStat);
		oci_close($connexion);
		return TRUE;
	}
}

//vérification des noms des puits
function checkCSVBDD($file, $infoBDD, $table) {
	if (($handle = fopen($file, "r")) != FALSE) {
		$reqRecupAttrb = "Select COLUMN_NAME from USER_TAB_COLUMNS where TABLE_NAME ='".$table."' order by column_name ";
		$connexion = oci_connect($infoBDD[0], $infoBDD[1], $infoBDD[2]);
		if(!$connexion) {
			$e = oci_error();
			var_dump($e);
			return FALSE;
		}
		$checkAttrb = oci_parse($connexion, $reqRecupAttrb);
		if(!$checkAttrb){
			$e = oci_error($connexion);
			var_dump($e);
			return FALSE;
		}
		$exec = oci_execute($checkAttrb);
		if(!$exec){
			$e = oci_error($checkAttrb);
			var_dump($e);
			return FALSE;
		}
		//récupération dans un array les noms des puits déjà dans la bdd
		$arrayAttrb = oci_fetch_array($checkAttrb);
		oci_free_statement($checkAttrb);
		oci_close($connexion);
		//récupération des noms de puits du fichier CSV, première ligne
		$data = fgetcsv($handle, 1000, ",")
		$nb = count($data);
		$col = 1;
		while($col < $nb) {
			echo "p";
		}
		//comparaison -> double boucle
	fclose($handle);
	}
	else {
		echo "Pb à l'ouverture du fichier CSV";
		return FALSE;
	}
	return $arrayAttrb;
}

function addAttrb($arryAttrb){
	//connexion à la bdd
	//création de la requete d'ALTER
	//
	return TRUE;
}
?>
