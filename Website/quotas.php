<?php

require_once "myPDO.include.php";

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
            SELECT s.nbHMin - d.decharge AS "nbH", de.nbH_Semaine * v.nb_Desire AS "nbDesire"
            FROM Intervenant i, Statut s, Decharge d, Voeux v, Annee a, Diviser de , Semaine_Travaillee st
            WHERE i.idStatut = s.idStatut
            AND d.idIntervenant = i.idIntervenant
            AND i.idIntervenant = :id
            AND v.idIntervenant = i.idIntervenant
            AND a.idAnnee = d.idAnnee
            AND a.idAnnee = :idAn
            AND de.idSequence = v.idSequence
            AND de.idSemaine = st.idSemaine
SQL
);
  $stmt->execute(array('id'=>$_POST['id'], 'idAn' => date('Y')));
  
    $jsonModules = array();
    
    while(($ligne = $stmt->fetch()) !== false){
		$jsonModules[] = $ligne;
	}	
  
	//var_dump($jsonModules);

   
    
    echo json_encode($jsonModules, JSON_PRETTY_PRINT);
}