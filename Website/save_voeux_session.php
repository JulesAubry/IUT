<?php

require_once "myPDO.include.php";

        
if(isset($_GET['valeur']) /* && !empty($_GET['valeur']) */&& isset($_GET['type']) && !empty($_GET['type']) && isset($_GET['idInter']) && !empty($_GET['idInter'])&& isset($_GET['idSeq']) && !empty($_GET['idSeq'])){
         var_dump('ici');
  if(($_GET['type']) == 'Depanne') {
  	
    	$pdo = myPDO::getInstance() ;
    	$stmt = $pdo->prepare(<<<SQL
      UPDATE Voeux
      SET nb_Depanne = :value
      WHERE idIntervenant = :idIn
      AND idSequence = :idSe
SQL
  );
  $stmt->bindParam(':value', ($_GET['valeur']));
  $stmt->bindParam(':idIn',$_GET['idInter']);
  $stmt->bindParam(':idSe',$_GET['idSeq']);
  
      $tab = array() ;
      $stmt -> execute();
   
      if ($stmt->rowCount() == 0)  {
      
      $pdo = myPDO::getInstance() ;
    	$stmt = $pdo->prepare(<<<SQL
      INSERT INTO Voeux(idIntervenant, idSequence, nb_Depanne) VALUES(:idIn, :idSe, :value);
SQL
  );
  
  
  $stmt->bindParam(':value', $_GET['valeur']);
  $stmt->bindParam(':idIn',$_GET['idInter']);
  $stmt->bindParam(':idSe',$_GET['idSeq']);
  
      $tab = array() ;
      $stmt -> execute();  
        }
      
      }
      
else {
       	$pdo = myPDO::getInstance() ;
    	$stmt = $pdo->prepare(<<<SQL
      UPDATE Voeux
      SET nb_Desire = :value
      WHERE idIntervenant = :idIn
      AND idSequence = :idSe
SQL
  );
  
  
  $stmt->bindParam(':value', $_GET['valeur']);
  $stmt->bindParam(':idIn',$_GET['idInter']);
  $stmt->bindParam(':idSe',$_GET['idSeq']);
  
      $tab = array() ;
      $stmt -> execute();
      
         var_dump('ici2');
      if ($stmt->rowCount() == 0)  {
      
      $pdo = myPDO::getInstance() ;
    	$stmt = $pdo->prepare(<<<SQL
      INSERT INTO Voeux(idIntervenant, idSequence, nb_Desire) VALUES(:idIn, :idSe, :value);
SQL
  );
  
  
  $stmt->bindParam(':value', $_GET['valeur']);
  $stmt->bindParam(':idIn',$_GET['idInter']);
  $stmt->bindParam(':idSe',$_GET['idSeq']);
  
      $tab = array() ;
      $stmt -> execute();  
      }
      
  }

}