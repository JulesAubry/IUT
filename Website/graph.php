<?php

session_start();

if(isset($_SESSION['voeux']['graph'])&&!empty($_SESSION['voeux']['graph'])){

	header("content-type:image/png");

	// Récupération
	if(isset($_SESSION['voeux']['graph']['S1'])){
		$arrayS1 = $_SESSION['voeux']['graph']['S1'];
	}
	else{
		$arrayS1 = array();
	}
	if(isset($_SESSION['voeux']['graph']['S2'])){
		$arrayS2 = $_SESSION['voeux']['graph']['S2'];
	}
	else{
		$arrayS2 = array();
	}
	if(isset($_SESSION['voeux']['graph']['S3'])){
		$arrayS3 = $_SESSION['voeux']['graph']['S3'];
	}
	else{
		$arrayS3 = array();
	}
	if(isset($_SESSION['voeux']['graph']['S4'])){
		$arrayS4 = $_SESSION['voeux']['graph']['S4'];
	}
	else{
		$arrayS4 = array();
	}

	$array = $_SESSION['voeux']['graph']['semaines'];
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
	$coul_barre2 = ImageColorAllocate ($image, 0, 90, 94);
	$coul_barre3 = ImageColorAllocate ($image, 0, 38, 131);
	$coul_barre4 = ImageColorAllocate ($image, 100, 38, 131);
	
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
	imagettftext($image,10,0,910,318,$coul_legendes,$font,"Semaines");
     
    
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
	ImageTTFText ($image,10,0,945,150,$coul_legendes,$font,"S1");
	imagefilledrectangle ($image, 930, 160, 940, 170, $coul_barre2);
	ImageTTFText ($image,10,0,945,170,$coul_legendes,$font,"S2");
	imagefilledrectangle ($image, 930, 180, 940, 190, $coul_barre3);
	ImageTTFText ($image,10,0,945,190,$coul_legendes,$font,"S3");
	imagefilledrectangle ($image, 930, 200, 940, 210, $coul_barre4);
	ImageTTFText ($image,10,0,945,210,$coul_legendes,$font,"S4");
	
	// Création de la barres graphiques S1 & S3
	$width = (845-($size*10))/$size;
	$origin = 314;
	$height1 = 314;
	$height2 = 314;
	$value1 = 0;
	$value2 = 0;
	$pos1 = 40;
	$pos2 = $pos1+$width;
	
	foreach($array as $semaine){
		
		ImageTTFText ($image,10,0,$pos2-(($width/2)+5),330,$coul_semaine,$font,$semaine);
		
		//Barre S1
		if(isset($arrayS1[$semaine])){
			$value1 = $arrayS1[$semaine];
			$height1 -= (6*$value1)+4;
			imagefilledrectangle ($image, $pos1, $height1, $pos2, 314, $coul_barre1);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height1+$origin+11)/2,$coul_valeur,$font,$value1);
		}
		    
		//Barre S3
		if(isset($arrayS3[$semaine])){
			$value2 = $arrayS3[$semaine];
			$height2 -= (6*($value2+$value1))+4;
			imagefilledrectangle ($image, $pos1, $height2, $pos2, $height1, $coul_barre2);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height2+$height1+11)/2,$coul_valeur,$font,$value2);
		}
		
		$height1 = 314;
		$height2 = 314;
		$value1 = 0;
		$value2 = 0;
		
		//Barre S2
		if(isset($arrayS2[$semaine])){
			$value1 = $arrayS2[$semaine];
			$height1 -= (6*$value1)+4;
			imagefilledrectangle ($image, $pos1, $height1, $pos2, 314, $coul_barre3);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height1+$origin+11)/2,$coul_valeur,$font,$value1);
		}
		    
		//Barre S4
		if(isset($arrayS4[$semaine])){
			$value2 = $arrayS4[$semaine];
			$height2 -= (6*($value2+$value1))+4;
			imagefilledrectangle ($image, $pos1, $height2, $pos2, $height1, $coul_barre4);
			ImageTTFText ($image,10,0,$pos2-(($width/2)+5),($height2+$height1+11)/2,$coul_valeur,$font,$value2);
		}
		    
		$height1 = 314;
		$height2 = 314;
		$value1 = 0;
		$value2 = 0;
		$pos1 = $pos2+10;
		$pos2 = $pos1+$width;
	}

	// Création de l'image  
	imagePng ($image);
}
?>