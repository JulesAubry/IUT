function ajout(){
   $("#dialog" ).dialog({title:"Ajout d'un semestre", maxHeight: 250,maxWidth: 500,minHeight: 250,minWidth: 500});
    
    document.getElementById("dialog").innerHTML = "<form name='date' action='date.php' method='GET'>"+
    "<table>"+
    "<tr><td>Date de debut de semestre :</td><td><input type='date' name='date_debut' required></td></tr>"+
    "<tr><td>Date de demi semestre : </td><td><input type='date' name='date_milieu' required ></td></tr>"+
    "<tr><td>Date de fin de semestre :</td><td><input type='date' name='date_fin' required></td></tr> </table>"+
    "S1<input type=\"checkbox\" class=\"uncheck\" value=\"1\" name=\"semestre\"/> &nbsp;" +
    "S2<input type=\"checkbox\" class=\"uncheck\" value=\"2\" name=\"semestre\"/> &nbsp;" +
    "S3<input type=\"checkbox\" class=\"uncheck\" value=\"3\" name=\"semestre\"/> &nbsp;"  +
    "S4<input type=\"checkbox\" class=\"uncheck\" value=\"4\" name=\"semestre\"/></br>" +
    "<tr><td><input type='submit' id='submit'></td></tr></table></form>";
    $('input.uncheck').on('change', function() {
    $('input.uncheck').not(this).prop('checked', false);
  });  
}
// JavaScript Document
