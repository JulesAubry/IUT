<?php

require_once "myPDO.include.php";

session_start();

if(isset($_SESSION['login']['idIntervenant'])&&!empty($_SESSION['login']['idIntervenant'])){       /*
	
	$pdo = myPDO::getInstance();
	
//----------------------------------------------------------------------------------------------------------
	//Récupération voeux TP du prof
	$req = $pdo->prepare(<<<SQL
		SELECT V.nb_Desire+V.nb_Depanne as nbSeq
		FROM Voeux V, Sequence_Pedagogique S
		WHERE V.idSequence = S.idSequence
		AND idIntervenant = :idIntervenant
		AND S.libSequence = 'TP'
SQL
	);


	$req->execute(array('idIntervenant' => $_SESSION['login']['idIntervenant']));

	while(($ligne = $req->fetch()) !== false){
		$_SESSION['voeux']['saisie'][$ligne['idSequence']]['TP'] = $ligne['TP'];
	}
	//Récupération voeux TD du prof
	$req = $pdo->prepare(<<<SQL
		SELECT V.nb_Desire+V.nb_Depanne as nbSeq
		FROM Voeux V, Sequence_Pedagogique S
		WHERE V.idSequence = S.idSequence
		AND idIntervenant = :idIntervenant
		AND S.libSequence = 'TD'
SQL
	);


	$req->execute(array('idIntervenant' => $_SESSION['login']['idIntervenant']));

	while(($ligne = $req->fetch()) !== false){
		$_SESSION['voeux']['saisie'][$ligne['idSequence']]['TD'] = $ligne['TD'];
	}
	//Récupération voeux CM du prof
	$req = $pdo->prepare(<<<SQL
		SELECT V.nb_Desire+V.nb_Depanne as nbSeq
		FROM Voeux V, Sequence_Pedagogique S
		WHERE V.idSequence = S.idSequence
		AND idIntervenant = :idIntervenant
		AND S.libSequence = 'CM'
SQL
	);


	$req->execute(array('idIntervenant' => $_SESSION['login']['idIntervenant']));

	while(($ligne = $req->fetch()) !== false){
		$_SESSION['voeux']['saisie'][$ligne['idSequence']]['CM'] = $ligne['CM'];
	}
//----------------------------------------------------------------------------------------------------------

	
	//Récupération semaines
	$req = $pdo->prepare(<<<SQL
		SELECT DISTINCT idSemaine
		FROM Contenir
		WHERE idSemestre = 1 OR idSemestre = 3
		ORDER BY 1
SQL
	);
	try {
	  $_SESSION['voeux']['graph']['semaines'] = array();	
	  $req->execute();
	  //$req->execute(array('id1'=>'1','id2'=>'3'));
	  while(($ligne = $req->fetch()) !== false){
		  $_SESSION['voeux']['graph']['semaines'][] = $ligne['idSemaine'];
	  }
	 
	 
	} catch(Exception $e) {
	echo $e->getMessage(); //CA PLANTE POURQUOI
      }
	$req->execute(array('id1'=>'2','id2'=>'4'));
	
	while(($ligne = $req->fetch()) !== false){
		$_SESSION['voeux']['graph']['semaines'][] = $ligne['idSemaine'];
	}
	
	//Initialisation valeur graphique
	$req = $pdo->prepare(<<<SQL
		SELECT idSemaine
		FROM Semaine_Travaillee
		WHERE idSemestre = :semestre
SQL
	);
	
	for($i=1; $i<5; $i++){
		$req->execute(array('semestre'=>$i));
		$_SESSION['voeux']['graph']['S'.$i] = array();
		while(($ligne = $req->fetch()) !== false){
			$_SESSION['voeux']['graph']['S'.$i][$ligne['idSemaine']] = 0;
		}
	
	}

	/*
	//Récupération de la table répartition
	$req = $pdo->prepare(<<<SQL
		SELECT d.idSequence, d.idSemaine, d.nbH_Semaine
		FROM Diviser d
SQL
);
	$req->execute();
	
	while(($ligne = $req->fetch()) !== false){
		$_SESSION['voeux']['infos'][$ligne['idSequence']][$ligne['idSemaine']]['nbHParSemaine'] = $ligne['nbH_Semaine'];
	}
	*/
	
	//Redirection vers voeux
	if($_SESSION['login']['status']==0){
		header('Location: voeux.php');
	}
	else{
		header('Location: admin.php');
	}
	
}