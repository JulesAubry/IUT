var reqSemestre;
var reqSave;
var reqGraph;
var reqInfos;
var reqQuotas; 
var voeuxDepanne;
var voeuxVoulu;
var idInter;

window.onload = function(){
$( "#tabs" ).tabs();
	//graphique('1');
	  $.ajax({
	    url: 'recupererIdIntervenant.php',
	    type: 'GET',
	    dataType: 'html',
      async: false,  
	    success:function(res, statut){
		   idInter = res;
		}
	      });
        quotas(idInter);
        $( document ).tooltip();
        
	semestre(1);
  colorerSemestres(document.getElementById('lepremierSemestre'));
}

function colorer(i){
  var idArray = [];
    $('.modules').each(function () {
        idArray.push(this);
    });
    //console.log(idArray);
    $.each( idArray, function( key, value ) {
      value.style.color = "black";
    });
   i.style.color = "red";
}

function colorerSemestres(i){
  var idArray = [];
    $('.semestresBouton').each(function () {
        idArray.push(this);
    });
    //console.log(idArray);
    $.each( idArray, function( key, value ) {
      value.style.color = "black";
    });
   i.style.color = "red";
}


function semestre(n){
        if(reqSemestre!=null){
                reqSemestre.cancel();
        }
        reqSemestre = new Request(
        {
                url        : "semestre.php",
                method     : 'get',
                handleAs   : 'json',
                parameters : {id : n},
                onSuccess  : function(json) {
			          viderNoeud(document.getElementById("moduleTP"));
                viderNoeud(document.getElementById("moduleTD"));
                viderNoeud(document.getElementById("modulePB"));
                viderNoeud(document.getElementById("moduleCM"));
                      //  var semestre = document.getElementById("semestre");
			
			if(chercher(json, "CM") ) {
			 creationTableVoeux(document.getElementById("moduleCM"), "Nombre d'heures voulues", "CM");
			}
			if(chercher(json, "TP") ) {
			 creationTableVoeux(document.getElementById("moduleTP"), "Nombre de groupes voulus", "TP");
			}
			if(chercher(json, "TD") ) {
			 creationTableVoeux(document.getElementById("moduleTD"), "Nombre de groupes voulus", "TD");
			}
			if(chercher(json, "PB") ) {
			 creationTableVoeux(document.getElementById("modulePB"), "Nombre de groupes voulus", "PB");
			}
			var compteur = 1;
      
                        for (var i in json) {
                                var element = json[i] ;
                                var tr = document.createElement("tr");
                                var th = document.createElement("th");
                                th.innerHTML = element.idMatiere+" - "+element.libMatiere;
				th.id = element.libSequence + element.idMatiere;
        th.className = 'modules';
				th.style.fontSize = "x-small";
                                th.indice = compteur;
                                th.onclick = function(){
                                        selectModuleInfos(this.indice);
                                        infosRepartition(this.id);
                                        graphique(element.idMatiere.substr(1,1));
                                        colorer(this);
                                }
                                tr.className = "ligneModules";
                                tr.appendChild(th);   
                                
                                  $.ajax({
                                         type: "GET",
                                         url: "recupInfosVoeux.php",
                                         data: {'idSeq': element.idSequence, 'idInter' : idInter}, 
                                         dataType: 'json',
                                         async: false,  
                                         success: function(res){
                                         if(res.length != 0)  {
                                           $.each(res, function(index, element) {
                                           voeuxVoulu = element.nb_Desire ;
                                           voeuxDepanne = element.nb_Depanne ;
                                           });
                                          }
                                          else {
                                           voeuxVoulu = 0;
                                           voeuxDepanne = 0; 
                                          }
                                         }
                                        });
                                                              
                                   if(json[i] != undefined) {                                     
                                  var identifiant = element.idMatiere.substr(1, 1); 
                                  switch(json[i].libSequence) {
                                  case 'CM':
				    ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0,element.nbH_Total, voeuxVoulu, "Voulue", element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere); 
             ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0,element.nbH_Total, voeuxDepanne, "Depanne", element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere); 
                                    document.getElementById("moduleCM").appendChild(tr);
                                    break;
                                  case 'PB':
             ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0,element.nbH_Total, voeuxVoulu, "Voulue", element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere); 
             ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0,element.nbH_Total, voeuxDepanne, "Depanne", element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere); 
                                   // document.getElementById("moduleCM-3").appendChild(tr);				    
                                    document.getElementById("modulePB").appendChild(tr);
                                    break;
                                  case 'TP':
            ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0,element.nbH_Total, voeuxVoulu, "Voulue",element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere); 
				    ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0, element.nbH_Total, voeuxDepanne, "Depanne",element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere);
                                   document.getElementById("moduleTP").appendChild(tr);
                                    break;
                                  case 'TD':
             ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0,element.nbH_Total, voeuxVoulu, "Voulue",element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere); 
				    ajouterCelluleInput(tr, element.libMatiere+element.idMatiere, 0, element.nbH_Total, voeuxDepanne, "Depanne",element.idSequence, identifiant, element.libSequence + ""+ element.idMatiere);
                                    document.getElementById("moduleTD").appendChild(tr);
                                    break;
                                  }
                                }
                                compteur++;
                        }
                        
    $( document ).tooltip();
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}

function chercher(array, type) {
  var a = array;
  var index = 0;
  var found;
  var entry;
  var trouver = false;
  for (index = 0; index < a.length; ++index) {
      entry = a[index];
      if (entry.libSequence == type ) {
	  found = entry;
	  trouver = true;
	  break;
      }
  }  
  return trouver;
}

function infosRepartition(n){
        if(reqInfos!=null){
                reqInfos.cancel();
        }
        reqInfos = new Request(
        {
                url        : "infosRepartitionSequence.php",
                method     : 'get',
                handleAs   : 'json',
                parameters : {id : n},
                onSuccess  : function(json) {
				//TODO remplir la div infos
				
                        viderNoeud(document.getElementById("infosTable"));
                        var infosTable = document.getElementById("infosTable");
	
                        //Ligne Semaine
                        var trS = document.createElement("tr");
                        var th = document.createElement("th");
                        th.innerHTML = "Semaines";
                        trS.appendChild(th);
                        for (var i in json) {
                                var element = json[i] ;
                                var td = document.createElement("td");
                                td.innerHTML = element.idSemaine;
                                trS.appendChild(td);
                        }
                        infosTable.appendChild(trS);
						if(json.length !== 0 ) {
							switch(json[0].libSequence) {
								case 'CM':
								//Ligne CM
								var trCM = document.createElement("tr");
								trCM.className = "ligneInfos";
								var thCM = document.createElement("th");
								thCM.innerHTML = "Nombre d'heures de CM";
								trCM.appendChild(thCM);                
								for (var i in json) {
										var element = json[i] ;
										var td = document.createElement("td");
										td.innerHTML = element.nbH_Semaine;
										trCM.appendChild(td);
								}
								infosTable.appendChild(trCM);
								break;

								//Ligne TD
								case 'TD':
								var trTD = document.createElement("tr");
								trTD.className = "ligneInfos";
								var thTD = document.createElement("th");
								thTD.innerHTML = "Nombre d'heures de TD";
								trTD.appendChild(thTD);
								for (var i in json) {
										var element = json[i] ;
										var td = document.createElement("td");
										td.innerHTML = element.nbH_Semaine;
										trTD.appendChild(td);
								}
								infosTable.appendChild(trTD);
								break;

								//Ligne TP
								case 'TP':
								var trTP = document.createElement("tr");
								trTP.className = "ligneInfos";
								var thTP = document.createElement("th");
								thTP.innerHTML = "Nombre d'heures de TP";
								trTP.appendChild(thTP);
								for (var i in json) {
										var element = json[i] ;
										var td = document.createElement("td");
										td.innerHTML = element.nbH_Semaine;
										trTP.appendChild(td);
                    }										
								infosTable.appendChild(trTP);
								break;
                case 'PB':
								var trTP = document.createElement("tr");
								trTP.className = "ligneInfos";
								var thTP = document.createElement("th");
								thTP.innerHTML = "Nombre d'heures de TP";
								trTP.appendChild(thTP);
								for (var i in json) {
										var element = json[i] ;
										var td = document.createElement("td");
										td.innerHTML = element.nbH_Semaine;
										trTP.appendChild(td);
                    }										
								infosTable.appendChild(trTP);
								break;
							}  
                        }
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}
function graphique(id){    /*
        if(reqGraph!=null){
                reqGraph.cancel();
        }
        reqGraph = new Request(
        {
                url        : "calcul_valeurs_graphique.php",
                method     : 'post',
                handleAs   : 'text',
                parameters : {},
                onSuccess  : function() {},
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
        var img = document.getElementById("graph");
        img.src = "graph.php?cachebuster=" + new Date().getTime();
        return true;      */
	
            $.getJSON("graphiqueVoeux.php?id=" + id, function (result) {
            
                var chart = new CanvasJS.Chart("chartContainer", {
                    data: [
                        {
                            color: "#b42d0b",
                            dataPoints: result
                        }
                    ],
                     title:{
                     text: "Nombre d'heures par semaine du Semestre "  + id
                        // more attributes 
                    },
                    axisY:{
                       title: "Nombre d'heures"
                    },
                    axisX: {
                      title: "Semaines"
                    }
                });

                chart.render();
            });
  }

function sauvegarderSession(idSequence, idIntervenant, valeur, type){
        if(reqSave!=null){
                reqSave.cancel();
        }
        reqSave = new Request(
        {
                url        : "save_voeux_session.php",
                method     : 'get',
                handleAs   : 'text',
                parameters : {idSeq : idSequence, idInter : idIntervenant, valeur : valeur, type : type},
                onSuccess  : function() {},
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
        return true;
}

function sauvegarderBD(){
        if(reqSave!=null){
                reqSave.cancel();
        }
        reqSave = new Request(
        {
                url        : "save_voeux_BD.php",
                method     : 'post',
                handleAs   : 'text',
                parameters : {},
                onSuccess  : function() {
                        afficherMessage("erreur","Sauvegardé !",2000);
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}

function quotas(n){
        if(reqQuotas!=null){
                reqQuotas.cancel();
        }
        reqQuotas = new Request(
        {
                url        : "quotas.php",
                method     : 'post',
                handleAs   : 'json',
                parameters : {id : n},
                onSuccess  : function(json) {
                var sum = 0;
                var nb_Desire = 0 ;
                var nb_Depanne = 0;
                        for (var i in json) {
                                var element = json[i] ;
                                	var sum = sum + parseInt(element.nbDesire) ; 
                                  nb_Desire = nb_Desire +  parseInt(element.nbDesire); 
                        }
                                //viderNoeud(document.getElementById('valueQuotas'));
                                var value = document.getElementById('valueQuotas');
                                //var table = document.getElementById('valueSemestres');
                                //console.log(element.nbH);
								//
								//value.fontSize = "x-small";
                if(json[0] != undefined) {
								var nbHMax = parseInt(json[0].nbH) * 1.5;
                if(sum > nbHMax) {
                       alert('problème trop d\'heures, veuillez baisser svp');
                }
								//console.log(nbHMax);
                                value.innerHTML = "Quotas d'heures par année : <br><meter title=\"" + sum+ " / " + nbHMax  + "\" style=\"width:250px ; height: 40px\" low=\""+ Math.round(json[0].nbH/3) + "\" high=\"" + Math.round(json[0].nbH/2) + "\" optimum=\"" + json[0].nbH + "\" value=\"" + sum + "\" min=\"0\" max=\"" + nbHMax+ "\"> </meter>";
                               /* if (sum< json[0].nbH || sum> nbHMax) {
                                        value.style.color = "red";
                                }
                                else{
                                        value.style.color = "black";
                                } 
                                
                                //TODO CONTINUER !!!
                                for(var i=1; i<5; i++){
                                        var tr = document.createElement('tr');
                                        var th = document.createElement('th');
                                        var td = document.createElement('td');

                                        th.innerHTML = 'S'+i;
                                        if(i==1){
                                              td.innerHTML = element.valueS1;  
                                        }
                                        else if(i==2){
                                              td.innerHTML = element.valueS2;  
                                        }
                                        else if(i==3){
                                              td.innerHTML = element.valueS3;  
                                        }
                                        else{
                                              td.innerHTML = element.valueS4;  
                                        }
                                        
                                        tr.appendChild(th);
                                        tr.appendChild(td);
                                        table.appendChild(tr);
                                }*/
                            }
                        
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}

function viderNoeud(noeud) {
        while (noeud.hasChildNodes()) {
                noeud.removeChild(noeud.lastChild) ;
        }
}

function creationTableVoeux(noeud, type, fonction){
  if(type != "NULL") {
    if (fonction == "CM") {
  	var tr = document.createElement("tr");
          var tdCM = document.createElement("td");
          tdCM.innerHTML = type;
          tdCM.className = 'phrase';
           var tdCM2 = document.createElement("td");
          tdCM2.innerHTML = "Nombre d'heures de dépanne";
          tdCM2.className = 'phrase';
          var tdVide = document.createElement("th");
          tdVide.className = 'vide';
          tr.appendChild(tdVide);
          tr.appendChild(tdCM);
          tr.appendChild(tdCM2);
          noeud.appendChild(tr);
        }
     else {
          var tr = document.createElement("tr");
          var tdCM = document.createElement("td");
          tdCM.innerHTML = type;
          tdCM.className = 'phrase';
           var tdCM2 = document.createElement("td");
          tdCM2.innerHTML = "Nombre de groupes de dépanne";
          tdCM2.className = 'phrase';
          var tdVide = document.createElement("th");
          tdVide.className = 'vide';
          tr.appendChild(tdVide);
          tr.appendChild(tdCM);
          tr.appendChild(tdCM2);
          noeud.appendChild(tr);            
     }   
    }
}


function ajouterCelluleInput(ligne,name,valeur,valeurMax, value, type, idSequence, id, fin){
        var td = document.createElement("td");
        var div = document.createElement("div");
        var input = document.createElement("input");
        var span = document.createElement("span");
        
        div.className = "field-tip";
        span.className = "tip-content";
        
        input.setAttribute("type", "number"); 
	input.setAttribute("name", name); 
	input.setAttribute("min", 0);
	input.setAttribute("max", valeurMax); 
	input.setAttribute("value", value);
  input.setAttribute("title", "Max : " + valeurMax);
        /*
        if(input.name.substring(0,2)=="CM"){
                span.innerHTML = "Nombre d'heures";
        }
        else{
                span.innerHTML = "Nombre de groupes";
        }
        */
        input.onchange = function () {

                //if(valid(input,valeurMax)){
                        if(sauvegarderSession(idSequence, idInter, input.value, type)){
                               graphique(id);
				  quotas(idInter);  
          $( document ).tooltip();            
                                
                      //  }
                }
        };
        div.appendChild(span);
        div.appendChild(input);
        td.appendChild(div);
        ligne.appendChild(td);
}
/*
function valid(input,max){
        var value = input.value;
        var pattern = new RegExp("^[0-"+max+"]{1}$");
        var matches = value.match(pattern);
        if(matches == null){
                if(value<=0){
                        input.value = '';
                }
                else{
                        input.value = max;
                }
        }
		if(input.value==0){
            input.value = '';
        }
        return true;
}*/

function selectModuleInfos(id){/*
        var arrayLignes = document.getElementById("semestre").rows;
        var longueur = arrayLignes.length;
        var i=1; 
        
        while(i<longueur)
        {
                arrayLignes[i-1].style.borderBottom = "1px solid black";
                arrayLignes[i].style.border = "1px solid black";
                i++;
        }
        
        arrayLignes[id-1].style.borderBottom = "1px solid red";
        arrayLignes[id].style.border = "1px solid red";*/
}

function afficherMessage(id,message,temps){
        document.getElementById(id).style.display='inline';
        document.getElementById(id).innerHTML = message;
        setTimeout(function(){
                document.getElementById(id).style.display='none';
                document.getElementById(id).innerHTML = "";
        }, temps);
}
 /*
function isSave(){
        new Request(
	{
                url        : "isSave.php",
                method     : 'post',
                handleAs   : 'text',
                parameters : {},
                onSuccess  : function(res) {
                        if (res==0) {
                               if (confirm("Quitter sans enregistrer ?"))
                                {
                                     logout();
                                }  
                        }
                        else{
                                logout();
                        }
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}    */

function logout(){
        new Request(
        {
                url        : "logout.php",
                method     : 'post',
                handleAs   : 'text',
                parameters : {},
                onSuccess  : function() {
                        document.location.href="index.php";
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}