<?php	

//05/01/2015 -> Rencontre avec le directeur qui nous a dit de mettre Aout tout à gauche

	$joursTravaillés = array() ;
	
	

	$newDate = New DateTime();
	$year = $newDate->format("Y");

	// mise en memoire des jours de la semaine et des mois de l'annee dans un tableau
	$aDayOfWeek = array("Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim");
	$aMonth = array("Aout","Septembre", "Octobre", "Novembre", "Decembre", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet");
	
	// creation d'une date temporaire en fonction du parametre annee recu
	$newDate = New DateTime();
	$newDate->setDate($year, 9, 1);
	
	if ($newDate->format("L")+1 == 1) { // si l'annee est bissextile, mise en memoire des nombres de jours par mois de l'annee (avec 29 a fevrier)
		$aMonthDays = array("31","30", "31", "30", "31", "31", "29", "31", "30", "31", "30", "31");
	}
	else { // sinon, mise en memoire des nombres de jours par mois de l'annee (avec 28 a fevrier)
		$aMonthDays = array("31","30", "31", "30", "31", "31", "28", "31", "30", "31", "30", "31");
	}
	
$html=<<<HTML
  <html>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<head>
		<title>Calendrier</title>
		
		<style type="text/css">
			<!--
				#calendar {padding:0; margin:0; border-top:1px solid black; border-left:1px solid black; border-right:1px solid black;}
				#calendar th {border:1px solid black; border-bottom:2px solid black}
				#calendar td {padding-left:3px; padding-right:3px}
				#calendar td.dayOfWeek {border-left:1px solid black; background-color:white;}
				#calendar td.day {text-align: right; background-color:white;}
				#calendar td.week {border-right:1px solid black; font-weight:bold; background-color:white;}
				#calendar td.endOfMonth {border-bottom:2px solid black; background-color:white;}
				body {width:100%}
				
			 -->
		</style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
    
    	<script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
   	<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<script type="text/javascript" src="js/calendrier.js"></script>
		<script type="text/javascript">
        function test() {
           console.log($('td').attr("onClick"));
        }
		    function getColor(element) {
		      localStorage.setItem("couleur", element);
		    }
		    
		    function changeColor(element){
		       element.style.backgroundColor = localStorage.getItem("couleur") ;
		    }
		    
		     function nom() {
			var cells = document.getElementById("calendar").getElementsByTagName('td');
			//console.log(i);
			var tablo = Array();
			var z =0;
			for (var i = 0; i < cells.length; i++) { 
			//console.log(cells[i]);
			      status = cells[i].className;
			      if(status == "week travail" ||status == "week travail endOfMonth" ) 
			     // console.log(status);	
			      if (!isNaN(cells[i].innerHTML)  & cells[i].style.backgroundColor == 'white' ) {
			      
			       //console.log(cells[i].innerHTML) ;
			    tablo[z] = cells[i].innerHTML;
			       //console.log(cells[i].style.backgroundColor);// == 'white'
			       z++;
			      }
			        
			  }
			  tablo.sort();
			  
			  console.log(tablo.toString());
			  document.getElementById("letablodesemaine").value = tablo;
			  
		    }	    
		    function sauvegarderCodeHTML() {
			//console.log($('body').html());
			var hello = $('body').html();
			localStorage.setItem('codeHTML', hello);
						
			//$('body').html("coucou");
		    }
		    function restaurationCalendrier() {
		      if(localStorage.getItem('codeHTML') != null) {
				$('body').html(localStorage.getItem('codeHTML'));
		      }
		    }

		</script> 
	</head>
	<body onload='restaurationCalendrier()'>
  '<center><button onclick="ajout()"> Definir date semestres </button> <div id="dialog"></div></center>
  
	           <a href="index.php" > <img src="img/bouton_accueil.png" width="50" height="50" style="margin-right : 90%"> </img>  </a>
		<center>
    
     
HTML;
$html.="<table name='general'><td>";
$html.="<h2 style=' text-align : center'>Année scolaire ".($year)."-".($year+1)."</h2>" ;
$html.="<table id='calendar' cellpadding='0' cellspacing='0' border='0' display='inline'><thead><tr>" ;

for ($m=0; $m<12; $m++) { 
  $html.="<th colspan='3'>".$aMonth[$m]."</th>" ;
}

$html.="</tr></thead><tbody>" ;


for ($d=1; $d<=31; $d++) {
  $html.="<tr>";
  
  for ($m=7; $m<12; $m++) { 
	$newDate = New DateTime(); 
	$newDate->setDate($year,($m+1), $d);
	$dayOfWeek = $newDate->format("N")-1; 
	$travail = ((($dayOfWeek==0 or $dayOfWeek==1 or $dayOfWeek==2 or $dayOfWeek==3 or $dayOfWeek==4 or $dayOfWeek==5 or $dayOfWeek==6) and $d <=[$m-7])?" travail":"");
	$endOfMonth = (($d==31)?" endOfMonth":""); 
	if ($d <= $aMonthDays[$m-7])  {  
		$html.="<td class='dayOfWeek".$travail.$endOfMonth."' style=\"background-color:white;\" >".$aDayOfWeek[$dayOfWeek]."</td>" ;						
		$html.="<td class='day".$travail.$endOfMonth."'  style=\"background-color:white;\" >".$d."&nbsp</td>" ;
		$html.="<td class='week".$travail.$endOfMonth."' onclick='changeColor(this);'  style=\"background-color:white;\">". 
        
		    (($dayOfWeek==0 or ($d==1 and $m==0))?$newDate->format("W")/*NUmeros de semaine*/:"&nbsp;")."</td>" ;  
	} 
	else { 
		$html.="<td class='dayOfWeek".$travail.$endOfMonth."' colspan='2'  style=\"background-color:white;\">&nbsp</td>" ;
		$html.="<td class='week".$travail.$endOfMonth."' onclick='changeColor(this)'  style=\"background-color:white;\">&nbsp; </td>" ; 
	} 
}

						
  for ($m=0; $m<7; $m++) { 
	$newDate = New DateTime(); 
	$newDate->setDate(($year+1),($m+1), $d);
	$dayOfWeek = $newDate->format("N")-1; 
	$travail = ((($dayOfWeek==0 or $dayOfWeek==1 or $dayOfWeek==2 or $dayOfWeek==3 or $dayOfWeek==4 or $dayOfWeek==5 or $dayOfWeek==6) and $d <= $aMonthDays[$m+5])?" travail":"");
	$endOfMonth = (($d==31)?" endOfMonth":""); // Si dernier jour du mois, mise en memoire du mot endOfWeek (classe css)
	if ($d <= $aMonthDays[$m+5])  {  
		 $html.="<td class='dayOfWeek".$travail.$endOfMonth."'  style=\"background-color:white;\">".$aDayOfWeek[$dayOfWeek]."</td>" ; 						
		 $html.="<td class='day ".$travail.$endOfMonth."'  style=\"background-color:white;\">".$d."</td>" ; 
		 $html.="<td class='week".$travail.$endOfMonth."' onclick='changeColor(this)'  style=\"background-color:white;\">".(($dayOfWeek==0)?$newDate->format("W")/*NUmeros de semaine*/:"&nbsp;")."</td>" ;
		 } 
	 else { 				    
		$html.="<td class='dayOfWeek".$travail.$endOfMonth."' colspan='2'>&nbsp;</td>" ;
		$html.="<td class='week".$travail.$endOfMonth."' onclick='changeColor(this)' style=\"background-color:white;\" >&nbsp;</td>" ;   
	 }
  }
}
$html.="</tr>" ; 	
$html.="</tbody></table><br /></td> </center>" ; 
$html.="<td><table style='border:solid black 2px;'><th>Legende :</th><tr><td>Travail</td><td style='background-color:white; width: 15px ; height : 15px ; border : solid black 1px ;' onclick='getColor(\"white\")'></td></tr>
	<tr><td>Vacances</td><td style='background-color:yellow; width: 15px ; height : 15px ; border : solid black 1px ;' onclick='getColor(\"yellow\")'></td>
	<tr><td>Administratif</td><td style='background-color:brown; width: 15px ; height : 15px ; border : solid black 1px ;' onclick='getColor(\"brown\")'></td>
	<tr><td>Evenements</td><td style='background-color:red; width: 15px ; height : 15px ; border : solid black 1px ;' onclick='getColor(\"red\")'></td>
	<tr><td>Jury</td><td style='background-color:orange; width: 15px ; height : 15px ; border : solid black 1px ;' onclick='getColor(\"orange\")'></td>
	<tr> </tr>
	<tr> <td> <form action='envoi.php' method='POST'>
	<input id='letablodesemaine' type='hidden' name='tableSemaines' >
	<input type='Submit' onclick='nom(); sauvegarderCodeHTML()' >
	</form>
	</table> 	
	</body></html>" ;
echo $html ; 