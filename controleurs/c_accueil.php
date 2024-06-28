<?php
$action = filter_input(INPUT_GET, 'action');
$bddExiste = $pdo->BDD_Existe();
include 'vues/v_accueil.php';
                
switch ($action) {

    case 'supprimerEleve':
        $showConfirmationForm = true;
        include 'vues/v_form_confirmation.php';
        break;

    case 'confirmationSuppr':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['confirm'])) {
                // L'utilisateur a confirmé la suppression
                $pdo->SupprimerTableEleves();
                $bddExiste = $pdo->BDD_Existe();
                if ($bddExiste == false) {
                    $message = 'Suppression réussie';
                    header("Refresh: 1;URL=index.php?uc=initialisation&action=ajouterEleve");
                } else {
                    $message = 'Suppression échouée';

                }
            } else if (isset($_POST['cancel'])) {
                $message = 'Suppression annulée';
               // include 'vues/v_accueil.php';  
            }
        } else {
            exit();
        }
        include 'vues/v_message.php';
        break;
}
?>
