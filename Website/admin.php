<?php

require_once 'webpage.class.php';

session_start();

if(isset($_SESSION['login']['idIntervenant']) && !empty($_SESSION['login']['idIntervenant']) && isset($_SESSION['login']['status']) && $_SESSION['login']['status']==1){

    $page = new WebPage('Administration');
    
    $page->appendCssUrl('css/admin.css');
    $page->appendJsUrl('js/request.js');
    $page->appendJsUrl('js/admin.js');
    
    $page->appendContent(<<<HTML
                        <img src="img/disconnect.png" class="logoutButton" onclick="logout()"/>
                        <form class="buttons">
                            <input class='button1' type="button" value="      Modification du calendrier" onClick="location.href='calendrier.php'">
                            <input class='button2' type="button" value="Statistiques" onClick="location.href='stats.php'">
                            </br>
                            <input class='button3' type="button" value="Affectation" onClick="location.href='affectation.php'">
                            <input class='button4' type="button" value="   Gestion des modules" onClick="location.href='module.php'">
                        </form>
HTML
    );
    
    echo $page->toHTML();
    
}
else{
    header('Location: index.php');
}