<?php

session_start();

require_once "myPDO.include.php";

	
if(isset($_GET['listeNbH']) && !empty($_GET['listeNbH']) && isset($_GET['id']) && !empty($_GET['id'])){

  
  $libelleSequence = substr($_GET['id'], 0, 2);
	$identifiantMatiere = substr($_GET['id'], 2, strlen($_GET['id']));
  $idSemestre = substr($identifiantMatiere, 1, 1);
  //var_dump($_GET['id']);
  //var_dump($_GET['listeNbH']);
  
   	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT d.idSemaine
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
  
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		UPDATE DIVISER
    SET nbH_Semaine = :nbSem
    WHERE idSemaine = :idSem
    AND idSequence = (SELECT idSequence FROM Sequence_Pedagogique WHERE idMatiere = :idMat AND libSequence = :libSeq)
    
SQL
);

$stmt->bindParam(':idMat', $idMat);
$stmt->bindParam(':libSeq',$libSeq);
$stmt->bindParam(':nbSem', $nbrSem);
$stmt->bindParam(':idSem', $idSemaine);

$idMat = $identifiantMatiere;
$libSeq = $libelleSequence;

//var_dump(($_GET['listeNbH']));

$cpt = 0;
foreach ($_GET['listeNbH'] as $value) {
      $nbrSem = intval($value);
      //var_dump($nbrSem)  ;
      $idSemaine = $tab2[$cpt]['idSemaine'];
      //var_dump($idSemaine);
      $stmt->execute();
      $cpt++;
  }                    
header("refresh:2; module.php"); 
header('Content-Type: text/html; charset=utf-8');
echo "La séquence pédagogique a bien été repartie"; 
   
}