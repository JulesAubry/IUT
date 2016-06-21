 <?php

require_once "myPDO.include.php";

if(isset($_GET['id']) && !empty($_GET['id'])){
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT  *
		FROM Module
		WHERE idModule = :id
SQL
);
$stmt->bindParam(':id',$_GET['id']);

  $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
  }
  echo json_encode($tab,JSON_PRETTY_PRINT);
}