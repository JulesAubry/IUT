<?php

require_once "myPDO.include.php";

if(isset($_GET['id']) and !empty($_GET['id']))
{ 

  $libSequence = substr($_GET['id'],0,2);
  $idMatiere = substr($_GET['id'],2);

  	$pdo = myPDO::getInstance() ;
  	$stmt = $pdo->prepare(<<<SQL
  		SELECT  I.idIntervenant, I.nom, V.nb_Desire, V.nb_Depanne
  		FROM Intervenant I, Voeux V, Sequence_Pedagogique S
  		WHERE V.idIntervenant = I.idIntervenant
  		AND V.idSequence = S.idSequence
      AND S.libSequence = :lib
      AND S.idMatiere = :id
SQL
);
  $stmt->bindParam(':lib', $libSequence);
  $stmt->bindParam(':id', $idMatiere);
  $tab = array() ;
  $stmt -> execute();
  $cpt = 0 ; 
  while (($ligne = $stmt->fetch()) !== false)
  {
    $tab[$cpt] =  $ligne;
    $cpt++ ;   
  }

  $stmt2 = $pdo->prepare(<<<SQL
  		SELECT idIntervenant, nom
  		FROM Intervenant
  		WHERE idIntervenant NOT IN(
  		  SELECT v.idIntervenant
  		  FROM Voeux v, Sequence_Pedagogique s
  		  WHERE v.idSequence = s.idSequence
        AND s.libSequence = :lib
        AND s.idMatiere = :id)
SQL
);
  $stmt2->bindParam(':lib', $libSequence);
  $stmt2->bindParam(':id', $idMatiere);
  $tab2 = array() ;
  $cpt=0 ;
  $stmt2-> execute();
  while (($ligne = $stmt2->fetch()) !== false) {
    $tab2[$cpt] =  $ligne;
    $cpt++ ;
  }

  $result = array_merge($tab,$tab2) ;
  
  echo json_encode($result,JSON_PRETTY_PRINT);
}