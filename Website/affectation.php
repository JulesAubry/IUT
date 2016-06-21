<?php

require_once 'webpage.class.php';
require_once "myPDO.include.php";

session_start();

if(isset($_SESSION['login']['idIntervenant']) && !empty($_SESSION['login']['idIntervenant']) && isset($_SESSION['login']['status']) && $_SESSION['login']['status']==1){


//var_dump($_SESSION['voeux']['infos']);

    $page = new WebPage('Visualisation de voeux');
    $page->appendCssUrl('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') ;
    $page->appendJsUrl('//code.jquery.com/jquery-1.10.2.js') ;
    $page->appendJsUrl('//code.jquery.com/ui/1.11.2/jquery-ui.js') ;
    $page->appendJsUrl('js/request.js');
    $page->appendJsUrl('js/jquery.fileupload.js');
    $page->appendJsUrl('js/affectation.js');
    $page->appendCssUrl('css/affectation.css');
    $page->appendJsUrl('js/jquery.csv-0.71.min.js');              
    $page->appendJsUrl('js/canvasjs/jquery.canvasjs.min.js') ;
    
    $page->appendContent(<<<HTML
        <div id="dialog" title="Basic dialog">
                </div>
        <div id="preference"></div>
        <div id="confirme"></div>
                <nav>
                    <div id="erreur"></div>
					<a href="index.php" > <img src="img/bouton_accueil.png" width="50" height="50" > </img>
                    <div id="boutonsSemestres">
                        <a  id="lepremierSemestre" class="semestresBouton" onclick="semestre(1); colorerSemestres(this)">Semestre 1</a>
                        <a class="semestresBouton" onclick="semestre(2); colorerSemestres(this)">Semestre 2</a>
                        <a class="semestresBouton" onclick="semestre(3); colorerSemestres(this)">Semestre 3</a>
                        <a class="semestresBouton" onclick="semestre(4); colorerSemestres(this)">Semestre 4</a>
                    </div>
                    <table id="infosProf">
                        <tr>
                            <td id="nomProf">{$_SESSION['login']['nom']}
                            <td><hr/>
                            <td><img src="img/setting.png" class="profBouton" onclick="prefs()">
                            <td><img src="img/disconnect.png" class="profBouton" onclick="logout()">
                        </tr>
                    </table>
                </nav>
                <hr>
                <div id="content">
                  <!--  <img src="img/voeux.png" class="logoBlock" style='margin-left:20px; margin-top:20px;'> -->
                   
                    <div id="modules" style='overflow-y: scroll; z-index:0' align="center">
              		      <div id="tabs">
                    			<ul>
                    			<li><a href="#tabs-1">TP</a></li>
                    			<li><a href="#tabs-2">TD</a></li>
                    			<li><a href="#tabs-3">CM</a></li>
                    			<li><a href="#tabs-4">PB</a></li>
                    			</ul>
                    			<div id="tabs-1">
                          
                    			  <table id="moduleTP">
                            
                    			  </table>
                    			</div>
                    			<div id="tabs-2">
                    			  <table id="moduleTD">
                    			  </table>
                    			</div>
                    			<div id="tabs-3">
                    			  <table id="moduleCM">
                    			  </table>
                    			</div>
                    			<div id="tabs-4">
                    			  <table id="modulePB">
                    			  </table>
              			     </div>
		                  </div>
                   </div>
                       <div id="professeurs" align="center">
			  <input type='text' id='searchBar' placeholder='Rechercher prof'>
			  <div id='accordion' style='width:100%;'>
			    <h3>Desiré</h3>
			      <div id='Desiree'>
			      <table id='desiree'>
				</table>
			      </div>
			    <h3>Dépannage<h3>
			      <div id='Depannee'>
				<table id='depannee'>
				  </table>
			      </div>
			    <h3>Non renseigné</h3>
			      <div id='Autres' style='overflow-y:scroll;  height:100px ; '>
				<table id='autres'>
				</table>
			      </div>	   
			  </div>
                        </table>
                    </div>
                           
                    <div id="affectationFinale" align="center">
                        <table id="valueQuotas">			
                        </table>
                    </div>
                 
                      <br><br /> <br><br />
                  
                </div>
                 <br><br /> <br><br /> <br><br /> <br><br /> <br><br /> <br><br /> <br><br /> <br><br /> <br><br /> <br><br />
                
                
                <div id="chartContainer"></div>
                
                </div>
HTML
    );
    
    echo $page->toHTML();
}
else{
    header('Location: index.php');
}