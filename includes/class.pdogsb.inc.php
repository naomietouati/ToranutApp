<?php
class PdoGsb
{
    private static $bdd = 'includes/toranut_db.db';
    private static $monPdo;
    private static $monPdoGsb = null;

    private function __construct()
    {
        try {
            self::$monPdo = new PDO('sqlite:' . self::$bdd);
            self::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$monPdo->exec('PRAGMA foreign_keys = ON;');
            self::$monPdo->exec('PRAGMA encoding = "UTF-8";');
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            die(); // Arrête le script si la connexion échoue
        }
    }

    public static function getPDOGsb()
    {
        if (self::$monPdoGsb == null) {
            self::$monPdoGsb = new PdoGsb();
        }
        return self::$monPdoGsb;
    }

    public function BDD_Existe()
    {
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name='eleves'";
        $result = PdoGsb::$monPdo->query($query);
    
        if ($result->fetch()) {
            return true; // La table 'eleves' existe
        } else {
            return false; // La table 'eleves' n'existe pas
        }
    }
    
    public function CreationTableEleves(){
        $requete = "CREATE TABLE IF NOT EXISTS eleves (
            id INTEGER PRIMARY KEY,
            nom VARCHAR(50),
            prenom VARCHAR(50),
            absent BOOLEAN DEFAULT 0,
            tache INT
        )";
        PdoGsb::$monPdo->exec($requete);
    }
    

    
    public function SupprimerTableEleves(){
        $requete = "DROP TABLE eleves";
        PdoGsb::$monPdo->exec($requete);      
    }
    
    public function supprimerUnEleve($id){
         
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'DELETE FROM eleves '
            . 'WHERE eleves.id = :unIdEleve'
        );
        $requetePrepare->bindParam(':unIdEleve', $id, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    
     public function modifierUnEleve($id,$nom,$prenom) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE eleves SET nom = :nom, prenom = :prenom WHERE id = :id'
        );
        $requetePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requetePrepare->bindParam(':prenom', $prenom, PDO::PARAM_STR);

        $requetePrepare->execute();
    }

    
    public function enregistrerEleves($nom, $prenom) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'INSERT INTO eleves (nom, prenom) VALUES (:nom, :prenom)'
        );
        $requetePrepare->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requetePrepare->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    public function afficherEleve() {
        $requete = "SELECT id, nom, prenom FROM eleves";
        $resultat = PdoGsb::$monPdo->query($requete);
        $eleves = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $eleves;
    }
    
    public function afficherElevePresente() {
        $requete = "SELECT id, nom, prenom FROM eleves WHERE absent = 0";
        $resultat = PdoGsb::$monPdo->query($requete);
        $eleves = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $eleves;
    }
    
    public function declarerAbsente($eleveId) {
      $requetePrepare = PdoGSB::$monPdo->prepare(
          'UPDATE eleves SET absent = 1 WHERE id = :id'
      );
      $requetePrepare->bindValue(':id', $eleveId, PDO::PARAM_INT);
      $requetePrepare->execute();
    }
    
     public function initialisationAbsente() {
      $requetePrepare = PdoGSB::$monPdo->prepare(
          'UPDATE eleves SET absent = 0 '
      );
      $requetePrepare->execute();
    }
    
    //fonction qui affiche le nbr de pers par tache du repas du soir
    public function NbPersDefautTacheS() {
        $requete = "SELECT id, nom, nbPersDefaut FROM taches WHERE repas LIKE 'S%'";
        $resultat = PdoGsb::$monPdo->query($requete);
        $tacheSoir = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheSoir;
    }
    //fonction qui affiche le nbr de pers par tache du repas de midi
    public function NbPersDefautTacheM() {
        $requete = "SELECT id, nom, nbPersDefaut FROM taches WHERE repas LIKE '%M%'";
        $resultat = PdoGsb::$monPdo->query($requete);
        $tacheMidi = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheMidi;
    }

    //fonction qui affiche le nbr de pers par tache du repas de seoudat chlichit
    public function NbPersDefautTacheC() {
        $requete = "SELECT id, nom, nbPersDefaut FROM taches WHERE repas LIKE '%C'";
        $resultat = PdoGsb::$monPdo->query($requete);
        $tacheC = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheC;
    }
    
    public function majNbPers($id, $nbPersDefaut) {
        $requetePrepare = PdoGSB::$monPdo->prepare('UPDATE taches SET nbPers = :nbPersDefaut WHERE id = :id');
        $requetePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':nbPersDefaut', $nbPersDefaut, PDO::PARAM_INT);

        $requetePrepare->execute();
    }
    
     //fonction qui affiche le nbr de pers par tache du repas du soir pour faire le tableau
    public function NbPersTacheS() {
        $requete = "SELECT id, nom, nbPers FROM taches WHERE repas LIKE 'S%'";
        $resultat = PdoGsb::$monPdo->query($requete);
        $tacheSoir = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheSoir;
    }
    //fonction qui affiche le nbr de pers par tache du repas de midi pour faire le tableau
    public function NbPersTacheM() {
        $requete = "SELECT id, nom, nbPers FROM taches WHERE repas LIKE '%M%'";
        $resultat = PdoGsb::$monPdo->query($requete);
        $tacheMidi = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheMidi;
    }

    //fonction qui affiche le nbr de pers par tache du repas de seoudat chlichit pour faire le tableau
    public function NbPersTacheC() {
        $requete = "SELECT id, nom, nbPers FROM taches WHERE repas LIKE '%C'";
        $resultat = PdoGsb::$monPdo->query($requete);
        $tacheC = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheC;
    }
    
}
