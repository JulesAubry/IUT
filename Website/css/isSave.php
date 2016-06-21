<?php

session_start();

if(isset($_SESSION['voeux']['save']) && !empty($_SESSION['voeux']['save'])){
    echo $_SESSION['voeux']['save'];
}