<?php

require_once "myPDO.include.php";

if(isset($_GET['id']) && !empty($_GET['id'])){
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT m.idMatiere, m.libMatiere, m.demiSemestre, m.nbHCM_PPN, m.nbHTP_PPN, m.nbHTD_PPN, s.libSequence, s.nbH_Total, s.idSequence
		FROM Sequence_Pedagogique s, Matiere m, Repartition r
		WHERE s.idMatiere = m.idMatiere
		AND s.idSequence = r.idSequence
		AND r.idSemestre = :id
SQL
);
	$stmt->execute(array('id'=>$_GET['id']));

	$modules = array();
	/*$valeurCM = "";
	$valeurTD = "";
	$valeurTP = "";
	$heuresCM = 0;       */

	while(($ligne = $stmt->fetch()) !== false){
		$modules[] = $ligne;
	}

	//var_dump($modules);
	//session_start();
	  /*
	$jsonModules = array();
	foreach($modules as $value){

		if(isset($_SESSION['voeux']['saisie'][$value['idModule']]['CM'])){
			$valeurCM = $_SESSION['voeux']['saisie'][$value['idModule']]['CM'];
		}
		if(isset($_SESSION['voeux']['saisie'][$value['idModule']]['TD'])){
			$valeurTD = $_SESSION['voeux']['saisie'][$value['idModule']]['TD'];
		}
		if(isset($_SESSION['voeux']['saisie'][$value['idModule']]['TP'])){
			$valeurTP = $_SESSION['voeux']['saisie'][$value['idModule']]['TP'];
		}

		if(isset($_SESSION['voeux']['infos'][$value['idModule']])){
			foreach($_SESSION['voeux']['infos'][$value['idModule']] as $semaine=>$valeur){
				$heuresCM += $valeur['CM'];
			}
		}

		$jsonModules[] = array('id' => $value['idModule'], 'nom' => $value['nom'], 'CM' => $valeurCM, 'TD' => $valeurTD, 'TP' => $valeurTP, 'maxCM' => $heuresCM);
		$valeurCM = null;
		$valeurTD = null;
		$valeurTP = null;
		$heuresCM = 0;
	}
	                         */

echo json_encode($modules, JSON_UNESCAPED_UNICODE);
//print_r( json_last_error());
/*
switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Aucune erreur';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Profondeur maximale atteinte';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Inadéquation des modes ou underflow';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Erreur lors du contrôle des caractères';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Erreur de syntaxe ; JSON malformé';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Caractères UTF-8 malformés, probablement une erreur d\'encodage';
        break;
        default:
            echo ' - Erreur inconnue';
        break;
    }*/
}
  