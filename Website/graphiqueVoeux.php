<?php


session_start();

require_once "myPDO.include.php";

if(isset($_GET['id']) && !empty($_GET['id'])) {

	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT c.idSemaine AS "label", d.nbH_Semaine * v.nb_Desire AS "y"
    FROM Sequence_Pedagogique s, Voeux v, Diviser d, Semaine_Travaillee st, Contenir c 
    WHERE c.idSemaine = st.idSemaine
    AND st.idSemaine = d.idSemaine
    AND d.idSequence = s.idSequence
    AND v.idSequence = s.idSequence
    AND c.idSemestre = :idSem
    AND v.idIntervenant = :id
SQL
);
//$libelleSequence = substr($_GET['id'], 0, 2);
//$identifiantMatiere = substr($_GET['id'], 2, strlen($_GET['id']));
$idSemestre = $_GET['id'];


$stmt->bindParam(':id',$_SESSION['login']['idIntervenant']);
$stmt->bindParam('idSem', $idSemestre);
//$stmt->bindParam('idMat', $identifiantMatiere);
//$stmt->bindParam('libSequence', $libelleSequence);

    $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
  }
 // var_dump($tab);
  
$tabModif = array();
  foreach ($tab as $key => $value){
 // var_dump($key);
  //var_dump($value);
  if(array_key_exists($value['label'], $tabModif)) {
   $tabModif[$value['label']] += $value['y'] ;
  }
  else {
    $tabModif += [$value['label'] => $value['y'] ];
  }
 }    //$tabModif[$key][$value['label']] =>  '0';
      //$tabModif[$key][$value['y']] =>  ;
//$arr[$newkey] = $arr[$oldkey];
//unset($arr[$oldkey]);
 $tabFinal = array();
 $i = 0;
  foreach ($tabModif as $key => $value){
 // var_dump($key);
  //var_dump($value);
  $tab1 = array();
  $tab1['label'] = $key;
  $tab1['y'] = $value;
  $tabFinal += [$i => $tab1] ;
   $i ++;
}             
      
 echo json_encode($tabFinal, JSON_NUMERIC_CHECK);
 }