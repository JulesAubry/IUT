<?php

require_once 'webpage.class.php';

session_start();


if(isset($_SESSION['login']['idIntervenant']) && !empty($_SESSION['login']['idIntervenant']) && isset($_SESSION['login']['status']) && $_SESSION['login']['status']==0){

//var_dump($_SESSION['voeux']);

    $page = new WebPage('Formulaire de voeux');
    
    $page->appendJsUrl('js/request.js');
    $page->appendJsUrl('js/voeux.js');
    $page->appendCssUrl('css/voeux.css');
    $page->appendCssUrl('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') ;
    $page->appendJsUrl('//code.jquery.com/jquery-1.10.2.js') ;
    $page->appendJsUrl('//code.jquery.com/ui/1.11.3/jquery-ui.js') ; 
    $page->appendJsUrl('js/canvasjs/jquery.canvasjs.min.js') ;
       
    
    $page->appendContent(<<<HTML
                <nav>
                    <div id="erreur"></div>
			
					<div id="boutonsSemestres">
                        <a id="lepremierSemestre" class="semestresBouton" onclick="semestre(1); colorerSemestres(this)">Semestre 1</a>
                        <a class="semestresBouton" onclick="semestre(2); colorerSemestres(this)">Semestre 2</a>
                        <a class="semestresBouton" onclick="semestre(3); colorerSemestres(this)">Semestre 3</a>
                        <a class="semestresBouton" onclick="semestre(4); colorerSemestres(this)">Semestre 4</a>
                    </div>
                    <table id="infosProf">
                        <tr>
                            <td id="nomProf">{$_SESSION['login']['nom']}
                            <td><hr/>
                            <td><img src="img/disconnect.png" class="profBouton" onclick="logout()">
                        </tr>
                    </table>
                </nav>
                <hr>
                <div id="content">
                    <div id="modules">
                      
                        <div id="scroll" style='overflow-y:scroll ; '>
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
                    </div>
                    <div id="infos" style="overflow:auto; background-image:url('img/infos.png') ; background-repeat:no-repeat; background-position:left top;  background-size: 80px 80px;">
                        <table id="infosTable">			
                        </table>
                    </div>
                    <div id="quotas" style="background-image:url('img/quotas.png') ; background-repeat:no-repeat; background-position:left top;  background-size: 80px 80px;">
                        <table id="valueSemestres">			
                        </table>
                        <div id="valueQuotas"></div>
                    </div>
                    <br>
                     <br><br /> <br><br />
                   <div id="chartContainer"></div>
                </div>
HTML
    );
    
    echo $page->toHTML();
}
else{
    header('Location: index.php');
}