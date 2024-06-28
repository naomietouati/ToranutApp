<?php

/* 
 * Contrôleur qui génère le tableau des tâches
 */

$pdo = PdoGsb::getPDOGsb();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
require('MonPDF.php');

switch ($action) {
    case 'generer_tableau':
        include 'vues/v_attribution.php';
        break;

    case 'telechargerPdf':
        session_start();

        $listeElevePresente = $pdo->afficherElevePresente();
        $_SESSION["listeEleve"] = $listeElevePresente;
        shuffle($_SESSION["listeEleve"]);
        $N = 0;

        // Repas du Soir
        if ($_SESSION['chabbat']==true && $_SESSION['repasSoir'] > 0) {
            $K = 1 + $_SESSION['repasSoir'];
            
        } else {
            $K = 1;
        }
        $nomRepasS = ""; 
        while ($N < $K) {
            $tableauTachesSoir = array();
            if ($N == 1 || $_SESSION['chabbat'] == false) {
                $nomRepasS = "1er Soir";
            } else if ($N == 2 || ($_SESSION['chabbat'] == false && $N == 1)) {
                $nomRepasS = "2 eme Soir";
            } else if ($_SESSION['chabbat'] == true) {
                $nomRepasS = "Vendredi Soir";
            } 
            if (empty($_SESSION["listeEleve"])) {
                $listeElevePresente = $pdo->afficherElevePresente();
                $_SESSION["listeEleve"] = $listeElevePresente;
                shuffle($_SESSION["listeEleve"]);
            }

            $repasS = $pdo->NbPersTacheS(); // tableau des tâches (id, nom, nbPers)

            foreach ($repasS as $tache) {
                $nomTache = $tache['nom'];
                $nbPersRequis = $tache['nbPers'];

                $elevesAttribues = array();
                for ($i = 0; $i < $nbPersRequis; $i++) {
                    if (empty($_SESSION["listeEleve"])) {
                        $listeElevePresente = $pdo->afficherElevePresente();
                        $_SESSION["listeEleve"] = $listeElevePresente;
                        shuffle($_SESSION["listeEleve"]);
                    }
                    $eleve = array_shift($_SESSION["listeEleve"]);
                    $elevesAttribues[] = $eleve['nom'] . ' ' . $eleve['prenom'];
                }
                

                $tableauTachesSoir[] = array(
                    'nom' => $nomTache,
                    'eleves' => $elevesAttribues
                );
            }
             $tableauxTaches[] = array(
                'nomRepas' => $nomRepasS,
                'tableau' => $tableauTachesSoir
            );
            
            $pdf = new MonPDF();
            $pdf->genererPDF($tableauxTaches);
            $N = $N + 1;
        }

        // Repas du Midi
        if ($_SESSION['chabbat'] && $_SESSION['repasMidi'] > 0) {
            $K = 1 + $_SESSION['repasMidi'];
        } else {
            $K = 1;
        }

        $N = 0;
        $nomRepasM = ""; // Réinitialisation en dehors de la boucle
        while ($N < $K) {
            $tableauTachesMidi = array();
            if ($N == 1 || $_SESSION['chabbat'] == false) {
                $nomRepasM = "1er Midi";
            } else if ($N == 2 || ($_SESSION['chabbat'] == false && $N == 1)) {
                $nomRepasM = "2eme Midi";
            } else if ($_SESSION['chabbat'] == true) {
                $nomRepasM = "Chabbat Midi";
            }

            if (empty($_SESSION["listeEleve"])) {
                $listeElevePresente = $pdo->afficherElevePresente();
                $_SESSION["listeEleve"] = $listeElevePresente;
                shuffle($_SESSION["listeEleve"]);
            }

            $repasM = $pdo->NbPersTacheM(); // tableau des tâches (id, nom, nbPers)

            foreach ($repasM as $tache) {
                $nomTache = $tache['nom'];
                $nbPersRequis = $tache['nbPers'];

                $elevesAttribues = array();
                for ($i = 0; $i < $nbPersRequis; $i++) {
                    if (empty($_SESSION["listeEleve"])) {
                        $listeElevePresente = $pdo->afficherElevePresente();
                        $_SESSION["listeEleve"] = $listeElevePresente;
                        shuffle($_SESSION["listeEleve"]);
                    }
                    $eleve = array_shift($_SESSION["listeEleve"]);
                    $elevesAttribues[] = $eleve['nom'] . ' ' . $eleve['prenom'];
                }

                $tableauTachesMidi[] = array(
                    'nom' => $nomTache,
                    'eleves' => $elevesAttribues
                );
            }
             $tableauxTaches[] = array(
                'nomRepas' => $nomRepasM,
                'tableau' => $tableauTachesMidi
            );
            $pdf = new MonPDF();
            $pdf->genererPDF($tableauxTaches);
            $N = $N + 1;
        }

        // Repas de Nehilat hahag
        if ($_SESSION['chabbat'] && $_SESSION['nehilatHahag'] > 0) {
            $K = 1 + $_SESSION['nehilatHahag'];
        } else {
            $K = 1;
        }

        $N = 0;
        $nomRepasC = "";
        while ($N < $K) {
            $tableauTachesC = array();
            if ($N == 1 && $_SESSION['chabbat']==true || $_SESSION['chabbat']==false) {
                $nomRepasC = "Nehila Hah'ag";
            }if($_SESSION['chabbat']==true && $N == 0){
                $nomRepasC = "Seouda Chlichit";
            }
            if (empty($_SESSION["listeEleve"])) {
                $listeElevePresente = $pdo->afficherElevePresente();
                $_SESSION["listeEleve"] = $listeElevePresente;
                shuffle($_SESSION["listeEleve"]);
            }

            $repasC = $pdo->NbPersTacheC(); // tableau des tâches (id, nom, nbPers)

            foreach ($repasC as $tache) {
                $nomTache = $tache['nom'];
                $nbPersRequis = $tache['nbPers'];

                $elevesAttribues = array();
                for ($i = 0; $i < $nbPersRequis; $i++) {
                    if (empty($_SESSION["listeEleve"])) {
                        $listeElevePresente = $pdo->afficherElevePresente();
                        $_SESSION["listeEleve"] = $listeElevePresente;
                        shuffle($_SESSION["listeEleve"]);
                    }
                    $eleve = array_shift($_SESSION["listeEleve"]);
                    $elevesAttribues[] = $eleve['nom'] . ' ' . $eleve['prenom'];
                }

                $tableauTachesC[] = array(
                    'nom' => $nomTache,
                    'eleves' => $elevesAttribues
                );
            }
             $tableauxTaches[] = array(
                'nomRepas' => $nomRepasC,
                'tableau' => $tableauTachesC
            );
            $pdf = new MonPDF();
            $pdf->genererPDF($tableauxTaches);
            $N = $N + 1;
          
        }
    
        ob_start();
        header("Content-Disposition: attachment; filename=Tableaux_Toranout.pdf");
        $pdf->Output('D', 'Tableaux_Toranout.pdf');
        ob_end_flush();
        
        break;

 
}