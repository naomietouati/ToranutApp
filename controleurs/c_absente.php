<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$elevesAbsents = array();

switch ($action) {
    case 'declaration_absente':
        $elevesAbsents = $pdo->afficherEleve();
        break;
    
case 'validation_absente':
    if (isset($_POST['eleves']) && !empty($_POST['eleves'])) {
        $elevesSelectionnes = $_POST['eleves'];
        var_dump($elevesSelectionnes);

        foreach ($elevesSelectionnes as $eleveId) {
            $nom = filter_input(INPUT_POST, 'nom_' . $eleveId, FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom_' . $eleveId, FILTER_SANITIZE_STRING);
            $pdo->declarerAbsente($eleveId); 
        }
        $message = 'Les absentes ont bien été prises en compte!';  
    } else {
        $message = 'Aucune élèves sélectionnée comme absente.';
    }
    
    //header("Refresh:1;index.php?uc=choix_format");
    echo '<script>window.location.href = "index.php?uc=choix_format";</script>';
    include 'vues/v_message.php';
    break;
}

include 'vues/v_absente.php';



