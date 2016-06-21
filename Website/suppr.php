<?php

require_once "myPDO.include.php";

if(isset($_GET['id']))
{                        
    $pdo = myPDO::getInstance() ;
    $stmt = $pdo->prepare(<<<SQL
    DELETE FROM Sequence_Pedagogique
    WHERE idMatiere = :id
    AND libSequence = :seq
SQL
);
    
	$id = substr($_GET['id'], 2); //Récupération du libellé de la séquence (CM, TP, TD ou PB)
	$seq = substr($_GET['id'], 0, 2); //Récupération de l'id de la matière concernée
    
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':seq', $seq);
	$stmt->execute();
}