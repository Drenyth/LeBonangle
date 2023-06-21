<?php 
    session_start(); // demarrage de la session
    session_destroy(); // on détruit la/les session(s), soit si vous utilisez une autre session, utilisez de préférence le unset()
    unset($_COOKIE['userid']);
    setcookie('userid', '', time() - 10); 
    header('Location:landing.php'); // On redirige
    die();