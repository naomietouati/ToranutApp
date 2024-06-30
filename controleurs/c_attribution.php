<?php

/* 
 * Contrôleur qui génère le tableau des tâches
 */

$pdo = PdoGsb::getPDOGsb();
$action = filter_input(INPUT_GET, 'action');
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
        $tableauxTaches = array();

        // Génération des tableaux pour le Repas du Soir
        if ($_SESSION['chabbat'] && $_SESSION['repasSoir'] > 0) {
            $K = 1 + $_SESSION['repasSoir'];
        } else {
            $K = 1;
        }

        $N = 0;
        while ($N < $K) {
            $tableauTachesSoir = array();
            if ($N == 0 && $_SESSION['chabbat']) {
                $nomRepasS = "Vendredi Soir";
            } else {
                $nomRepasS = ($N + 1) . "ème Soir";
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

            $N++;
        }

        // Génération des tableaux pour le Repas du Midi
        if ($_SESSION['chabbat'] && $_SESSION['repasMidi'] > 0) {
            $K = 1 + $_SESSION['repasMidi'];
        } else {
            $K = 1;
        }

        $N = 0;
        while ($N < $K) {
            $tableauTachesMidi = array();
            if ($N == 0 && $_SESSION['chabbat']) {
                $nomRepasM = "Chabbat Midi";
            } else {
                $nomRepasM = ($N + 1) . "ème Midi";
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

            $N++;
        }

        // Génération du PDF une seule fois après avoir construit toutes les données
        $pdf = new MonPDF();
        $pdfFilePath = $pdf->genererPDF($tableauxTaches);

        // Capture de la sortie dans un buffer et envoi du PDF au navigateur
        ob_start();
        header("Content-Disposition: attachment; filename=Tableaux_Toranout.pdf");
        readfile($pdfFilePath);
        ob_end_flush();

        exit; // Assurez-vous d'arrêter l'exécution ici après avoir envoyé le PDF
        break;
}
