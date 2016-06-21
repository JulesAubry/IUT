<?php

require_once 'myPDO.include.php' ;

//TODO : VERIFIER SI LES MODULES EXISTENT !!!!!!
//TODO : Faire la meme chose pour les profs : copier coller ce sript + function js qui récupére à l'identique le fichier csv pour les profs
//TODO : HEADER


function readCSV($csvFile)
{
	
	$file_handle = fopen($csvFile, 'r');
	while (!feof($file_handle) ) {
		$line_of_text[] = fgetcsv($file_handle, 1024);
	}
	fclose($file_handle);
	return $line_of_text;

}

//var_dump($_GET['data']);


if(isset($_GET['data']) && !empty ($_GET['data'])){


//var_dump($_FILES['textfield1']['name']);
	/*
    $csv = readCSV($_GET['data'['textfield1']['name']]);
    for($i = sizeof($csv)-1; $i>=0; $i--) {
      if (strlen(implode($csv[$i])) == 0)  {
	unset($csv[$i]);
      }
*/    
$data = $_GET['data'];

$pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
      DELETE FROM Matiere
      WHERE idMatiere = :idMatiere
SQL
);

//var_dump($csv);



$stmt->bindParam(':idMatiere', $idMatiere);
foreach($_GET['data'] as $key=>$value)
{
	if($key > 0 ) {

	$idMatiere = $value[0];
	$stmt->execute();
	}
}

 

 
 $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
      INSERT INTO Matiere(idMatiere, libMatiere, demiSemestre, nbHCM_PPN, nbHTD_PPN, nbHTP_PPN)
      VALUES(:idMatiere, :libMatiere, :demiSemestre ,:nbHCM_PPN, :nbHTD_PPN, :nbHTP_PPN)
SQL
);

$stmt->bindParam(':idMatiere', $idMatiere);
$stmt->bindParam(':libMatiere',$libMatiere);
$stmt->bindParam(':demiSemestre',$demiSemestre);
$stmt->bindParam(':nbHCM_PPN',$nbHCM_PPN);
$stmt->bindParam(':nbHTD_PPN',$nbHTD_PPN);
$stmt->bindParam(':nbHTP_PPN',$nbHTP_PPN);

//PARSER LE $_FILES EN ARRAY

    //var_dump($csv);

   for($i = 1; $i< sizeof($data); $i++) {
   		//var_dump($data[$i]);
   		$idMatiere = $data[$i][0];
	    $libMatiere=$data[$i][1] ;
	    $demiSemestre=$data[$i][5] ;
	      $nbHCM_PPN=$data[$i][2] ; 
	      $nbHTD_PPN=$data[$i][3] ; 
	      $nbHTP_PPN=$data[$i][4] ;
	      //var_dump($HCM_PPN);
	      $idSemestre = $data[$i][6];
	      //$TDM = ($csv[$i][5] == '1') ? true : false;
	      //var_dump($data[$i][5]);
	    $stmt->execute();
	 }

////////////////////////////////////////////////////
$pdo = myPDO::getInstance();
$stmt = $pdo->prepare(<<<SQL
	INSERT INTO Sequence_Pedagogique(idSequence, idMatiere, libSequence, nbH_Total)
	VALUES(:idSequence, :idMatiere, :libSequence, :nbH_Total)
SQL
);

$stmt->bindParam(':idSequence', $idSequence);
$stmt->bindParam(':idMatiere', $idMatiere);
$stmt->bindParam(':libSequence', $libSequence);
$stmt->bindParam(':nbH_Total', $nbH_Total);

for($i = 1; $i < sizeof($data); $i++)
{
	$idMatiere = $data[$i][0];
	$libSequence = $data[$i][7];
	$nbH_Total = $data[$i][8];
	$stmt->execute();
}
///////////////////////////////////////////////////


/*
$pdo = myPDO::getInstance();
$stmt = $pdo->prepare(<<<SQL
	INSERT INTO Diviser(idSequence, idSemaine, nbH_Semaine)
	VALUES(:idSequence, :idSemaine, :nbH_Semaine)
SQL
);
$stmt->bindParam(':idSequence', $idSequence);
$stmt->bindParam('idSemaine', $idSemaine);
$stmt->bindParam('nbH_Semaine', $nbH_Semaine);

for($i = 1; $i < sizeof($data); $i++)
{
	$idSequence = $data[$i][7];
	$idSemaine = $data[$i][10];
	$nbH_Semaine = $data[$i][11];
	$stmt->execute();
}*/
//////////////////////////////////////////////////

$pdo = myPDO::getInstance();
$stmt = $pdo->prepare(<<<SQL
	INSERT INTO Repartition(idSequence, idSemestre, nbGroupe)
	VALUES(:idSequence, :idSemestre, :nbGroupe)
SQL
);
$stmt->bindParam(':idSequence', $idSequence);
$stmt->bindParam('idSemestre', $idSemestre);
$stmt->bindParam('nbGroupe', $nbGroupe);

for($i = 1; $i < sizeof($data); $i++)
{


	$pdo = myPDO::getInstance();
	$stmt2 = $pdo->prepare(<<<SQL
		SELECT idSequence FROM Sequence_Pedagogique WHERE idMatiere = :idMat AND libSequence = :libSeq
SQL
	);
	$stmt2->bindParam(':idMat', $idMat);
	$stmt2->bindParam('libSeq', $libSeq);


		$idMat = $data[$i][0];	
		$libSeq = $data[$i][7];

		$tab = array() ;
	    $stmt2 -> execute();
	    $cpt = 0 ; 
	    while (($ligne = $stmt2->fetch()) !== false) {
	      $tab[$cpt] =  $ligne;
	      $cpt++ ; 
	  	}
	  
	  	$idSequence = $tab[0]['idSequence'];
	  	$idSemestre = $data[$i][5];
		$nbGroupe = $data[$i][10];
		//var_dump($idSequence);
		$stmt->execute();

	
}

/////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////

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

$stmt->bindParam(':idMat',$idMatiere);
$stmt->bindParam(':libSeq',$libSequence);
$stmt->bindParam(':idSem',$idSemestre);

    $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
      $tab[$cpt] =  $ligne;
      $cpt++ ; 
  }
  
    // var_dump($tab);
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
        array_push($tabSem,$w->format('W'));
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
        array_push($tabSem,$w->format('W'));
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
        array_push($tabSem,$w->format('W'));
    }
    break;
   }
}

//var_dump($tabSem);

$tour = intval($tab[0]['nbH_Total']/sizeof($tabSem));
$tableau = array();
 for($i = 0 ; $i < sizeof($tabSem); $i++) {
    $tableau[$tabSem[$i]] = $tour;  
 }
 
 $reste =  intval($tab[0]['nbH_Total']%sizeof($tabSem));
  for($i = 0 ; $i < $reste; $i++) {
    $tableau[$tabSem[$i]] += 1;  
}

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

$idMat = $idMatiere;
$libSeq = $libSequence;

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
			INSERT INTO Diviser(idSequence, idSemaine, nbH_Semaine)
	VALUES(:idSequence, :idSemaine, :nbH_Semaine)
SQL
);
$stmt->bindParam(':idSequence', $idSequence);
$stmt->bindParam('idSemaine', $idSemaine);
$stmt->bindParam('nbH_Semaine', $nbH_Semaine);

//var_dump($tableau);
foreach ($tableau as $key => $value){
     $idSemaine = $key;
     $nbH_Semaine = $tableau[$key];
     $idSequence = $tab2[0]['idSequence'];
     $stmt -> execute();
/*
     	$idSequence = $data[$i][7];
	$idSemaine = $data[$i][10];
	$nbH_Semaine = $data[$i][11];
	$stmt->execute();*/
}
}