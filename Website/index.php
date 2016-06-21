<?php

require_once 'webpage.class.php';
require_once "myPDO.include.php";

session_start();

$erreur = "";


if(isset($_SESSION['login']['idIntervenant']) && isset($_SESSION['login']['status'])){
    

  if($_SESSION['login']['status']==0){
        header('Location: voeux.php');
    }
    else{
        header('Location: admin.php');
    }
}


if(isset($_POST['code']) && !empty($_POST['code'])){
    $stmt = myPDO::getInstance()->prepare(<<<SQL
    SELECT idIntervenant, nom, prenom, admin
    FROM Intervenant
    WHERE SHA1(CONCAT(pass, :challenge, SHA1(loginLDAP))) = :code
SQL
    ) ;

    $stmt->execute(array(
        ':challenge' => isset($_SESSION['login']['challenge']) ? $_SESSION['login']['challenge'] : '',
        ':code'      => $_POST['code']));
    
    unset($_SESSION['login']['challenge']) ;

    if (($ligne = $stmt->fetch()) !== false) {
        $_SESSION['login']['idIntervenant'] = $ligne['idIntervenant'];
        $nom = ucfirst(strtolower($ligne['nom']));
        $prenom = ucfirst(strtolower($ligne['prenom']));
        $_SESSION['login']['nom'] = $prenom." ".$nom;
        $_SESSION['login']['status'] = $ligne['admin'];
        header('Location: init_BD.php');
    }
    else {
        $erreur = "Login ou mot de passe incorrect !";
    }
}

$page = new WebPage('Connexion');

$_SESSION['login']['challenge'] = randomString(16);

$page->appendJsUrl('js/sha1.js');
$page->appendJs(<<<JAVASCRIPT
    function crypter(f, challenge) {
        if (f.login.value.length && f.pass.value.length) {
            f.code.value = SHA1(SHA1(f.pass.value)+challenge+SHA1(f.login.value)) ;
            f.login.value = f.pass.value = '' ;
            return true ;
        }
        return false ;
}
JAVASCRIPT
);

$page->appendCssUrl('css/index.css');

$page->appendContent(<<<HTML
                    <span id="erreur">{$erreur}</span>
                    <img src="img/urca.png">
                    <form name='auth' action='index.php' method='POST' onSubmit="return crypter(this, '{$_SESSION['login']['challenge']}')" autocomplete='off'>
                        <input type='email' name='login' placeholder="E-mail">
                        <hr>
                        <input type='password' name='pass' placeholder="Password">
                        <hr>
                        <input type='hidden' name='code'>
                        <input type='submit' value="Connexion">
                    </form>
HTML
);

echo $page->toHTML();

function randomString($size) {
    $s = '' ;
    for ($i=0; $i<$size; $i++) {
        switch (rand(0, 2)) {
        case 0 :
            $s .= chr(rand(ord('A'), ord('Z'))) ;
            break ;
        case 1 :
            $s .= chr(rand(ord('a'), ord('z'))) ;
            break ;
        case 2 :
            $s .= chr(rand(ord('1'), ord('9'))) ;
            break ;
        }
    }
    return $s ;
}