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
            for ($N = 1; $N <= $_SESSION['repasSoir']; $N++) {
                $tableauTachesSoir = array();
                $nomRepasS = ($_SESSION['repasSoir'] > 1) ? "$Nème Soir" : "Soir";
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
            }
        } else {
            // Par défaut, générer au moins un tableau pour le Repas du Soir
            $tableauTachesSoir = array();
            $nomRepasS = $_SESSION['chabbat'] ? "Vendredi Soir" : "Soir";
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
        }

        // Génération des tableaux pour le Repas du Midi
        if ($_SESSION['chabbat'] && $_SESSION['repasMidi'] > 0) {
            for ($N = 1; $N <= $_SESSION['repasMidi']; $N++) {
                $tableauTachesMidi = array();
                $nomRepasM = ($_SESSION['repasMidi'] > 1) ? "$Nème Midi" : "Midi";
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
            }
        } else {
            // Par défaut, générer au moins un tableau pour le Repas du Midi
            $tableauTachesMidi = array();
            $nomRepasM = $_SESSION['chabbat'] ? "Chabbat Midi" : "Midi";
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
        }

        // Génération des tableaux pour le Repas de Nehilat hahag
        if ($_SESSION['chabbat'] && $_SESSION['nehilatHahag'] > 0) {
            for ($N = 1; $N <= $_SESSION['nehilatHahag']; $N++) {
                $tableauTachesC = array();
                $nomRepasC = ($_SESSION['nehilatHahag'] > 1 && $N == 1) ? "Nehila Hah'ag" : "Seouda Chlichit";
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
            }
        } else {
            // Par défaut, générer au moins un tableau pour le Repas de Nehilat hahag
            $tableauTachesC = array();
            $nomRepasC = $_SESSION['chabbat'] ? "Seouda Chlichit" : "Nehilat Hah'ag";
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
