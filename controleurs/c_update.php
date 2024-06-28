<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$pdo = PdoGsb::getPdoGsb(); 

switch ($action) {

    case 'supprimerEleve':
        echo"idiot";
        $id = $_GET['id'];
        $pdo->supprimerUnEleve($id);
        $message = 'Suppression réussie';
        header("Refresh: 1;URL=index.php?uc=initialisation");
        include 'vues/v_message.php';
        break;
    
}
?>
