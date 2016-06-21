<?php

require_once "myPDO.include.php";

session_start();

if(isset($_SESSION['voeux']['saisie'])){
    $pdo = myPDO::getInstance();
    $idModule = 0;
    $idProf = $_SESSION['login']['idProf'];
    $valeurCM = 0;
    $valeurTD = 0;
    $valeurTP = 0;
    
    //Requete permettant de savoir s'il y a dŽjˆ eu des "insert" dans la table "voeux" pour un idProf et un idModule
    $reqModule = $pdo->prepare("SELECT id FROM Voeux WHERE idProf = :idProf AND idModule = :idModule");
    $reqModule->bindParam(':idProf', $idProf);
    $reqModule->bindParam(':idModule', $idModule);
    
    $reqInsert = $pdo->prepare("INSERT INTO Voeux (idProf,idModule,CM,TD,TP) VALUES (:idProf,:idModule,:CM,:TD,:TP)");
    $reqInsert->bindParam(':idProf', $idProf);
    $reqInsert->bindParam(':idModule', $idModule);
    $reqInsert->bindParam(':CM', $valeurCM);
    $reqInsert->bindParam(':TD', $valeurTD);
    $reqInsert->bindParam(':TP', $valeurTP);
    
    $reqUpdate = $pdo->prepare("UPDATE Voeux SET CM = :CM, TD = :TD, TP = :TP WHERE idProf = :idProf AND idModule = :idModule");
    $reqUpdate->bindParam(':idProf', $idProf);
    $reqUpdate->bindParam(':idModule', $idModule);
    $reqUpdate->bindParam(':CM', $valeurCM);
    $reqUpdate->bindParam(':TD', $valeurTD);
    $reqUpdate->bindParam(':TP', $valeurTP);
    
    foreach($_SESSION['voeux']['saisie'] as $id => $arrayModule){
	$idModule = $id;
	foreach($arrayModule as $type => $value){
	    if($type == 'CM'){
		$valeurCM = $value;
	    }
	    else if($type == 'TD'){
		$valeurTD = $value;
	    }
	    else if($type == 'TP'){
		$valeurTP = $value;
	    }
	}
	
	$reqModule->execute();
	if($reqModule->rowCount() == 0){
	    $reqInsert->execute();
	}
	else{
	    $reqUpdate->execute();
	}
	
	$valeurCM = 0;
	$valeurTD = 0;
	$valeurTP = 0;
	
    }
    $_SESSION['voeux']['save'] = 1;
}