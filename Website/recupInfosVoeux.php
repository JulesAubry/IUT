<?php

require_once "myPDO.include.php";

if(isset($_GET['idInter']) && !empty($_GET['idInter']) && isset($_GET['idSeq']) && !empty($_GET['idSeq'])){
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT nb_Desire, nb_Depanne
		FROM Voeux
		WHERE idIntervenant = :idInt
    AND idSequence = :idSe
SQL
);
	$stmt->execute(array('idInt'=>$_GET['idInter'] , 'idSe'=>$_GET['idSeq']));

$voeux = array();
	/*$valeurCM = "";
	$valeurTD = "";
	$valeurTP = "";
	$heuresCM = 0;       */

	while(($ligne = $stmt->fetch()) !== false){
		$voeux[] = $ligne;
	}
  
  echo json_encode($voeux) ;
  
}