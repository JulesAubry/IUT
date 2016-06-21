 <?php

require_once "myPDO.include.php";

if(isset($_GET['id']) && !empty($_GET['id'])&& isset($_GET['lib']) && !empty($_GET['lib'])){
  $pdo = myPDO::getInstance() ;
  $stmt = $pdo->prepare(<<<SQL
    SELECT  *
    FROM Sequence_Pedagogique
    WHERE idMatiere = :idMatiere AND libSequence = :lib
SQL
);
$stmt->bindParam(':idMatiere',$_GET['id']);
$stmt->bindParam(':lib',$_GET['lib']);

$stmt->execute();

$matiere = array();
	
	while(($ligne = $stmt->fetch()) !== false){
		$matiere[] = $ligne;
	}
	
   	echo json_encode($matiere, JSON_PRETTY_PRINT);
}