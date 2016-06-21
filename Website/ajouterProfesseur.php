<?php

require_once 'myPDO.include.php' ;

if (isset ($_GET['nom'])&& isset ($_GET['prenom']) && isset ($_GET['email']) && isset ($_GET['pw']) ){
  if(!empty ($_GET['nom'])&& !empty ($_GET['prenom']) && !empty ($_GET['email']) && !empty ($_GET['pw']) ){

 $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
      INSERT INTO Intervenant(idIntervenant, statut, loginLDAP, nom, prenom) VALUES(:idIntervenant, :statut ,:loginLDAP, :nom, :prenom)
SQL
);


$stmt->bindParam(':idIntervenant', $idIntervenant);
$stmt->bindParam(':statut', $statut);
$stmt->bindParam(':loginLDAP', $loginLDAP);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
   
      $idIntervenant=$_GET['idIntervenant'] ;     
      $statut=$_GET['statut'] ;     
      $loginLDAP=$_GET['loginLDAP'] ;
      $nom=s$_GET['nom'] ;
      $prenom=$_GET['prenom'] ;
      
      $stmt->execute();
  
  echo 'hello';
  }
  
}