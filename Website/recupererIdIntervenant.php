<?php


session_start();

if (isset($_SESSION['login']['idIntervenant'])) {
    echo $_SESSION['login']['idIntervenant'];
}