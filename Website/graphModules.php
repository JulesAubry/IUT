<?php

require_once "myPDO.include.php";
session_start();

if(isset($_GET['id'])&&!empty($_GET['id'])){

	header("content-type:image/png");
	
	// Récupération
	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT nbH_Semaine, idSequence
		FROM Diviser
		WHERE idSequence = :id
SQL
);
	$stmt->execute(array('id'=>$_GET['id']));
	
	$sequence = array();
	$sequence["Sequence"] = 0;
	
	while(($ligne = $stmt->fetch()) !== false)
	{

		$sequence["NbSeq"] += $ligne['NbSeq'];
	}
	
	$stmt = $pdo->prepare(<<<SQL
		SELECT idIntervenant, nb_Desire, nb_Depanne
		FROM Voeux
		ORDER BY 1
SQL
);
	$stmt->execute();
	
	$valueSeqq = array();
	
	while(($ligne = $stmt->fetch()) !== false)
	{
		if($ligne['idSequence'] == 0) //CM
		{
			$valueCMDesire[$ligne['idIntervenant']['CM']] = $ligne['nb_Desire'];
			$valueCMDepanne[$ligne['idIntervenant']['CM']] = $ligne['nb_Depanne'];
		}
		else if($_GET['idSequence'] == 1) //TD
		{
			$valueTDDesire[$ligne['idIntervenant']['TD']] = $ligne['nb_Desire'];
			$valueTDDepanne[$ligne['idIntervenant']['TD']] = $ligne['nb_Depanne'];
		}
		else if($_GET['idSequence'] == 2) //TP
		{
			$valueTPDesire[$ligne['idIntervenant']['TP']] = $ligne['nb_Desire'];
			$valueTPDepanne[$ligne['idIntervenant']['TP']] = $ligne['nb_Depanne'];
		}
		else if($_GET['idSequence'] == 3) //Période Bloquée
		{
			$valuePBDesire[$ligne['idIntervenant']['PB']] = $ligne['nb_Desire'];
			$valuePBDepanne[$ligne['idIntervenant']['PB']] = $ligne['nb_Depanne'];
		}
		//$valueTD[$ligne['idProf']] = $ligne['TD']*$modules['TD'];
	}
	
	$stmt = $pdo->prepare(<<<SQL
		SELECT I.idIntervenant, I.nom
		FROM Intervenant I, Voeux V, Sequence_Pedagogique S, Matière M
		WHERE I.idIntervenant = V.idIntervenant
		AND V.idSequence = S.idSequence
		AND S.idMatiere = M.idMatiere
		AND S.idSequence = :id
		ORDER BY 2
SQL
);
	$stmt->bindParam(':id', $_GET['id']) ;
	
	$stmt->execute();
	$array = array();
	
	while(($ligne = $stmt->fetch()) !== false)
		$array[$ligne['idIntervenant']] = $ligne['nom'];
	
	$size = count($array);
 
	// Set the enviroment variable for GD
	putenv('GDFONTPATH=' . realpath('.'));

	// Name the font to be used (note the lack of the .ttf extension)
	$font = 'arial';
	
	// Taille de l'image  
	$image = @imagecreate (1000, 344) ;
     
	// Couleur de fond  
	$fond = ImageColorAllocate ($image, 230, 230, 230);
     
	// Couleur des axes, des lignes et des legendes  
	$coul_axes = ImageColorAllocate ($image, 0, 0, 0);
	$coul_lignes = ImageColorAllocate ($image, 255, 255, 255);
	$coul_legendes = ImageColorAllocate ($image, 0, 0, 0);
     
	// Couleur des barres du graphique   
	$coul_barre1 = ImageColorAllocate ($image, 42, 124, 94);
	$coul_barre2 = ImageColorAllocate ($image, 0, 38, 131);
	$coul_barre3 = ImageColorAllocate ($image, 100, 38, 131);
	
	//Couleur texte
	$coul_valeur = ImageColorAllocate ($image, 255, 255, 255);
	$coul_semaine = ImageColorAllocate ($image, 0, 0, 0);
     
	 // Axe verticale et axe horizontale  
	imageline ($image, 30, 30, 30, 314, $coul_axes);
	imageline ($image, 30, 314, 900, 314, $coul_axes);
     
	// Création des polygone, ici un rectangle, d'ordonnes et d'abcisse  
	$tab_fleche_ord = array(30, 30, 26, 34, 34, 34);
	imagefilledpolygon ($image, $tab_fleche_ord, 3, $coul_axes);
     
	// Création d'un polygone, ici un rectangle, d'abscisse (en bas à droite)  
	$tab_fleche_abs = array(900, 314, 896, 310, 896, 318);
	imagefilledpolygon ($image, $tab_fleche_abs, 3, $coul_axes);
     
	// Legende de l'abscisse et de l'ordonnees   
	imagettftext($image,10,0,5,20,$coul_legendes,$font,"Heures");
	imagettftext($image,10,0,910,318,$coul_legendes,$font,"Intervenants");
     
    
	// Trait blanc permettant une meilleur lisibilite des graphique  
	imageline ($image, 31, 280, 900, 280, $coul_lignes);
	imageline ($image, 31, 250, 900, 250, $coul_lignes);
	imageline ($image, 31, 220, 900, 220, $coul_lignes);
	imageline ($image, 31, 190, 900, 190, $coul_lignes);
	imageline ($image, 31, 160, 900, 160, $coul_lignes);
	imageline ($image, 31, 130, 900, 130, $coul_lignes);
	imageline ($image, 31, 100, 900, 100, $coul_lignes);
	imageline ($image, 31, 70, 900, 70, $coul_lignes);
     
	// L'axe des ordonnees, en haut à gauche, dispose d'une graduation de 0 à 20  
	imageline ($image, 26, 280, 30, 280, $coul_axes);
	imageline ($image, 26, 250, 30, 250, $coul_axes); 
	imageline ($image, 26, 220, 30, 220, $coul_axes); 
	imageline ($image, 26, 190, 30, 190, $coul_axes);
	imageline ($image, 26, 160, 30, 160, $coul_axes);
	imageline ($image, 26, 130, 30, 130, $coul_axes); 
	imageline ($image, 26, 100, 30, 100, $coul_axes); 
	imageline ($image, 26, 70, 30, 70, $coul_axes); 	
     
	// Legende des graduation de l'ordonnes, en haut à gauche  
	imagettftext($image,8,0,15,314,$coul_legendes,$font,"0");
	imagettftext($image,8,0,15,284,$coul_legendes,$font,"5");
	imagettftext($image,8,0,9,254,$coul_legendes,$font,"10");
	imagettftext($image,8,0,9,224,$coul_legendes,$font,"15 ");
	imagettftext($image,8,0,9,194,$coul_legendes,$font,"20");
	imagettftext($image,8,0,9,164,$coul_legendes,$font,"25");
	imagettftext($image,8,0,9,134,$coul_legendes,$font,"30");
	imagettftext($image,8,0,9,104,$coul_legendes,$font,"35");
	imagettftext($image,8,0,9,74,$coul_legendes,$font,"40");
	
	//Legende
	imagefilledrectangle ($image, 930, 140, 940, 150, $coul_barre1);
	ImageTTFText ($image,10,0,945,150,$coul_legendes,$font,"CM");
	imagefilledrectangle ($image, 930, 160, 940, 170, $coul_barre2);
	ImageTTFText ($image,10,0,945,170,$coul_legendes,$font,"TD");
	imagefilledrectangle ($image, 930, 180, 940, 190, $coul_barre3);
	ImageTTFText ($image,10,0,945,190,$coul_legendes,$font,"TP");
	
	// Création de la barres graphiques S1 & S3
	$width = (845-($size*10))/$size;
	$origin = 314;
	$height1 = 314;
	$height2 = 314;
	$height3 = 314;
	$value1 = 0;
	$value2 = 0;
	$value3 = 0;
	$pos1 = 40;
	$pos2 = $pos1+$width;
	
	foreach($array as $id=>$nom){
		
		ImageTTFText ($image,7,0,$pos2-(($width/2)+23),330,$coul_semaine,$font,$nom);
		
		//Barre CM
		if(isset($valueCM[$id])){
			$value1 = $valueCM[$id];
			$height1 -= (6*$value1)+4;
			imagefilledrectangle ($image, $pos1, $height1, $pos2, 314, $coul_barre1);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height1+$origin+11)/2,$coul_valeur,$font,$value1);
		}
		    
		//Barre TD
		if(isset($valueTD[$id])){
			$value2 = $valueTD[$id];
			$height2 -= (6*($value2+$value1))+4;
			imagefilledrectangle ($image, $pos1, $height2, $pos2, $height1, $coul_barre2);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height2+$height1+11)/2,$coul_valeur,$font,$value2);
		}
		
		//Barre TP
		if(isset($valueTP[$id])){
			$value3 = $valueTP[$id];
			$height3 -= (6*($value3+$value2+$value1))+4;
			imagefilledrectangle ($image, $pos1, $height3, $pos2, $height2, $coul_barre3);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height3+$height2+11)/2,$coul_valeur,$font,$value3);
		}
		
		$height1 = 314;
		$height2 = 314;
		$height3 = 314;
		$value1 = 0;
		$value2 = 0;
		$value3 = 0;
		$pos1 = $pos2+10;
		$pos2 = $pos1+$width;
	}

	// Création de l'image  
	imagePng ($image);
}
?>
