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
    $page->appendJsUrl('js/module.js');
    $page->appendCssUrl('css/module.css');
    $page->appendJsUrl('js/jquery.csv-0.71.min.js');    
    $page->appendJsUrl('js/jquery.ui.widget.js');
    $page->appendJsUrl('js/jquery.iframe-transport.js');
    $page->appendJsUrl('js/jquery.fileupload.js');
    $page->appendJsUrl('http://html5shim.googlecode.com/svn/trunk/html5.js');
    $page->appendJsUrl('js/canvasjs/jquery.canvasjs.min.js') ;


    $page->appendContent(<<<HTML
        <div id="dialog" title="Basic dialog">
                </div>
        <div id="preference"></div>
        <div id="modifier"></div>
        <div id="confirme"></div>
                <nav>
                    <div id="erreur"></div>
		    <a href="index.php" > <img src="img/bouton_accueil.png" width="50" height="50" > </img>
                    <div id="boutonsSemestres">
                        <a  id="lepremierSemestre"  class="semestresBouton" onclick="semestre(1); colorerSemestres(this)">Semestre 1</a>
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
                 <div id="changerRepar" > </div>
                    <div id="modules" style='overflow-y: scroll; z-index:0'>
                        <div id="scroll">
                         <table id="tableau">
		                  </table></div>
                    </div>
                    <div id="quotas" style='overflow-y: scroll; z-index:0'>
                       
                        <table id="valueQuotas">			
                        </table>
                    </div>
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