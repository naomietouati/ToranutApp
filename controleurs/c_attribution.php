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

        // Repas du Soir
if ($_SESSION['chabbat'] && $_SESSION['repasSoir'] > 0) {
    $K = 1 + $_SESSION['repasSoir'];
} else {
    $K = 1;
}

$N = 0;
while ($N < $K) {
    $tableauTachesSoir = array();
    if ($N == 1 || !$_SESSION['chabbat']) {
        $nomRepasS = "1er Soir";
    } else if ($N == 2 || (!$_SESSION['chabbat'] && $N == 1)) {
        $nomRepasS = "2ème Soir";
    } else if ($_SESSION['chabbat']) {
        $nomRepasS = "Vendredi Soir";
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

        // Repas du Midi
        if ($_SESSION['chabbat'] && $_SESSION['repasMidi'] > 0) {
            $K = 1 + $_SESSION['repasMidi'];
        } else {
            $K = 1;
        }

        $N = 0;
        while ($N < $K) {
            $tableauTachesMidi = array();
            if ($N == 1 || !$_SESSION['chabbat']) {
                $nomRepasM = "1er Midi";
            } else if ($N == 2 || (!$_SESSION['chabbat'] && $N == 1)) {
                $nomRepasM = "2ème Midi";
            } else if ($_SESSION['chabbat']) {
                $nomRepasM = "Chabbat Midi";
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

        // Repas de Nehilat hahag
        if ($_SESSION['chabbat'] && $_SESSION['nehilatHahag'] > 0) {
            $K = 1 + $_SESSION['nehilatHahag'];
        } else {
            $K = 1;
        }

        $N = 0;
        while ($N < $K) {
            $tableauTachesC = array();
            if ($N == 1 && $_SESSION['chabbat'] || !$_SESSION['chabbat']) {
                $nomRepasC = "Nehila Hah'ag";
            }
            if ($_SESSION['chabbat'] && $N == 0) {
                $nomRepasC = "Seouda Chlichit";
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

            $N++;
        }

        // Génération du PDF une seule fois après avoir construit toutes les données
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
