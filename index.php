<?php
require_once 'includes/class.pdogsb.inc.php';

$pdo = PdoGsb::getPDOGsb();
include 'vues/v_entete.php';
$bddExiste = $pdo->BDD_Existe();
session_start();

$uc = filter_input(INPUT_GET, 'uc');

if (!$bddExiste) {
    $uc = 'initialisation';
    $pdo->CreationTableEleves();
    $b = $bddExiste == false; 
} elseif (empty($uc)) { 
    $uc = 'accueil';
}

switch ($uc) {
    case 'accueil': 
        include 'controleurs/c_accueil.php';
        $pdo->initialisationAbsente();
        break;

    case 'initialisation': 
        include 'controleurs/c_initialisation.php';
        break;

    case 'absente': 
        include 'controleurs/c_absente.php';
        break;

    case 'update': 
        include 'controleurs/c_update.php';
        break;
    
    case 'attribution':
        include 'controleurs/c_attribution.php';
        break;
    
    case 'choix_format':
        include 'controleurs/c_choix_format.php';
        break;
    
    case 'nbPersTache':
        include 'controleurs/c_nb_pers_tache.php';
        break;
}
