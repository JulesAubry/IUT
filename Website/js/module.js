var reqSemestre;
var reqSave;
var reqGraph;
var reqInfos;
var reqQuotas;

function popup(){
        $( "#dialog" ).dialog({title:"Ajout d'une séquence pédagogique", maxHeight: 250,maxWidth: 450,minHeight: 250,minWidth: 450});
        
}

 $(function() {
$( "#accordion" ).accordion();
colorerSemestres(document.getElementById('lepremierSemestre'));
});

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



function afficherProf(id){
  reqProf = new Request(
        {
                url        : "recupProf.php",
                method     : 'get',
                handleAs   : 'json',
                parameters : {id : id},
                onSuccess  : function(json) {
		  
                        viderNoeud(document.getElementById("valueQuotas"));
                        var quota = document.getElementById("valueQuotas");			 
				//var result = jQuery.parseJSON(json);
				//console.log(result);
			
			var parsedJSON = json;
			
			var element;
			for(var i =0; i<parsedJSON.length; i++) {
			  element = parsedJSON[i];
				$.each(element, function(k, v){
                                var tr = document.createElement("tr");
                                var th = document.createElement("th");
				th.innerHTML = k+" : "+ v;
				tr.id = "ligneModules";
                                tr.appendChild(th);
                                quota.appendChild(tr);
				});
			}
				
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        }); 
  
}

 function stateChange() { 
      var a;
      var b;
     // console.log('gg');
      var x = document.getElementsByName("libelleSeq[]");
      for (i = 0; i < x.length; i++) {
            if (x[i].type == "checkbox") {
                    if(x[i].checked ) {
                      b = x[i].value;
                    }
            }
        }
      var a = document.getElementsByName('id')[0].value;
      if(a != undefined && b != undefined)  {
      //console.log('gg2');
        issetModule = new Request(
          {
                  url        : "checkModule.php",
                  method     : 'get',
                  handleAs   : 'json',
                  parameters : {id : a, lib : b},
                  onSuccess  : function(json) {
  			  if(json.length!=0){
  			      alert('Sequence deja existante');
  			      document.getElementById('submit').disabled='disabled';
  			  }	
  			  else document.getElementById('submit').disabled='';
                  },
                  onError    : function(status, message) {
                          window.alert('Error ' + status + ': ' + message) ;
                  }
          }); 
      }
}


function supprimerLigne(a){
    $( "#confirme" ).dialog({title:"Suppression du module", maxHeight: 0,maxWidth: 450,minHeight: 0,minWidth: 450, modal: true,
      buttons: { "Voulez-vous vraiment supprimer ?": function() {
	$( this ).dialog( "close" );
	    reqSemestre = new Request(
        {
                url        : "suppr.php",
                method     : 'get',
                handleAs   : 'text',
                parameters : {id : a},
                onSuccess  : function(json) {
		 var s = '#'+a; 
		    $(s).closest('tr').remove() ;
		    //console.log($(s).closest('tr'));
		    //viderNoeud(document.getElementById("valueQuotas"));                            
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
	
      },
      Cancel: function() {
	$( this ).dialog( "close" );
	}
      }
    });    
}

window.onload=function() {
semestre(1);


}

function semestre(n){
        if(reqSemestre!=null){
                reqSemestre.cancel();
        }
        reqSemestre = new Request(
        {
                url        : "semestre.php",
                method     : 'GET',
                handleAs   : 'json',
                parameters : {id : n},
                onSuccess  : function(json) { 
                viderNoeud(document.getElementById("tableau"));
                        //var semestre = document.getElementById("semestre");
			var compteur = 0;
			
                        for (var i in json) {
			    (function(i) {
			        var element = json[i] ;
                                var tr = document.createElement("tr");
                                var th = document.createElement("th");
				var input_suppr= document.createElement("input");
				input_suppr.type ="button";
				input_suppr.value="x" ;
        input_suppr.setAttribute("style" , "width:40px");
        var input_edit= document.createElement("input");
				input_edit.type ="button";
				input_edit.value="Edit" ;
          input_edit.setAttribute("style" , "width:40px");
				//console.log(element.id + 'Wtf');
				input_suppr.onclick = function(event) {
				    supprimerLigne(element.libSequence+element.idMatiere);
				};//supprimerLigne(element.id);
        
        input_edit.onclick = function(event) {
				      modifier(element.libSequence+element.idMatiere);
				};
				th.innerHTML = "("+ element.libSequence  + ") " +element.idMatiere+" - "+element.libMatiere;
				th.id =element.libSequence+element.idMatiere;
				th.indice = compteur;
        th.className = 'modules';
        th.style.border = 'solid black 1px';
        th.style.cursor = 'pointer';
                                th.onclick = function(){
					selectModuleInfos(element.idMatiere);
          graphiqueModule(this.id);
          colorer(this); 
         if( $("#changerRepar").hasClass('ui-dialog-content')) {
             $('#changerRepar').dialog('close');
          }
					//graphique(this.id);
                                }
                                tr.id = "ligneModules";
                                tr.appendChild(th);
                                
        tr.appendChild(input_edit);
				tr.appendChild(input_suppr);
                                if(json[i] != undefined) {
                                    document.getElementById("tableau").appendChild(tr);
                                }
				compteur++;
			    })(i);
                        }
                                var tr = document.createElement("tr");
                                var th = document.createElement("th");
				th.innerHTML = "<input type='button' name = 'bouton' onclick='ajout()' value='Ajouter Sequence Pédagogique' style='border-radius : 10px ; '>" ;
				tr.id = "ligneModules";
                                tr.appendChild(th);
				var tr2 = document.createElement("tr");
                                var th2 = document.createElement("th");
				th2.innerHTML = "<input type='button' name = 'bouton2' onclick='ajout()' value='Ajouter Sequence Pédagogique' style='border-radius : 10px ; '>" ;
				tr2.id = "ligneModules";
                                tr2.appendChild(th2);
				var tr3 = document.createElement("tr");
                                var th3 = document.createElement("th");
				th3.innerHTML = "<input type='button' name = 'bouton3' onclick='ajout()' value='Ajouter Sequence Pédagogique' style='border-radius : 10px ; '>" ;
                                tr3.id = "ligneModules";
				tr3.appendChild(th3);
				var tr4 = document.createElement("tr");
                                var th4 = document.createElement("th");
				th4.innerHTML = "<input type='button' name = 'bouton4' onclick='ajout()' value='Ajouter Sequence Pédagogique' style='border-radius : 10px ; '>" ;
                                tr4.id = "ligneModules";
				tr4.appendChild(th4);				
				document.getElementById("tableau").appendChild(tr);
				//document.getElementById("modulePB").appendChild(tr2);
				//document.getElementById("moduleTP").appendChild(tr3);
				//document.getElementById("moduleTD").appendChild(tr4);                
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}

function modifier(id) {

$( "#modifier" ).dialog({title:"Modification"});
         $.getJSON("sequence.php?id="+ id, function (result) {
                           
            	 $('#modifier').html("");
              // console.log(result);
            	 $("#modifier").append("<form id='modifier_module' name='modif_module' action='modif.php' method='GET'>"+
                    "<input type='hidden' name='secret' value = " +  result[0].libSequence+result[0].idMatiere+">"+ 
                    "<table>"+
                    "<tr><td>Identifiant de la matière : </td><td><input type='text' value="+ result[0].idMatiere+" name='id' onchange=stateChange(this) disabled></td></tr>"+
                    "<tr><td>Nom de la matière :<td><textarea name='nom' required> " + result[0].libMatiere +" </textarea> </td></tr>"+
                    "<tr><td>Heures TP PPN :<td><input type=\"number\" value="+ result[0].nbHTP_PPN +" min=\"0\" step=\"1\"/ name='HTPPPN'></td></tr>"+
                    "<tr><td>Heures TD PPN :<td><input type=\"number\" value="+ result[0].nbHTD_PPN +" min=\"0\" step=\"1\"/ name='HTDPPN'></td></tr>"+
                    "<tr><td>Heures CM PPN :<td><input type=\"number\" value="+ result[0].nbHCM_PPN +" min=\"0\" step=\"1\"/ name='HCMPPN'></td></tr>"+
                    "<tr><td>TD sur machines :<td><input type='checkbox' name='TDM' ></td></tr> </table>");
                    switch(result[0].demiSemestre) {
                        case '0':
                           $("#modifier_module").append("Semestre : Complet <input type=\"checkbox\" class=\"uncheck2\" value=\"0\" name=\"partieSem[]\" checked />" +
                              "1ère partie <input type=\"checkbox\" class=\"uncheck2\" value=\"1\" name=\"partieSem[]\"  />" +
                              "2ème partie <input type=\"checkbox\" class=\"uncheck2\" value=\"2\"name=\"partieSem[]\"  /> <br>");
                          break;
                        case '1':
                           $("#modifier_module").append("Semestre : Complet <input type=\"checkbox\" class=\"uncheck2\" value=\"0\" name=\"partieSem[]\" />" +
                              "1ère partie <input type=\"checkbox\" class=\"uncheck2\" value=\"1\" name=\"partieSem[]\" checked />" +
                              "2ème partie <input type=\"checkbox\" class=\"uncheck2\" value=\"2\"name=\"partieSem[]\"  /> <br>");
                          break;
                        case '2':
                           $("#modifier_module").append("Semestre : Complet <input type=\"checkbox\" class=\"uncheck2\" value=\"0\" name=\"partieSem[]\" />" +
                              "1ère partie <input type=\"checkbox\" class=\"uncheck2\" value=\"1\" name=\"partieSem[]\"  />" +
                              "2ème partie <input type=\"checkbox\" class=\"uncheck2\" value=\"2\"name=\"partieSem[]\" checked /> <br>");
                          break;                    
                    }
                    switch(result[0].libSequence) {
                       case 'CM':
                            $("#modifier_module").append("CM <input type=\"checkbox\" class=\"uncheck\" value=\"CM\" name=\"libelleSeq[]\" checked  />" +
                              "TD <input type=\"checkbox\" class=\"uncheck\" value=\"TD\" name=\"libelleSeq[]\"  />" +
                              "TP <input type=\"checkbox\" class=\"uncheck\" value=\"TP\" name=\"libelleSeq[]\"  />"  +
                              "PB <input type=\"checkbox\" class=\"uncheck\" value=\"PB\" name=\"libelleSeq[]\" /> <br>");
                            break;
                       case 'TD':
                            $("#modifier_module").append("CM <input type=\"checkbox\" class=\"uncheck\" value=\"CM\" name=\"libelleSeq[]\"  />" +
                              "TD <input type=\"checkbox\" class=\"uncheck\" value=\"TD\" name=\"libelleSeq[]\"  checked/>" +
                              "TP <input type=\"checkbox\" class=\"uncheck\" value=\"TP\" name=\"libelleSeq[]\"  />"  +
                              "PB <input type=\"checkbox\" class=\"uncheck\" value=\"PB\" name=\"libelleSeq[]\" /> <br>");
                            break;
                       case 'TP':
                            $("#modifier_module").append("CM <input type=\"checkbox\" class=\"uncheck\" value=\"CM\" name=\"libelleSeq[]\"   />" +
                              "TD <input type=\"checkbox\" class=\"uncheck\" value=\"TD\" name=\"libelleSeq[]\"  />" +
                              "TP <input type=\"checkbox\" class=\"uncheck\" value=\"TP\" name=\"libelleSeq[]\"  checked/>"  +
                              "PB <input type=\"checkbox\" class=\"uncheck\" value=\"PB\" name=\"libelleSeq[]\" /> <br>");
                            break;
                       case 'PB':
                            $("#modifier_module").append("CM <input type=\"checkbox\" class=\"uncheck\" value=\"CM\" name=\"libelleSeq[]\"  />" +
                              "TD <input type=\"checkbox\" class=\"uncheck\" value=\"TD\" name=\"libelleSeq[]\"  />" +
                              "TP <input type=\"checkbox\" class=\"uncheck\" value=\"TP\" name=\"libelleSeq[]\"  />"  +
                              "PB <input type=\"checkbox\" class=\"uncheck\" value=\"PB\" name=\"libelleSeq[]\"checked /> <br>");
                            break;                    
                    }
                    //console.log( result[0].nbGroupe);
                    $("#modifier_module").append("<table> <tr> <td style='width: 182px'> Nombre d'heures total : <td><input type=\"number\" value="+ result[0].nbH_Total +" min=\"0\" step=\"1\"/ name='nbHTotal' ></td> </tr> </table>" +
                    "<table> <tr> <td style='width: 182px'> Nombre de groupes : <td><input type=\"number\" value="+ result[0].nbGroupe +" min=\"0\" step=\"1\"/ name='nbGroupe' ></td></tr> </table>");
                      $("#modifier_module").append("<input type='Submit' id='submit'></form>");
            	 $("#modifier").dialog({
            	  height:'auto',
            	  width:'auto',
            	   hide: {
            	  effect: "clip",
            	  duration: 1000
            	  },
            	   
            	  show: {
            	  effect: "clip",
            	  duration: 1000
            	  }
            });
             $('input.uncheck').on('change', function() {
                $('input.uncheck').not(this).prop('checked', false);
             });
             $('input.uncheck2').on('change', function() {
                $('input.uncheck2').not(this).prop('checked', false);
             });
         });
}

function ajout(){
    popup() ;
    document.getElementById("dialog").innerHTML = "<form name='ajout_module' action='ajout.php' method='GET'>"+
    "<table>"+
    "<tr><td>Identifiant de la matière :</td><td><input type='text' placeholder='Ex : M3101' name='id' onchange=stateChange() required></td></tr>"+
    "<tr><td>Nom de la matière :<td><input type='text' placeholder='Ex : Bases de donnees' name='nom' required ></td></tr>"+
    "<tr><td>Heures TP PPN :<td><input type=\"number\" min=\"0\" step=\"1\"/ name='HTPPPN'></td></tr>"+
    "<tr><td>Heures TD PPN :<td><input type=\"number\" min=\"0\" step=\"1\"/ name='HTDPPN'></td></tr>"+
    "<tr><td>Heures CM PPN :<td><input type=\"number\" min=\"0\" step=\"1\"/ name='HCMPPN'></td></tr></table>"+
    "Semestre : Complet <input type=\"checkbox\" class=\"uncheck2\" value=\"0\" name=\"partieSem[]\"/>" +
    "1ère partie <input type=\"checkbox\" class=\"uncheck2\" value=\"1\" name=\"partieSem[]\"/>" +
    "2ème partie <input type=\"checkbox\" class=\"uncheck2\" value=\"2\"name=\"partieSem[]\" /> <br>"+
    "CM <input type=\"checkbox\" class=\"uncheck\" value=\"CM\" name=\"libelleSeq[]\" onchange=stateChange() /> " +
    "TD <input type=\"checkbox\" class=\"uncheck\" value=\"TD\" name=\"libelleSeq[]\" onchange=stateChange() />" +
    "TP <input type=\"checkbox\" class=\"uncheck\" value=\"TP\" name=\"libelleSeq[]\" onchange=stateChange() />"  +
    "PB <input type=\"checkbox\" class=\"uncheck\" value=\"PB\" name=\"libelleSeq[]\" onchange=stateChange() /> <br>" +
    "<table> <tr> <td style='width: 182px'> Nombre d'heures total : <td><input type=\"number\" min=\"0\" step=\"1\"/ name='nbrHTotal' required ></td> </tr> </table>" +
    "<table> <tr> <td style='width: 182px'> Nombre de groupes : <td><input type=\"number\" min=\"0\" step=\"1\"/ name='nbGroupe' required ></td> </tr> </table>" +
    "<input type='submit' id='submit'></form>";
    $('input.uncheck').on('change', function() {
    $('input.uncheck').not(this).prop('checked', false);
    });
     $('input.uncheck2').on('change', function() {
    $('input.uncheck2').not(this).prop('checked', false);    //Une seule (CM/TD/TP/PB) peut etre checked donc je vire les autres.
});

}
/*
function graphique(idModule){
        var img = document.getElementById("graph");
        img.src = "graphModules.php?id="+idModule+"&cachebuster=" + new Date().getTime();
        return true;
}      */

function viderNoeud(noeud) {
        while (noeud.hasChildNodes()) {
                noeud.removeChild(noeud.lastChild) ;
        }
}

function prefs() {
         $( "#preference" ).dialog({title:"Préférences"});
	 $('#preference').html("");
	 $("#preference").append("<button onclick=\"remplirDivPref('Options')\"> Options </button> <button onclick=\"remplirDivPref('CSV')\" > Import CSV </button> <button onclick=\"remplirDivPref('Propos')\"> A Propos </button> <br> <div id=\"divPreference\"> </div>");
	 $("#preference").dialog({
	  height:'auto',
	  width:'auto',
	   hide: {
	  effect: "clip",
	  duration: 1000
	  },
	   
	  show: {
	  effect: "clip",
	  duration: 1000
	  }
});
	 remplirDivPref('Prof');
  
}

function remplirDivPref(s) {
    $('#divPreference').html("");
    switch(s) {
      case 'Prof':
	$('#divPreference').html('</br><form method="post" > <label>Nom : <input type="text" name="nomProf" required /></label><br/> <label>Prénom : <input type="text" name="prenomProf" required /></label><br/>  <label>Mot de passe : <input type="password" name="pwProf" required /></label><br/>  <label>Confirmation du mot de passe: <input type="password" name="pwProf2" required /></label><br/> <label>Adresse e-mail: <input type="email" name="emailProf" required /></label><br/> <input type="submit" value="Inscrire" onclick="envoyerProf()" /> </form>');
	break;
    case 'Options':
      if ( window.addEventListener ) {
        var kkeys = [], konami = "73,85,84"; 
        window.addEventListener("keydown", function(e){
                kkeys.push( e.keyCode );
                if ( kkeys.toString().indexOf( konami ) >= 0 ) {
                    // run code here    
                    //alert("gg");
                    
                    $('body').css('-webkit-filter', 'blur(8px)');
                    //$("#text").hide().fadeIn("slow").html('Now the website will appear.');
                }
        }, true);}
      	$('#divPreference').html('Changer la couleur du background : <br> <a href="javascript:void(document.bgColor=\'white\')">Blanc</a> <br> <a href="javascript:void(document.bgColor=\'#cc0000\')">Rouge</a> <br> <a href="javascript:void(document.bgColor=\'#66FF99\')">Vert</a> <br>  <a href="javascript:void(document.bgColor=\'#ff55a3\')">Rose</a>');
	break;
    case 'CSV':
      $('#divPreference').html('</br> <form method="get" action=""> Télécharger le fichier d\'import CSV pour les modules <br><br> <a href="importCSVModule.xlsx" download="importCSVModule.xlsx">Telecharger</a></form> <br><input type="file" name="textfield1" accept=".csv" > <hr> <form action="importCSVProf.xlsx">   Télécharger le fichier d\'import CSV pour les professeurs <br><br> <a href="importCSVProf.xlsx" download="importCSVProf.xlsx">Télécharger</a> <br><br> <input type="file" name="textfield2" accept=".csv" ></form> <br>');
	break;
    case 'Propos':
      $('#divPreference').html('<h1> PROJET BY <br> ALEXANDRE MOUCHET, <br> JULES AUBRY, <br> DIMITRI TATAR, <br> GAETAN PELZER, <br>MARIO CHERCHI, <br>BENJAMIN JACQUES, <br>OLIVIER RIBEIRO');
	break;
	
	//TODO : vérifier les noms des fichiers excel
	//TODO : faire deux fonctions pour chacun des imports CSV
    }
    importCSV();
    importCSV2();
    //TODO : Remplir la divPreference
    
}

function importCSV() {
    $('input[name=textfield1]').fileupload({
      url: "ajout_bis.php",
      dataType: 'json',
      done: function (e, data) {
	
      }
  });
}

function importCSV2() {
    $('input[name=textfield2]').fileupload({
      url: "ajout_bis2.php",
      dataType: 'json',
      done: function (e, data) {
	  	
      }
  });    
}
    
function checkArray(my_arr){
   for(var i=0;i<my_arr.length;i++){
       if(my_arr[i] === "")   
          return false;
   }
   return true;
}


function selectModuleInfos(id){
        new Request(
        {
                url        : "infosModule.php",
                method     : 'get',
                handleAs   : 'json',
                parameters : {id : id},
                onSuccess  : function(json) {
				/*
			json[0].idMatiere			
			var tr1 = document.createElement("tr") ;
			var th1 = document.createElement("th") ;
			tr1.id = "ligneModules";
			var tr2 = document.createElement("tr") ;
			var th2 = document.createElement("th") ;
			tr2.id = "ligneModules";
			var tr3 = document.createElement("tr") ;
			var th3 = document.createElement("th") ;
			tr3.id = "ligneModules";
			var tr4 = document.createElement("tr") ;
			var th4 = document.createElement("th") ;
			tr4.id = "ligneModules";
			var tr5 = document.createElement("tr") ;
			var th5 = document.createElement("th") ;
			tr5.id = "ligneModules";
			var tr6 = document.createElement("tr") ;
			var th6 = document.createElement("th") ;
			tr6.id = "ligneModules";
			var tr7 = document.createElement("tr") ;
			var th7 = document.createElement("th") ;
			tr7.id = "ligneModules";
			var tr8 = document.createElement("tr") ;
			var th8 = document.createElement("th") ;
			tr8.id = "ligneModules";
			
		    */
			$('#quotas').html("");   /*
      var size = 0;
       	for(var i in json){
         size = size + 1;
        }            */
      
			for(var i in json){
      if(i == 0) {
					$('#quotas').append("<h2> &nbsp " + json[i].idMatiere + " - " + json[i].libMatiere  + " </h2>");
					var demi = json[i].demiSemestre  == 0 ? "Semestre complet" : ( json[i].demiSemestre == 1 ? "Première partie du semestre" : "Deuxième partie du semestre" );
					$('#quotas').append("<tr> <td>" + "&nbsp &nbsp Demi semestre : " + demi  + "</td> </tr>");
					$('#quotas').append("<tr> <td>" + "&nbsp &nbsp Nombre d'heures CM PPN : " + json[i].nbHCM_PPN  + "</td> </tr>");
					$('#quotas').append("<tr> <td>" + "&nbsp &nbsp Nombre d'heures TP PPN: " + json[i].nbHTP_PPN  + "</td> </tr>");
					$('#quotas').append("<tr> <td>" + "&nbsp &nbsp Nombre d'heures TD PPN : " + json[i].nbHTD_PPN  + "</td> </tr>");
					$('#quotas').append("<h2> &nbsp " + json[i].libSequence  + " </h2>");			
					$('#quotas').append("<tr> <td>" + "&nbsp &nbsp Nombre d'heures au total : " + json[i].nbH_Total  + "</td> </tr>");
          //$('#quotas').append("<tr> <td>" + "&nbsp &nbsp Nombre moyen : " + json[i].nbH_Total  + "</td> </tr>");

            }
            else {
               $('#quotas').append("<h2> &nbsp " + json[i].libSequence  + " </h2>");
				       $('#quotas').append("<tr> <td>" + "&nbspNombre d'heures au total : " + json[i].nbH_Total  + "</td> </tr>"); 
              // $('#quotas').append("<tr> <td>" + "&nbsp &nbsp Nombre moyen : " + json[i].nbH_Total  + "</td> </tr>");
       
            
            }
					}
				},
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });  
}

function envoyerProf() {
         new Request(
        {
                url        : "ajouterProfesseur.php",
                method     : 'get',
                handleAs   : 'text',
                parameters : {nom : $( "input[name=\'nomProf\']" ).val(), prenom : $( "input[name=\'prenomProf\']" ).val(), pw : $( "input[name=\'pwProf\']" ).val(), email : $( "input[name=\'emailProf\']" ).val() },
                onSuccess  : function() {
                        alert('GG');
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}

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

function checkSiTrop(nb) {
   var idArray = [];
    $('.inputRepartition').each(function () {
        idArray.push(this);
    });
    //console.log(idArray);
    var somme = 0;
    $.each( idArray, function( key, value ) {
     somme += parseInt(value.value);
    });
    if(somme > nb) {
    console.log(somme);
       alert('Trop d\'heures ! Max : ' + nb );
       $('#boutonRepartition').attr("disabled", "disabled");
    }  
    else {
       $('#boutonRepartition').removeAttr("disabled");
    } 
}

function openChangerRepartition(e) {
     
$( "#changerRepar" ).dialog({title:"Changer repartition"});
         $.getJSON("changerRepartitionSemaine.php?id="+ e, function (result) {
                 
            	 $('#changerRepar').html(""); 
                $("#changerRepar").append("<form id='repartition_module' name='repart_module' action='repartir.php' method='GET'> <input type=\"hidden\" value=\""+ e + "\" name=\"id\" > </input><table id=\"letableau\">");   
                
                var somme  = 0;
                for(var k in result) {
                    somme += result[k].nbH_Semaine;
                }
              for(var k in result) {
                      $("#letableau").append("<tr>  <td>  Semaine " + result[k].idSemaine + " : <input class='inputRepartition' name=\"listeNbH[]\" type=\"number\" onchange=\"checkSiTrop("+ somme+ ")\" value=\""+ result[k].nbH_Semaine + "\" min=\"0\" max=\""+ somme + "\" > </input>"); 
              }
                $("#letableau").append("</table> <input id=\"boutonRepartition\" type=\"Submit\" value=\"Repartir\" > </input> ");
                 $("#changerRepar").append("</form> ");
            	 $("#changerRepar").dialog({
            	  height:'auto',
            	  width:'auto',
            	   hide: {
            	  effect: "clip",
            	  duration: 1000
            	  },
            	   
            	  show: {
            	  effect: "clip",
            	  duration: 1000
            	  }
            });
         });
}

function graphiqueModule(id){	
            $.getJSON("graphiqueModule.php?id="+ id, function (result) {
                var chart = new CanvasJS.Chart("chartContainer", {
                    data: [
                        {
                             click: function(e){
                                openChangerRepartition(id);
                             },
                            color: "#b42d0b",
                            dataPoints: result
                        }
                    ],
                    title:{
                     text: "Nombre d'heures par semaine de la sequence "  + id
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