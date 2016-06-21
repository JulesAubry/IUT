var reqSemestre;
var reqSave;
var reqGraph;
var reqInfos;
var reqQuotas;

window.onload = function(){
	semestre(1);
  colorerSemestres(document.getElementById('lepremierSemestre'));
}

function popup(){
        $( "#dialog" ).dialog({title:"Ajout d'un module", maxHeight: 250,maxWidth: 450,minHeight: 250,minWidth: 450});
        
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

 function stateChange(id) {
      var id = id.value ;
      issetModule = new Request(
        {
                url        : "checkModule.php",
                method     : 'get',
                handleAs   : 'json',
                parameters : {id : id},
                onSuccess  : function(json) {
			  if(json.length!=0){
			      alert('Module deja existant');
			      document.getElementById('submit').disabled='disabled';
			  }	
			  else document.getElementById('submit').disabled='';
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        }); 
}


function semestre(n)
{
        if(reqSemestre!=null)
        {
                reqSemestre.cancel();
        }

        reqSemestre = new Request(
        {
            url        : "semestre.php",
            method     : 'GET',
            handleAs   : 'json',
            parameters : {id : n},
            onSuccess  : function(json)
            { 
                viderNoeud(document.getElementById("moduleTP"));
                viderNoeud(document.getElementById("moduleTD"));
                viderNoeud(document.getElementById("modulePB"));
                viderNoeud(document.getElementById("moduleCM"));
            
            
                for (var i in json)
                {
                        var element = json[i] ;
                        var tr = document.createElement("tr");
                        var th = document.createElement("th");

                        th.innerHTML = element.idMatiere+" - "+element.libMatiere;
                        th.id = element.libSequence+element.idMatiere;
                        th.indice = i;
                        th.className = 'modules';
                        th.style.border = 'solid black 1px';
                        th.style.cursor = 'pointer';

                        th.onclick = function()
                        {
                            rechercherProfesseurs(this.id);
                            //graphique(this.id);
                            listeProf(this.id) ;
                            colorer(this);
                        }

                        tr.id = "ligneModules";
                        tr.appendChild(th);
                        if(json[i] != undefined)
                        {
                          switch(json[i].libSequence)
                          {
                          case 'CM':
                            document.getElementById("moduleCM").appendChild(tr);
                            break;
                          case 'PB':
                            document.getElementById("modulePB").appendChild(tr);  
                            break;
                          case 'TP':
                           document.getElementById("moduleTP").appendChild(tr);  
                            break;
                          case 'TD':
                            document.getElementById("moduleTD").appendChild(tr);
                            break;
                          }
                        }
                }
                                           
            },
            onError    : function(status, message)
            {
                    window.alert('Error ' + status + ': ' + message) ;
            }
        });
}

function ajout(){
    popup() ;
    document.getElementById("dialog").innerHTML = "<form name='ajout_module' action='ajout.php' method='GET'>"+
    "<table>"+
    "<tr><td>Identifiant du module :</td><td><input type='text' placeholder='Ex : M3101' name='id' onchange=stateChange(this)></td></tr>"+
    "<tr><td>Nom du module :<td><input type='text' placeholder='Ex : Bases de donnees' name='nom'></td></tr>"+
    "<tr><td>Heures TP PPN :<td><input type='text' name='HTPPPN'></td></tr>"+
    "<tr><td>Heures TD PPN :<td><input type='text' name='HTDPPN'></td></tr>"+
    "<tr><td>Heures CM PPN :<td><input type='text' name='HCMPPN'></td></tr>"+
    "<tr><td>TD sur machines :<td><input type='checkbox' name='TDM'></td></tr>"+
    "</table><input type='submit' id='submit'></form>";
    
}

function listeProf(id)
{
 requete = new Request(
    {
        url        : "rechercheProf.php",
        method     : 'get',
        handleAs   : 'json',
        parameters : {id:id},
        onSuccess  : function(json)
        {
        var div4 = document.getElementById('valueQuotas') ;
          div4.innerHTML="";
		  var div = document.getElementById('desiree') ;
		  var div2 = document.getElementById('depannee') ;
      var div3 = document.getElementById('autres') ; 
		  div.innerHTML="";
		  div2.innerHTML="";
		  div3.innerHTML="";

		  for(var i in json){
		    var element = json[i] ;  
		    var choix_desire = element.nb_Desire ; 
        var choix_depanne = element.nb_Depanne ;
		    var tr = document.createElement('tr') ; 
		    var th = document.createElement('th') ;
        var td = document.createElement('td') ;
		    var bouton = document.createElement("input");
		    bouton.type ="button";
		    bouton.value="+" ;
		    bouton.style.minHeight ="34px" ;
        th.innerHTML = element.nom;
		    tr.className = "ligneModules" ;
        
        
       
		    tr.appendChild(th) ;
         
        td.appendChild(bouton);
		    tr.appendChild(td);  
        var tr2 = tr.cloneNode(true);
        var tr3 = tr.cloneNode(true);
        
        th.innerHTML += "<p><progress id=\"progress" + "Desiree" + element.nom + "\" class=\"avancement\" value=\""+ choix_desire + "\" max=\""+ choix_desire + "\"></progress></p>";
        tr2.getElementsByTagName("th")[0].innerHTML +=  "<p><progress id=\"progress" + "Depannee" + element.nom + "\" class=\"avancement\" value=\""+ choix_depanne + "\" max=\""+ choix_depanne + "\"></progress></p>";
		    if(choix_desire > 0)   {
          div.appendChild(tr);
          //console.log('1');;
          }
		    if(choix_depanne > 0) {
           div2.appendChild(tr2) ;
          //console.log('2');
           } 
        if(choix_depanne == undefined && choix_desire == undefined) div3.appendChild(tr3) ;  
		  }
      
     affecter(id);
        },
        
        onError    : function(status, message) {
                window.alert('Error ' + status + ': ' + message) ;
        }
    }); 
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



function rechercherProfesseurs(id) {
    var availableTags = [];
    requete = new Request(
    {
        url        : "rechercheProf.php",
        method     : 'get',
        handleAs   : 'json',
        parameters : {id:id},
        
        onSuccess  : function(json)
        {
            for(var i in json)
            {
                var element = json[i] ;  
                availableTags.push(element.nom);
            }
            //console.log(availableTags);
        },

        onError    : function(status, message)
        {
                window.alert('Error ' + status + ': ' + message) ;
        }
    });

    $( "#searchBar" ).autocomplete({
        source: availableTags
    });
  }
$(function() {
    $( "#accordion" ).accordion({heightStyle:"fill"});
}); 
 
$(function() {
    $( "#tabs" ).tabs();
});
 
/*function rechercherProf(){
    var id = document.getElementById('nomDuProf').value ; 
    reqSearchProf = new Request(
        {
                url        : "rechercheProf.php",
                method     : 'get',
                handleAs   : 'json',
                parameters : {id : id},
                onSuccess  : function(json){
		    var suggestion = document.getElementById('suggestions') ; 
		    for(var i in json){	    
		      var element = json[i] ; 
		      var li = document.createElement("li");
		     li.innerHTML = element.nom ; 
		      suggestion.appendChild(li); 
		    }
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
  
}*/

function graphique(idModule){
        var img = document.getElementById("graph");
        img.src = "graphModules.php?id="+idModule+"&cachebuster=" + new Date().getTime();
        return true;
}

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




function envoyerProf() {/*
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
        });*/   
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

function affecter(idModule) {
 $(':button').unbind();
 $( ':button' ).click(function() {
 //console.log($(this).parent('td').prev().html()); 
      var prof = $(this).parent('td').prev('th').text();
      var type = $(this).parent('td').prev().closest('div').attr('id'); 
      var identifiant = prof + "" + type;
      var element = "(\""+prof + "\",\"" + type+"\",\""+identifiant + "\",\""+idModule + "\")";
      
      //console.log("prof " + prof);     
     // console.log("type " + type);      
      //console.log("element " + element);    
      switch(type) {
        case "Desiree":
          var progress =  $(this).parent('td').prev('th').children().children();
          progress.val(progress.val() -1); 
          //console.log("#"+identifiant);
          $("#"+identifiant).remove();
          var soustrac = progress.prop('max') - progress.prop('value') ;
         $('#valueQuotas').append("<tr style='text-align:center;' id=\""+ identifiant + "\" ><th>" + prof + " - " + type + "<p><progress onclick='affectation(\""+idModule+ "\"); desaffecter"+element+"' class=\"avancement\" value=\""+ soustrac  + "\" max=\""+ progress.prop('max')  + "\"></progress></p> </th> </tr>" );
          
          //$('#affectationFinale').append("<p><progress class=\"avancement\" value=\""+ soustrac  + "\" max=\""+ progress.prop('max')  + "\"></progress></p> </th> </tr>");
           
          affectation(idModule); 
          break;
        case "Depannee":
        var progress =  $(this).parent('td').prev('th').children().children();
        var progressVal =  progress.val;
        if(progressVal < 1) {
             progressVal = 1;
        }
          progress.val(progress.val() -1); 
          //console.log("#"+identifiant);
          $("#"+identifiant).remove();
          var soustrac = progress.prop('max') - progress.prop('value') ;
          $('#valueQuotas').append("<tr style='text-align:center;' id=\""+ identifiant + "\" ><th>" + prof + " - " + type + "<p><progress onclick='affectation(\""+idModule+ "\"); desaffecter"+element+"' class=\"avancement\" value=\""+ soustrac  + "\" max=\""+ progress.prop('max')  + "\"></progress></p> </th> </tr>" );
          
      //  var progress =  $(this).parent('td').prev('th').children().children();
           
          affectation(idModule); 
          break;
        case "Autres":
        
          //console.log("#"+identifiant);
          $("#"+identifiant).remove();
          $('#valueQuotas').append("<tr onchange=\"checksinull(this)\" style='text-align:center;' onclick='affectation(\""+idModule+ "\"); desaffecter"+element+"' id=\""+ identifiant + "\" ><th>" + prof + " - " + type + "<p> <input type=\"number\" value=\"1\" min=\"0\"> </p> </th> </tr>" );
          affectation(idModule); 
        
          break;
      
      }
      //$(this).closest('tr').remove();
     // console.log('ici 1 ');
    });
}

function checksinull(input) {
  var valeur = $(input).children().children().children().val();
  if(valeur < 1 ) {
      $(input).remove();
  }
}

function desaffecter(nom, type, id, idModule) {  
//console.log('ou ici');
      switch(type){
        case 'Desiree':
           var progress =  $('#'+ id).children().children().children();
           var test = progress.val();
           if(test == "" ||test < 1 ) {
              test = 1;
           }
           
           progress.val(test -1); 
          // console.log(progress.val());
           var soustrac = progress.prop('max') - progress.val() ;
           $('#progress' + type + nom).val(soustrac);
          // console.log(soustrac);
           
          break;
        case 'Depannee':
        var progress =  $('#'+ id).children().children().children();
           var test = progress.val();
           if(test == "" ||test < 1 ) {
              test = 1;
           }
           
           progress.val(test -1); 
           //console.log(progress.val());
           var soustrac = progress.prop('max') - progress.val() ;
           $('#progress' + type + nom).val(soustrac);
          // console.log(soustrac);
          break;
        case 'Autres':
         // $('#autres').append('<tr id="ligneModules"><th>'+nom +'</th><td><input type="button" value="+" style="min-height: 34px;"></tr>');
          break;  
      }       
       // console.log('ici 2 ');     
        affecter(idModule);
}

function affectation(idModule) {
    var arr = [];
   var inputs = $("#affectationFinale :input");
   //console.log('ici c\'est là');
  var graphiques = $("#affectationFinale").find('th');
  graphiques.each(function() {
         var prof = $(this).text();
         var profModif = prof.substr(0,prof.indexOf(' '));
         console.log(profModif) ;
         $(this).click(function() {
            graphique(profModif);
         });
    });
   inputs.each(function() {
              var element = {} ;
              var val = $(this).val();
              var id = $(this).parent('p').parent('th').parent('tr').attr('id');
              
              element.id = id;
              element.value = val;
              if(val > 0) {
              arr.push(element);
              }
           // console.log(JSON.stringify(element));
   });
   var progress = $("#affectationFinale .avancement");
   progress.each(function() {
               var element = {} ;
              var val = $(this).attr('value');
             // console.log(val);
              var id = $(this).parent('p').parent('th').parent('tr').attr('id');
              // console.log(id);
              element.id = id;
              element.value = val;
              if(val > 0) {
              arr.push(element);
              }
      //        console.log(JSON.stringify(element));
   });

$.ajax({
  type: "GET",
  contentType: "application/json; charset=utf-8",
  url: "affecter.php",
  data: { arr : JSON.stringify(arr), idMod : idModule },
  dataType: "json",
  success: function(data){alert(data);},
  failure: function(errMsg) {
    alert(errMsg);
  }
});
arr = [];

//graphique(idModule);

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
        //$('#chartContainer').html("");
       // console.log("ici");
	
            $.getJSON("graphiqueAffectation.php?nom=" + id, function (result) {
            
                var chart = new CanvasJS.Chart("chartContainer", {
                    data: [
                        {     
                            color: "#b42d0b",
                            dataPoints: result
                        }
                    ],
                     title:{
                     text: "Nombre de séquences affectées à "  + id
                        // more attributes 
                    },
                    axisY:{
                       title: "Nombre de groupes"
                    },
                    axisX: {
                      title: "Sequence"
                    }
                });

                chart.render();
            });
  }
