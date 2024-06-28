<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/class.pdogsb.inc.php';

session_start();

try {
    $pdo = PdoGsb::getPDOGsb();
    include 'vues/v_entete.php'; // Inclusion de l'en-tête qui contient le menu
    $bddExiste = $pdo->BDD_Existe();
    
    // Récupérer le paramètre 'uc' depuis l'URL
    $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
    echo '<p>UC: ' . $uc . '</p>'; // Ligne de debug

    // Définir une valeur par défaut pour 'uc' si nécessaire
    if (!$bddExiste) {
        $uc = 'initialisation';
        $pdo->CreationTableEleves();
        $b = $bddExiste == false;
    } elseif (empty($uc)) {
        $uc = 'accueil';
    }

    echo '<p>UC après initialisation: ' . $uc . '</p>'; // Ligne de debug

    // Gestion du routage en fonction de 'uc'
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

        default:
            include 'controleurs/c_accueil.php'; // Fallback to accueil if 'uc' is not recognized
            break;
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
