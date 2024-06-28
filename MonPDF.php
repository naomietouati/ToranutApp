<?php

require('fpdf/fpdf.php');

class MonPDF extends FPDF
{
function genererPDF($tableauxTaches)
{
    $this->AliasNbPages();

    foreach ($tableauxTaches as $tableauTaches) {
        $nomRepas = $tableauTaches['nomRepas'];
        $taches = $tableauTaches['tableau'];

        $this->AddPage('P', 'A4');

      
        $this->Image('./images/fondpdf.jpg', 0, 0, $this->GetPageWidth(), $this->GetPageHeight(), '', '', '', false);

 
        $this->SetFont('Arial', '', 12);

    
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 12, $nomRepas, 0, 1, 'C');

 
        $this->Ln(10);

 
        foreach ($taches as $index => $tache) {
            $nomTache = $tache['nom'];
            $elevesAttribues = $tache['eleves'];

            $this->SetFont('Arial', 'B', 12);
            if ($index > 0) {
                $this->Ln(2); 
            }
            $this->Cell(0, 10, utf8_decode($nomTache), 1, 1, 'L');

            $this->SetFont('Arial', '', 12);
            $elevesCellule = implode(', ', $elevesAttribues);
            $this->Cell(0, 10, utf8_decode($elevesCellule), 1, 1, 'L');
        }

        $this->Ln(10);
    }

    // Sauvegarder le contenu dans le fichier PDF
   // $this->Output('F', 'Toranut.pdf');

    // Générer le PDF dans un fichier local new version
    $pdfFilePath = 'Toranut.pdf';
    $this->Output('F', $pdfFilePath);

    return $pdfFilePath;
}

}