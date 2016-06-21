<?php

require_once 'myPDO.include.php' ;

/*    function nbSemaines($debut, $fin) {
        //60 secondes X 60 minutes X 24 heures dans une journée
        $nbSecondes= 60*60*24;
 
        $debut_ts = strtotime($debut);
        $fin_ts = strtotime($fin);
        $diff = $fin_ts - $debut_ts;
        return ceil(round($diff / $nbSecondes)/7);
    }
 */   
    /* nombre de semaines dans une année $year */
   /* function NumberOfWeeksInAYear($year)
      {
        $day = mktime(0,0,0, 12, 31, $year);
        $week = date("W", $day);

        if ($week == 1)
          return 52;
        else return $week;
      }*/
       // var_dump('hello1');
       
//TODO : la requete 1 ne se lance pas
  if(empty($_GET['TDM'])) {
     $tdm = 0;
  }
if (isset ($_GET['nom'])&& isset($_GET['libelleSeq']) && isset($_GET['nbHTotal']) && isset($_GET['nbGroupe'])){   
  if(!empty ($_GET['nom']) && !empty($_GET['libelleSeq']) && !empty($_GET['nbHTotal']) && !empty($_GET['nbGroupe'])){

  //var_dump('hello2');
  
  $libelleSequence = substr($_GET['secret'], 0, 2);
	$identifiantMatiere = substr($_GET['secret'], 2, strlen($_GET['secret']));
  $idSemestre = substr($identifiantMatiere, 1, 1);
  
  
  $pdo = myPDO::getInstance() ;
  //Insertion dans la table MATIERE
    $stmt = $pdo->prepare(<<<SQL
      UPDATE Matiere
      SET libMatiere = :libMatiere, nbHCM_PPN = :nbHCM_PPN, nbHTD_PPN = :nbHTD_PPN, nbHTP_PPN = :nbHTP_PPN, demiSemestre = :demiSemestre
      WHERE idMatiere = :idMat
SQL
);
   

  $stmt->bindParam(':libMatiere', $libMatiere);
  $stmt->bindParam(':nbHCM_PPN', $nbHCM_PPN);
  $stmt->bindParam(':nbHTD_PPN', $nbHTD_PPN);
  $stmt->bindParam(':nbHTP_PPN', $nbHTP_PPN);
  $stmt->bindParam(':idMat', $idMat);
  $stmt->bindParam(':demiSemestre', $demiSem);
   
   $demiSem = $_GET['partieSem'][0];
  
  $idMat = $identifiantMatiere;
  $libMatiere = $_GET['nom'];
  
  if(empty($_GET['HCMPPN'])) {
    $nbHCM_PPN = 0;
  }
  else {
   $nbHCM_PPN = $_GET['HCMPPN'];
  }
  
  if(empty($_GET['HTDPPN'])) {
    $nbHTD_PPN = 0;
  }
  else {
   $nbHTD_PPN = $_GET['HTDPPN'];
  }
  
  if(empty($_GET['HTPPPN'])) {
    $nbHTP_PPN = 0;
  }
  else {
   $nbHTP_PPN = $_GET['HTPPPN'];
  }
  
   //var_dump($stmt) ;
  $stmt->execute() ;
       

                    
  $pdo = myPDO::getInstance();
  $stmt = $pdo->prepare(<<<SQL
    UPDATE Sequence_Pedagogique
    SET libSequence = :libSequence, nbH_Total = :nbH_Total
    WHERE libSequence = :libSeq
    AND idMatiere = (SELECT idMatiere
                        FROM Matiere
                        WHERE libMatiere = :libMatiere)

SQL
);

  $stmt->bindParam(':libMatiere', $idMat);
  $stmt->bindParam(':libSequence', $libSequence);
  $stmt->bindParam(':nbH_Total', $nbH_Total);
   $stmt->bindParam(':libSeq', $libSeq);
  //var_dump($_GET['id']);
  $idMat = $_GET['nom']; 
   //var_dump($idMatiere);
   $libSeq =   $libelleSequence;
  $libSequence = $_GET['libelleSeq'][0];
  $nbH_Total = $_GET['nbHTotal'];

  $stmt->execute() ;

 
  //var_dump($_GET['id']);
   //var_dump($_GET['nom']);
   // var_dump($_GET['debut']);
   //  var_dump($_GET['fin']);
     // var_dump($_GET['HTPPPN']);
      // var_dump($_GET['HTDPPN']);
        //var_dump($_GET['HCMPPN']);
         //var_dump($_GET['TDM']);
        // var_dump($_GET['heuresDeCM']);
//var_dump($_GET['heuresDeTD']);
//var_dump($_GET['heuresDeTP']);
       /*
$pdo = myPDO::getInstance() ;
$stmt2 = $pdo->prepare(<<<SQL
     SELECT idSequence FROM Sequence_Pedagogique WHERE idMatiere = :idMatiere AND libSequence = :idlibSequence
SQL
);

  $stmt2->bindParam(':idMatiere',$idMatiere);
  $stmt2->bindParam(':idlibSequence', $libSequence);
  
  $stmt2->execute();

   $tab;
    if (($ligne = $stmt2->fetch()) !== false) {
    $tab =  $ligne;
  }
            
    */

$pdo = myPDO::getInstance() ;
$stmt2 = $pdo->prepare(<<<SQL
     UPDATE Repartition
     SET idSemestre = :idSemestre, nbGroupe = :nbGroupe
     WHERE idSequence = (SELECT idSequence 
                          FROM Sequence_Pedagogique
                          WHERE libSequence = :libSeq
                          AND idMatiere = (SELECT idMatiere FROM Matiere WHERE libMatiere = :libMat)) 
SQL
);                      


$stmt2->bindParam(':libSeq',$libSeq);
$stmt2->bindParam(':idSemestre',$idSem);
$stmt2->bindParam(':nbGroupe',$nbGroupe);
$stmt2->bindParam(':libMat', $libMat);

//var_dump($tab);
$idSem = $idSemestre;
$libMat = $_GET['nom'];
//var_dump($tab) ;
//var_dump( substr($_GET['id'],1,1));
$libSeq = $_GET['libelleSeq'][0];
$nbGroupe = $_GET['nbGroupe'];
  
$stmt2->execute() ; 
        
      /* $a = 0;  
for($i=0 ; $i<sizeof($_GET['id']) ; $i++) {
//var_dump(" i : " + $i);
  

  $debut = $_GET['debut'][$i]; 
  $fin = $_GET['fin'] [$i];
  
 // var_dump($debut);
 // var_dump($fin);
  

    
    $debut_ts = strtotime($debut);
  $fin_ts = strtotime($fin);
  
  $numSemaine = date ('W', $debut_ts) ;
  $semaineFin = $numSemaine + nbSemaines($debut,$fin) ; 
  
  $numSemaine = date ('W', $debut_ts) ;
 //var_dump($numSemaine);
  $semaineFin = $numSemaine + nbSemaines($debut,$fin) ; 

 //var_dump($semaineFin);

  if($semaineFin <= NumberOfWeeksInAYear(date('Y',$debut_ts))) {
    $reste =0;
  }
  else {
  $reste = date ('W', $fin_ts) ;
  //$reste = $semaineFin%(NumberOfWeeksInAYear(date('Y',$debut_ts)));
  }

  //var_dump($reste);

  //TODO : le truc au dessus ne marche que si intervalle  < 1 an

  $semaines = array(); 

  $cpt = 0 ;

  for($ago = 1 ; $ago<=$reste ; $ago++){
    $semaines[$cpt] = (int)$ago ; 
    $cpt++ ;
  }

  for($ago = $numSemaine ; $ago<=$semaineFin ; $ago++){
    $semaines[$cpt] = (int)$ago ; 
    $cpt++ ;
  }
  //var_dump($semaines);
  $lesSemaines = str_repeat ('?, ',  count ($semaines) - 1) . '?';
  $pdo = myPDO::getInstance() ;


  $stmt = $pdo->prepare(<<<SQL
      SELECT *
      FROM Semaine
      WHERE idSemaine IN($lesSemaines)
SQL
);

$stmt -> execute($semaines);

  
    $cpt = 0 ; 
  $tab = array();
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
  }
  //var_dump($tab);
  
  //var_dump($i);
  //var_dump($_GET['id'][$i]);
  $idSemestre = substr($_GET['id'][$i],1,1);
  $idMod = $_GET['id'][$i];
  //var_dump($idMod);
   
  
  for($z = 0; $z < sizeof($tab); $z++) {
 // var_dump('hello');
 // var_dump($tab[$z]['idSemaine']);
  
    $nbHTP=$_GET['heuresDeTP'][$a];
  //var_dump($nbHTP);
    $nbHTD=$_GET['heuresDeTD'][$a];
    //var_dump($nbHTD);
  $nbCM=$_GET['heuresDeCM'][$a];
    //var_dump($nbCM);
  $a++;
  //var_dump($idSemestre);
   $idSemaine = $tab[$z]['idSemaine'];
  $stmt2->execute() ;
  }
 // var_dump('hhhehee' + $a);
  
}
*/
 
  $libelleSequence = substr($_GET['secret'], 0, 2);
	$identifiantMatiere = substr($_GET['secret'], 2, strlen($_GET['secret']));
  $idSemestre = substr($identifiantMatiere, 1, 1);
 // var_dump($libelleSequence);
  //var_dump($identifiantMatiere) ;
  //var_dump($idSemestre) ;
  
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT sp.nbH_Total,  m.demiSemestre, s.dateDebut, s.dateFin, s.dateMilieu
    FROM Repartition r, Semestre s, Sequence_Pedagogique sp, Matiere m
    WHERE sp.idSequence = r.idSequence
    AND r.idSemestre = s.idSemestre
    AND sp.idMatiere = :idMat
    AND sp.libSequence = :libSeq
    AND r.idSemestre = :idSem
    AND m.idMatiere = sp.idMatiere
SQL
);

$stmt->bindParam(':idMat',$identifiantMatiere);
$stmt->bindParam(':libSeq',$libelleSequence);
$stmt->bindParam(':idSem',$idSemestre);

    $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
      $tab[$cpt] =  $ligne;
      $cpt++ ; 
  }
  
     //var_dump($tab);
if(sizeof($tab) != 0) {
switch($tab[0]['demiSemestre']){
  case '0':
    $semestre = new DatePeriod(
        new DateTime($tab[0]['dateDebut']),
        new DateInterval('P1W'), 
        new DateTime($tab[0]['dateFin'])        
    );
    $tabSem = array();
    foreach ($semestre as $w) {
        array_push($tabSem,intval($w->format('W')));
    }
    break;
  case '1':  
    $semestre = new DatePeriod(
        new DateTime($tab[0]['dateDebut']),
        new DateInterval('P1W'), 
        new DateTime($tab[0]['dateMilieu'])        
    );
    $tabSem = array();
    foreach ($semestre as $w) {
        array_push($tabSem,intval($w->format('W')));
    }
    break;
  case '2':  
    $semestre = new DatePeriod(
        new DateTime($tab[0]['dateMilieu']),
        new DateInterval('P1W'), 
        new DateTime($tab[0]['dateFin'])        
    );
    $tabSem = array();
    foreach ($semestre as $w) {
        array_push($tabSem,intval($w->format('W')));
    }
    break;
   }
}

 ////
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
	 SELECT idSemaine 
   FROM Contenir
   WHERE idSemestre = :idSem
SQL
);

$stmt->bindParam(':idSem', $idSeeeem);

$idSeeeem = $idSemestre;

$stmt->execute();

    $tab5 = array() ;
    $cpt3 = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
    //var_dump($ligne) ;
     $tab5[$cpt3] = $ligne['idSemaine'];
      $cpt3++ ; 
  }
  
  $tablo = array_intersect($tabSem, $tab5);
  //var_dump($tablo);
  
  /////
$tour = intval($tab[0]['nbH_Total']/sizeof($tablo));
$tableau = array();
 foreach($tablo as $value) {
    $tableau[$value] = $tour;  
 }
 //var_dump($tableau);
 
 $reste =  intval($tab[0]['nbH_Total']%sizeof($tablo));
  //var_dump($reste);
 $cpt99 = 0;
foreach($tablo as $value) {
if($cpt99 == $reste ) {
  break;
}
    $tableau[$value] +=1; 
    $cpt99 ++;
 }
//var_dump($tableau);

$tableauFinal = array();
$cpt = 0;
foreach ($tableau as $key => $value){
    $tableauFinal[$cpt]['label'] = "Semaine " + $key;
    $tableauFinal[$cpt]['y'] = $tableau[$key];
    $cpt ++;
}

	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
	 SELECT idSequence 
   FROM Sequence_Pedagogique
   WHERE idMatiere = :idMat
   AND libSequence = :libSeq
SQL
);

$stmt->bindParam(':idMat', $idMat);
$stmt->bindParam(':libSeq',$libSeq);

$idMat = $identifiantMatiere;
$libSeq = $libelleSequence;

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
		DELETE From Diviser WHERE idSequence = :idSeq
SQL
);

$stmt->bindParam(':idSeq',$identifiantSequence);

     $identifiantSequence = $tab2[0]['idSequence'];
     $stmt -> execute();


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
                  
                   
header("refresh:2; module.php"); 
header('Content-type: text/html; charset=utf-8');
echo "La séquence pédagogique a bien été modifiée"; 
  
 } 
  
}