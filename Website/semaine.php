<?php	
require_once 'myPDO.include.php' ;

session_start();

    function nbSemaines($debut, $fin) {
        //60 secondes X 60 minutes X 24 heures dans une journée
        $nbSecondes= 60*60*24;
 
        $debut_ts = strtotime($debut);
        $fin_ts = strtotime($fin);
        $diff = $fin_ts - $debut_ts;
        return ceil(round($diff / $nbSecondes)/7);
    }

    /* nombre de semaines dans une année $year */
    function NumberOfWeeksInAYear($year)
      {
	      $day = mktime(0,0,0, 12, 31, $year);
	      $week = date("W", $day);

	      if ($week == 1)
		      return 52;
	      else return $week;
      }
	
if(isset($_GET['id']) && isset($_GET['nom']) && isset($_GET['debut']) && isset($_GET['fin']) && isset($_GET['HTPPPN']) && isset($_GET['HTDPPN']) && isset($_GET['HCMPPN']) && isset($_GET['TDM'])
    && !empty($_GET['id']) && !empty($_GET['nom']) && !empty($_GET['debut']) && !empty($_GET['fin']) && !empty($_GET['HTPPPN']) && !empty($_GET['HTDPPN']) && !empty($_GET['HCMPPN']) && !empty($_GET['TDM'])){

  $debut = $_GET['debut'] ; 
  $fin = $_GET['fin'] ;
  $id = $_GET['id'];
  $nom = $_GET['nom'];
  $HTPPPN = $_GET['HTPPPN'];
  $HTDPPN = $_GET['HTDPPN'];
  $HCMPPN = $_GET['HCMPPN'];
  $TDM = $_GET['TDM'];

/*
var_dump($debut);
var_dump($fin);
var_dump($id);
var_dump($nom);
var_dump($HTPPPN);
var_dump($HTDPPN);
var_dump($HCMPPN);
var_dump($TDM);

$_SESSION[$id]['nom'] = $nom;
$_SESSION[$id]['debut'] = $debut;
$_SESSION[$id]['fin'] = $fin;
$_SESSION[$id]['HTPPPN'] = $HTPPPN;
$_SESSION[$id]['HTDPPN'] = $HTDPPN;
$_SESSION[$id]['HCMPPN'] = $HCMPPN;
$_SESSION[$id]['TDM'] = $TDM;*/

//var_dump($_SESSION);


  $debut = str_replace("/", "-",$debut);
  $fin = str_replace("/", "-",$fin);


  
$debut_ts = strtotime($debut);
$fin_ts = strtotime($fin);

/*
if(abs(date('Y',$debut_ts) - date('Y',$fin_ts)) > 1 ) {
header('Content-type: text/html; charset=utf-8');
echo "<script>alert(\"Intervalle max entre deux années : 1\")</script>" ;
}*/

$numSemaine = date ('W', $debut_ts) ;
// var_dump($numSemaine);
$semaineFin = $numSemaine + nbSemaines($debut,$fin) ; 

// var_dump($semaineFin);

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

for($i = 1 ; $i<=$reste ; $i++){
  $semaines[$cpt] = (int)$i ; 
  $cpt++ ;
}

for($i = $numSemaine ; $i<=$semaineFin ; $i++){
  $semaines[$cpt] = (int)$i ; 
  $cpt++ ;
}

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
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
}


//$_SESSION['']= 




echo json_encode($tab);

}
