<?php

session_start();

require_once "myPDO.include.php";

	
if(isset($_GET['id']) && !empty($_GET['id'])){


/*
	$libelleSequence = substr($_GET['id'], 0, 2);
	$identifiantMatiere = substr($_GET['id'], 2, strlen($_GET['id']));
  
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT i.nom AS "label", SUM(v.nb_Desire) + SUM(v.nb_Depanne) AS "y"
    FROM Intervenant i, Voeux v,Sequence_Pedagogique s
    WHERE i.idIntervenant = v.idIntervenant
    AND v.idSequence = s.idSequence
    AND s.idMatiere = :idMat
    AND s.libSequence = :libSeq;
SQL
);

$stmt->bindParam(':idMat',$identifiantMatiere);
$stmt->bindParam(':libSeq',$libelleSequence);

    $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
  }
  echo json_encode($tab, JSON_NUMERIC_CHECK);        */
  
  $libelleSequence = substr($_GET['id'], 0, 2);
	$identifiantMatiere = substr($_GET['id'], 2, strlen($_GET['id']));
  $idSemestre = substr($identifiantMatiere, 1, 1);
  
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT d.idSemaine AS "label", nbH_Semaine AS "y"
    FROM Diviser d, Semaine_Travaillee s, Sequence_Pedagogique sp, Contenir c
    WHERE d.idSemaine = s.idSemaine
    AND s.idSemaine = c.idSemaine
    AND d.idSequence = sp.idSequence
    AND sp.idMatiere = :idMat
    AND sp.libSequence = :libSeq
    AND c.idSemestre = :idSem
    
SQL
);

$stmt->bindParam(':idMat', $idMat);
$stmt->bindParam(':libSeq',$libSeq);
$stmt->bindParam(':idSem',$idSem);

$idMat = $identifiantMatiere;
$libSeq = $libelleSequence;
$idSem = $idSemestre;

$stmt->execute();

    $tab2 = array() ;
    $cpt2 = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
      $tab2[$cpt2] =  $ligne;
      $cpt2++ ; 
  }
 // var_dump($tab2);
  

             /*
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		INSERT INTO Diviser(idSemaine, idSequence, nbH_Semaine) VALUES (:idSemaine, :idSequence, :nbH_Semaines)
SQL
);

$stmt->bindParam(':idSemaine',$identifiantSemaine);
$stmt->bindParam(':idSequence',$identifiantSequence);
$stmt->bindParam(':nbH_Semaines',$nb);

//var_dump($tableau);
foreach ($tableau as $key => $value){
     $identifiantSemaine = $key;
     $nb = $tableau[$key];
     $identifiantSequence = $tab2[0]['idSequence'];
     $stmt -> execute();
}
          */
//var_dump($tour) ;
//var_dump($tableau) ;
//var_dump($tabSem);
//var_dump($tableauFinal);
  echo json_encode($tab2, JSON_NUMERIC_CHECK); 
  
  
}