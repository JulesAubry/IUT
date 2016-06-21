<?php
                 
session_start();

if(isset($_SESSION['voeux']['saisie']) && !empty($_SESSION['voeux']['saisie'])){
	
	$type = array("CM","TD","TP");
	
	//Remise à zéro
	for($i=1; $i<5; $i++){
		foreach($_SESSION['voeux']['graph']["S".$i] as $semaine=>$value){
			$_SESSION['voeux']['graph']["S".$i][$semaine] = 0;
		}
	}
	$valeurCM = 0;
	foreach($_SESSION['voeux']['saisie'] as $id=>$module){
		if(substr($id, 1, 1) == "1"){
			if(isset($module["CM"])){
				$valeurCM = $module["CM"];
			}
			foreach($_SESSION['voeux']['infos'][$id] as $semaine=>$value){
				foreach($type as $t){
					if(isset($module[$t])){
						if($t == "CM"){
							if($valeurCM >= $value[$t]){
								$_SESSION['voeux']['graph']["S1"][$semaine] += $value[$t];
								$valeurCM -= $value[$t];
							}
							else{
								$_SESSION['voeux']['graph']["S1"][$semaine] += $valeurCM;
								$valeurCM = 0;
							}
						}
						else{
							$_SESSION['voeux']['graph']["S1"][$semaine] += $module[$t] * $value[$t];
						}
					}
				}
			}
		}
		if(substr($id, 1, 1) == "2"){
			if(isset($module["CM"])){
				$valeurCM = $module["CM"];
			}
			foreach($_SESSION['voeux']['infos'][$id] as $semaine=>$value){
				foreach($type as $t){
					if(isset($module[$t])){
						if($t == "CM"){
							if($valeurCM >= $value[$t]){
								$_SESSION['voeux']['graph']["S2"][$semaine] += $value[$t];
								$valeurCM -= $value[$t];
							}
							else{
								$_SESSION['voeux']['graph']["S2"][$semaine] += $valeurCM;
								$valeurCM = 0;
							}
						}
						else{
							$_SESSION['voeux']['graph']["S2"][$semaine] += $module[$t] * $value[$t];
						}
					}
				}
				$_SESSION['voeux']['graph']['total'] += $_SESSION['voeux']['graph']["S2"][$semaine];
			}
		}
		if(substr($id, 1, 1) == "3"){
			if(isset($module["CM"])){
				$valeurCM = $module["CM"];
			}
			foreach($_SESSION['voeux']['infos'][$id] as $semaine=>$value){
				foreach($type as $t){
					if(isset($module[$t])){
						if($t == "CM"){
							if($valeurCM >= $value[$t]){
								$_SESSION['voeux']['graph']["S3"][$semaine] += $value[$t];
								$valeurCM -= $value[$t];
							}
							else{
								$_SESSION['voeux']['graph']["S3"][$semaine] += $valeurCM;
								$valeurCM = 0;
							}
						}
						else{
							$_SESSION['voeux']['graph']["S3"][$semaine] += $module[$t] * $value[$t];
						}
					}
				}
			}
		}
	$valeurCM = 0;
		if(substr($id, 1, 1) == "4"){
			if(isset($module["CM"])){
				$valeurCM = $module["CM"];
			}
			foreach($_SESSION['voeux']['infos'][$id] as $semaine=>$value){
				foreach($type as $t){
					if(isset($module[$t])){
						if($t == "CM"){
							if($valeurCM >= $value[$t]){
								$_SESSION['voeux']['graph']["S4"][$semaine] += $value[$t];
								$valeurCM -= $value[$t];
							}
							else{
								$_SESSION['voeux']['graph']["S4"][$semaine] += $valeurCM;
								$valeurCM = 0;
							}
						}
						else{
							$_SESSION['voeux']['graph']["S4"][$semaine] += $module[$t] * $value[$t];
						}
					}
				}
			}
		}
	}
	
	//Calcul total
	$_SESSION['voeux']['graph']['total'] = 0;
	for($i=1; $i<5; $i++){
		foreach($_SESSION['voeux']['graph']["S".$i] as $semaine=>$value){
			$_SESSION['voeux']['graph']['total'] += $_SESSION['voeux']['graph']["S".$i][$semaine];
		}
	}
}