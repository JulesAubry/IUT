<?php

session_start();

require_once "myPDO.include.php";

	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT CONCAT(m.idMatiere, ' - ', m.libMatiere, ' ( ' , sp.libSequence , ' ) ') AS "Matiere", i.nom
    FROM Intervenant i, Affectation a, Sequence_Pedagogique sp, Matiere m
    WHERE i.idIntervenant = a.idIntervenant
    AND sp.idSequence = a.idSequence
    AND sp.idMatiere = m.idMatiere
    
SQL
);


$stmt->execute();

    $tab2 = array() ;
    $cpt2 = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
      $tab2[$cpt2] =  $ligne;
      $cpt2++ ; 
  }

  echo json_encode($tab2, JSON_NUMERIC_CHECK); 
