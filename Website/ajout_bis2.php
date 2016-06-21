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
      DELETE FROM Intervenant
      WHERE idIntervenant = :idIntervenant 
SQL
);

//var_dump($csv);



$stmt->bindParam(':idIntervenant', $idIntervenant);
foreach($_GET['data'] as $key=>$value)
{
	if($key > 0 ) {

	$idMatiere = $value[0];
	$stmt->execute();
	}
}

 

 
 $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
      INSERT INTO Intervenant(idIntervenant, idStatut, loginLDAP, pass, nom, prenom, admin)
      VALUES(:idIntervenant, :idStatut, :loginLDAP ,:pass, :nom, :prenom, :admin)
SQL
);

$stmt->bindParam(':idIntervenant', $idIntervenant);
$stmt->bindParam(':idStatut',$idStatut);
$stmt->bindParam(':loginLDAP',$loginLDAP);
$stmt->bindParam(':pass',$pass);
$stmt->bindParam(':nom',$nom);
$stmt->bindParam(':prenom',$prenom);
$stmt->bindParam(':admin', $admin)

//PARSER LE $_FILES EN ARRAY

    //var_dump($csv);

for($i = 1; $i< sizeof($data); $i++) {
		//var_dump($data[$i]);
		$idIntervenant = $data[$i][0];
    $idStatut=$data[$i][1] ;
    $loginLDAP=$data[$i][2] ;
      $pass=$data[$i][3] ; 
      $nom=$data[$i][4] ; 
      $prenom=$data[$i][5] ;
      $admin = $data[$i][6];
    $stmt->execute();
 }
