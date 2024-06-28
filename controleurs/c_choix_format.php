<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


include 'vues/v_choix_format.php';

$action = filter_input(INPUT_GET, 'action',);

switch ($action) {
    case 'validation_choix':
    
        $_SESSION['chabbat'] = filter_input(INPUT_POST, 'chabbat', FILTER_VALIDATE_BOOLEAN);
        $_SESSION['repasSoir'] = filter_input(INPUT_POST, 'repasSoir', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['repasMidi'] = filter_input(INPUT_POST, 'repasMidi', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['nehilatHahag'] = filter_input(INPUT_POST, 'nehilatHahag', FILTER_SANITIZE_NUMBER_INT);
        

        $message = 'Les informations ont bien été prises en compte';

        header("Refresh: 0;URL=index.php?uc=nbPersTache&action=valideNbPersTache");
        //echo '<script>window.location.href = "index.php?uc=nbPersTache&action=valideNbPersTache";</script>';

        include 'vues/v_message.php';
        break;
}
