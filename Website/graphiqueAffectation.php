<?php

session_start();

require_once "myPDO.include.php";

	
if(isset($_GET['nom']) && !empty($_GET['nom'])){

	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT CONCAT('(', sp.libSequence, ')', sp.idMatiere) AS "label", a.nb_Sequence AS "y"
    FROM Intervenant i, Affectation a, Sequence_Pedagogique sp
    WHERE i.idIntervenant = a.idIntervenant
    AND sp.idSequence = a.idSequence
    AND LCASE(i.nom) = :nom    
SQL
);

$stmt->bindParam(':nom', $str);
$str = strtolower($_GET['nom']);

$stmt->execute();

    $tab2 = array() ;
    $cpt2 = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
      $tab2[$cpt2] =  $ligne;
      $cpt2++ ; 
  }
 // var_dump($tab2);
  

  echo json_encode($tab2, JSON_NUMERIC_CHECK); 
  
  
}