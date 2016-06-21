<?php

require_once 'webpage.class.php';

session_start();


if(isset($_SESSION['login']['idIntervenant']) && !empty($_SESSION['login']['idIntervenant']) && isset($_SESSION['login']['status']) && $_SESSION['login']['status']==1){

//var_dump($_SESSION['login']);

    $page = new WebPage('Statistiques');
    
    $page->appendCssUrl('css/voeux.css');
    $page->appendCssUrl('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') ;
    $page->appendJsUrl('//code.jquery.com/jquery-1.10.2.js') ;
    $page->appendJsUrl('//code.jquery.com/ui/1.11.3/jquery-ui.js') ; 
    $page->appendJsUrl('js/canvasjs/jquery.canvasjs.min.js') ;
    $page->appendJsUrl('js/stats.js') ;
    $page->appendJsUrl('js/request.js') ;   
    $page->appendCssUrl('css/stats.css') ;
    
    $page->appendContent(<<<HTML
                <h1> Affectation : </h1>
                	<a href="index.php" > <img src="img/bouton_accueil.png" width="50" height="50" > </img>  </a>
                            <br>  <br><br>
                       <table id="affectation"  >  </table>
                 
HTML
    );
    
    echo $page->toHTML();
}
else{
    header('Location: index.php');
}