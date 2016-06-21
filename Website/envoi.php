<?php

require_once 'myPDO.include.php' ;



function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
  $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
  return $ret;
}

if(isset($_POST['tableSemaines']) && !empty($_POST['tableSemaines'])) {

$pdo = myPDO::getInstance() ;
$sql = "SELECT count(idSemaine) FROM Semaine_Travaillee"; 
$result = $pdo->prepare($sql);
$result->execute(); 


$number_of_rows = $result->fetchColumn(); 

    
      $string  = $_POST['tableSemaines'];
	  //var_dump($string);
	  
      $res = explode(",", $string);
      
    
               // var_dump($res);
  if($number_of_rows > 0) {
    $stmt = $pdo->prepare("DELETE FROM Semaine_Travaillee NOT IN('".implode("','",$res)."')");
  }
  
  
    $stmt = $pdo->prepare("INSERT INTO Semaine_Travaillee (idSemaine) VALUES (:Semaine_Travaillee) ON DUPLICATE KEY UPDATE idSemaine = :idSem");
    $stmt->bindParam(':Semaine_Travaillee', $Semaine_Travaillee);
     $stmt->bindParam(':idSem', $Semaine_Travaille);
     //var_dump($_POST['tableSemaines']);
     //var_dump(sizeof($_POST['tableSemaines']));
      
      //var_dump($res);
    
      $string  = $_POST['tableSemaines'];
	  //var_dump($string);
	  
      $res = explode(",", $string);
    for($i = 0; $i < sizeof($res) ; $i++) {

    
    $Semaine_Travaillee = $res[$i];
    $Semaine_Travaille  = $res[$i];
    $stmt->execute();
    
  }
  
  //Je récupére les dates des Semestre
  $pdo = myPDO::getInstance() ;
  $stmt = $pdo->prepare("SELECT dateDebut, dateMilieu, dateFin FROM Semestre");

    $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
  }
 // var_dump($tab);
  
  //Je supprime les données de la table contenir
    $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare("DELETE FROM CONTENIR");
    $stmt->execute();

    //Je vais remplir ma table contenir
$pdo = myPDO::getInstance() ;
$stmt = $pdo->prepare("INSERT INTO CONTENIR (idSemestre, idSemaine) VALUES (:Semestre, :Semaine)");
$stmt->bindParam(':Semestre', $Semestre);
$stmt->bindParam(':Semaine', $Semaine);

//Je récupére les weeks numbers de mes différents semestres
$semestre1 = new DatePeriod(
    new DateTime($tab[0]['dateDebut']),
    new DateInterval('P1W'), 
    new DateTime($tab[0]['dateFin'])        
);
$tabSem1 = array();
foreach ($semestre1 as $w) {
    array_push($tabSem1,$w->format('W'));
}    


$semestre2 = new DatePeriod(
    new DateTime($tab[1]['dateDebut']),
    new DateInterval('P1W'), 
    new DateTime($tab[1]['dateFin'])        
);
$tabSem2 = array();
foreach ($semestre2 as $w) {
    array_push($tabSem2, $w->format('W'));
}    


$semestre3 = new DatePeriod(
    new DateTime($tab[2]['dateDebut']),
    new DateInterval('P1W'), 
    new DateTime($tab[2]['dateFin'])        
);
$tabSem3 = array();
foreach ($semestre3 as $w) {
    array_push($tabSem3, $w->format('W'));
}    


$semestre4 = new DatePeriod(
    new DateTime($tab[3]['dateDebut']),
    new DateInterval('P1W'), 
    new DateTime($tab[3]['dateFin'])        
);
$tabSem4 = array();
foreach ($semestre4 as $w) {
    array_push($tabSem4, $w->format('W'));
}    

//var_dump($tabSem4) ;
//En fonction de la semaine, je regarde dans quel semestre elle est et je l'insére en fonction
 for($i = 0; $i < sizeof($res) ; $i++) {

    
    $Semaine = $res[$i];
    if(in_array($Semaine, $tabSem1)) {
          $Semestre = 1;
          $stmt->execute();
    }
    if(in_array($Semaine, $tabSem2)) {
          $Semestre = 2;
          $stmt->execute();
    }
    if(in_array($Semaine, $tabSem3)) {
          $Semestre = 3;
          $stmt->execute();
    }
    if(in_array($Semaine, $tabSem4)) {
          $Semestre = 4;
          $stmt->execute();
    }
    
  }
           
header("refresh:2; admin.php"); 
header('Content-type: text/html; charset=utf-8');
echo "Le calendrier est désormais à jour "; 

}