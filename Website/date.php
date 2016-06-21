<?php

require_once 'myPDO.include.php' ;


  
if (isset($_GET['date_debut']) && isset ($_GET['date_milieu'])&& isset($_GET['date_fin']) && isset($_GET['semestre'])) {   
  if(!empty($_GET['date_debut']) && !empty ($_GET['date_milieu']) && !empty($_GET['date_fin']) && !empty($_GET['semestre']) ) {

  $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
      UPDATE Semestre SET dateDebut = :dateDebut, dateMilieu = :dateMilieu, dateFin = :dateFin WHERE idSemestre = :idSemestre
SQL
);


  $stmt->bindParam(':idSemestre',$idSemestre);
  $stmt->bindParam(':dateDebut', $dateDebut);
  $stmt->bindParam(':dateMilieu', $dateMilieu);
  $stmt->bindParam(':dateFin', $dateFin);


  $idSemestre = $_GET['semestre']; 
  $dateDebut = $_GET['date_debut'];
  $dateMilieu = $_GET['date_milieu'];
  $dateFin = $_GET['date_fin'];

  $stmt->execute() ;

  if($stmt -> rowCount() == 0) {

  $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
      INSERT INTO Semestre(idSemestre, dateDebut, dateMilieu, dateFin) VALUES(:idSemestre, :dateDebut, :dateMilieu, :dateFin)
SQL
);

  $stmt->bindParam(':idSemestre',$idSemestre);
  $stmt->bindParam(':dateDebut', $dateDebut);
  $stmt->bindParam(':dateMilieu', $dateMilieu);
  $stmt->bindParam(':dateFin', $dateFin);


  $idSemestre = $_GET['semestre']; 
  $dateDebut = $_GET['date_debut'];
  $dateMilieu = $_GET['date_milieu'];
  $dateFin = $_GET['date_fin'];

  $stmt->execute() ;
  
  }

                              
header("refresh:2; calendrier.php"); 
header('Content-type: text/html; charset=utf-8');
echo "Le semestre a bien été ajouté";    
  
 } 
  
}