<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$pdo = PdoGsb::getPDOGsb();

$action = filter_input(INPUT_GET, 'action',);

switch ($action) {
    case 'valideNbPersTache':
        $repasS = $pdo->NbPersDefautTacheS();
        $repasM = $pdo->NbPersDefautTacheM();
        $repasC = $pdo->NbPersDefautTacheC();
        include 'vues/v_nb_pers_tache.php';
        break;
    
    
    case 'majNbPers':
        $nbPersDefautArray = $_POST['nbPersDefaut'];
        foreach ($nbPersDefautArray as $id => $nbPersDefaut) {
            $pdo->majNbPers($id, $nbPersDefaut);
        }
       // header("Refresh: 1;URL=index.php?uc=attribution&action=generer_tableau");
        echo '<script>window.location.href = "index.php?uc=attribution&action=generer_tableau";</script>';
        break;
}
