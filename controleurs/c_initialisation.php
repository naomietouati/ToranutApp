<?php
$tableauEleve = array();
$action = filter_input(INPUT_GET, 'action',);

switch ($action) {
    case 'ajouterEleve':
        $pdo = PdoGsb::getPDOGsb(); 
        if (isset($_POST['nom']) && isset($_POST['prenom'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $pdo-> enregistrerEleves($nom, $prenom);
        }
        break;
}

$tabEleve = $pdo->afficherEleve(); 

if (is_array($tabEleve)) {
    $tableauEleve = $tabEleve;
}

include 'vues/v_initialisation.php';
include 'vues/v_update.php';
