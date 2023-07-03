<?php
        // Démarrer la séance
    session_start(); 
        // Annuler toutes les variables de session
    session_unset(); 
        // Détruire la session
    session_destroy(); 
        // Rediriger vers la login page
    header("Location: login.php");
    exit;
?>