<?php

require_once "myPDO.include.php";

if(isset($_GET['arr']) && !empty($_GET['arr'])  && isset($_GET['idMod']) && !empty($_GET['idMod'])  ){
     $array = json_decode($_GET['arr']);
     $tableau = array();
    foreach($array as $el){ /*
    $el_array=explode('|',$el);  */
    $tableau[$el->id] = $el->value;
 }
 
 // var_dump($_GET['idMod']);               
  var_dump($tableau);
  
  $libelleSequence = substr($_GET['idMod'], 0, 2);
	$identifiantMatiere = substr($_GET['idMod'], 2, strlen($_GET['idMod']));
  $idSemestre = substr($identifiantMatiere, 1, 1);
       
    $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
    DELETE FROM Affectation
    WHERE idSequence = (SELECT sp.idSequence FROM Sequence_Pedagogique sp WHERE sp.libSequence = :libSeq AND idMatiere = :idMat)
SQL
);
	$stmt->bindParam(':idMat', $id);
	$stmt->bindParam(':libSeq', $seq);
  
  $id = $identifiantMatiere;
  $seq = $libelleSequence;
                 
  foreach($tableau as $key => $value) {
         $pdo = myPDO::getInstance() ;
    $stmt2 = $pdo->prepare(<<<SQL
    SELECT idIntervenant FROM Intervenant WHERE nom = :nom
    
SQL
);
  $stmt2->bindParam(':nom', $nom); 
  
  if(strpos($key,'Desiree') !== false) {
      $nom = substr($key, 0,strpos($key,'Desiree'));
  }
  else if (strpos($key,'Depannee') !== false) {
      $nom = substr($key, 0,strpos($key,'Depannee')); 
  }
  else {
      $nom = substr($key, 0,strpos($key,'Autres')); 
  }
 // var_dump($nom) ;
  
    $tabRes = array() ;
    $stmt2 -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt2->fetch()) !== false) {
    $tabRes[$cpt] =  $ligne;
    $cpt++ ; 
  }
     //var_dump($tabRes[0]['idIntervenant']);
  $idIntervenant = $tabRes[0]['idIntervenant'];
  $stmt->execute();    
      
}
 

 $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
    INSERT INTO Affectation(idIntervenant, idSequence, nb_Sequence) VALUES(:idIntervenant, :idSequence, :nb_Sequence)
SQL
);
  $stmt->bindParam(':idIntervenant', $idIntervenant); 
	$stmt->bindParam(':idSequence', $id);
	$stmt->bindParam(':nb_Sequence', $seq);
  
                 
  foreach($tableau as $key => $value) {
  $seq = $value;
         $pdo = myPDO::getInstance() ;
    $stmt2 = $pdo->prepare(<<<SQL
    SELECT idIntervenant FROM Intervenant WHERE nom = :nom
    
SQL
);
  $stmt2->bindParam(':nom', $nom); 
  
  if(strpos($key,'Desiree') !== false) {
      $nom = substr($key, 0,strpos($key,'Desiree'));
  }
  else if (strpos($key,'Depannee') !== false) {
      $nom = substr($key, 0,strpos($key,'Depannee')); 
  }
  else {
      $nom = substr($key, 0,strpos($key,'Autres')); 
  }
 // var_dump($nom) ;
  
    $tabRes = array() ;
    $stmt2 -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt2->fetch()) !== false) {
    $tabRes[$cpt] =  $ligne;
    $cpt++ ; 
  }
     //var_dump($tabRes[0]['idIntervenant']);
  $idIntervenant = $tabRes[0]['idIntervenant'];
  
  $pdo = myPDO::getInstance() ;
    $stmt2 = $pdo->prepare(<<<SQL
    SELECT idSequence FROM Sequence_Pedagogique WHERE idMatiere = :idMat AND libSequence = :libSeq
    
SQL
);
    $stmt2->bindParam(':idMat', $idMat); 
    $stmt2->bindParam(':libSeq', $libSeq); 
    $libSeq = $libelleSequence;
	  $idMat = $identifiantMatiere;
    $tabRes = array() ;
    $stmt2 -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt2->fetch()) !== false) {
    $tabRes[$cpt] =  $ligne;
    $cpt++ ; 
  }
     //var_dump($tabRes[0]['idIntervenant']);
  $id = $tabRes[0]['idSequence'];
    
  $pdo = myPDO::getInstance() ;
    $stmt2 = $pdo->prepare(<<<SQL
    SELECT * FROM Affectation WHERE idIntervenant = :idInterr AND idSequence = :idSeqq   
SQL
);
    $stmt2->bindParam(':idInterr', $idInterr); 
    $stmt2->bindParam(':idSeqq', $idSeqq); 
    $idInterr = $idIntervenant;
	  $idSeqq = $id;
    $tabRes2 = array() ;
    $stmt2 -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt2->fetch()) !== false) {
    $tabRes2[$cpt] =  $ligne;
    $cpt++ ; 
  }
    
  
  // var_dump($id);
  //  var_dump($seq);
  //var_dump($idIntervenant); //Oui c'est con je peux pas insérer plusieurs lignes avec les mêmes clés primaires -> idIntervenant et idSequence
       if($stmt2->rowCount() == 0 ) {
           $stmt->execute();  
          } 
      
} 
 
 
}