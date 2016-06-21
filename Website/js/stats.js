// JavaScript Document

$( document ).ready(function() {
  reqProf = new Request(
        {
                url        : "statsAffectation.php",
                method     : 'post',
                handleAs   : 'json',
                parameters : {},
                onSuccess  : function(json) {
                var a ;
		                   for (var i in json) {
                       if (a == json[i].Matiere) {
                            $('#affectation').append('<tr > <td ></td> <td> ' + json[i].nom  + '</td> </tr>');
                       }
                       else {
                     $('#affectation').append('<tr> <td >' + json[i].Matiere + '</td> <td> ' + json[i].nom  + '</td> </tr>');
                     }
                        a =  json[i].Matiere;
                       }
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        }); 
        
});