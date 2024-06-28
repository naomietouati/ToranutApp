<?php
class PdoGsb
{
    private static $hostname = 'eu-cluster-west-01.k8s.cleardb.net';
    private static $username = 'b015a03328eefb';
    private static $password = 'cf3b287c';
    private static $database = 'heroku_c48f9fa37479c78';
    private static $monPdo;
    private static $monPdoGsb = null;

    private function __construct()
    {
        try {
            $dsn = 'mysql:host=' . self::$hostname . ';dbname=' . self::$database;
            self::$monPdo = new PDO($dsn, self::$username, self::$password);
            self::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$monPdo->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            die(); // Arrête le script si la connexion échoue
        }
    }

    public static function getPDOGsb()
    {
        if (self::$monPdoGsb === null) {
            self::$monPdoGsb = new PdoGsb();
        }
        return self::$monPdoGsb;
    }

    public function BDD_Existe()
    {
        try {
            $query = "SHOW TABLES LIKE 'eleves'";
            $stmt = self::$monPdo->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return !empty($result);
        } catch (PDOException $e) {
            echo 'Erreur lors de la vérification de l\'existence de la table : ' . $e->getMessage();
            return false;
        }
    }
    
    public function CreationTableEleves(){
        $requete = "CREATE TABLE IF NOT EXISTS eleves (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            nom VARCHAR(50),
            prenom VARCHAR(50),
            absent BOOLEAN DEFAULT 0,
            tache INT
        )";
        self::$monPdo->exec($requete);
    }
    
    public function SupprimerTableEleves(){
        $requete = "DROP TABLE IF EXISTS eleves";
        self::$monPdo->exec($requete);      
    }
    
    public function supprimerUnEleve($id){
        $requetePrepare = self::$monPdo->prepare(
            'DELETE FROM eleves '
            . 'WHERE id = :unIdEleve'
        );
        $requetePrepare->bindParam(':unIdEleve', $id, PDO::PARAM_INT);
        $requetePrepare->execute();
    }
    
    public function modifierUnEleve($id, $nom, $prenom) {
        $requetePrepare = self::$monPdo->prepare(
            'UPDATE eleves SET nom = :nom, prenom = :prenom WHERE id = :id'
        );
        $requetePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requetePrepare->bindParam(':prenom', $prenom, PDO::PARAM_STR);

        $requetePrepare->execute();
    }

    public function enregistrerEleves($nom, $prenom) {
        $requetePrepare = self::$monPdo->prepare(
            'INSERT INTO eleves (nom, prenom) VALUES (:nom, :prenom)'
        );
        $requetePrepare->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requetePrepare->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    public function afficherEleve() {
        $requete = "SELECT id, nom, prenom FROM eleves";
        $resultat = self::$monPdo->query($requete);
        $eleves = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $eleves;
    }

    public function afficherElevePresente() {
        $requete = "SELECT id, nom, prenom FROM eleves WHERE absent = 0";
        $resultat = self::$monPdo->query($requete);
        $eleves = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $eleves;
    }

    public function declarerAbsente($eleveId) {
        $requetePrepare = self::$monPdo->prepare(
            'UPDATE eleves SET absent = 1 WHERE id = :id'
        );
        $requetePrepare->bindValue(':id', $eleveId, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    public function initialisationAbsente() {
        $requetePrepare = self::$monPdo->prepare(
            'UPDATE eleves SET absent = 0'
        );
        $requetePrepare->execute();
    }

    // Fonctions pour les tâches (exemple)

    public function NbPersDefautTacheS() {
        $requete = "SELECT id, nom, nbPersDefaut FROM taches WHERE repas LIKE 'S%'";
        $resultat = self::$monPdo->query($requete);
        $tacheSoir = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheSoir;
    }

    public function NbPersDefautTacheM() {
        $requete = "SELECT id, nom, nbPersDefaut FROM taches WHERE repas LIKE '%M%'";
        $resultat = self::$monPdo->query($requete);
        $tacheMidi = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheMidi;
    }

    public function NbPersDefautTacheC() {
        $requete = "SELECT id, nom, nbPersDefaut FROM taches WHERE repas LIKE '%C'";
        $resultat = self::$monPdo->query($requete);
        $tacheC = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheC;
    }

    public function majNbPers($id, $nbPersDefaut) {
        $requetePrepare = self::$monPdo->prepare('UPDATE taches SET nbPersDefaut = :nbPersDefaut WHERE id = :id');
        $requetePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':nbPersDefaut', $nbPersDefaut, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    public function NbPersTacheS() {
        $requete = "SELECT id, nom, nbPers FROM taches WHERE repas LIKE 'S%'";
        $resultat = self::$monPdo->query($requete);
        $tacheSoir = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheSoir;
    }

    public function NbPersTacheM() {
        $requete = "SELECT id, nom, nbPers FROM taches WHERE repas LIKE '%M%'";
        $resultat = self::$monPdo->query($requete);
        $tacheMidi = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheMidi;
    }

    public function NbPersTacheC() {
        $requete = "SELECT id, nom, nbPers FROM taches WHERE repas LIKE '%C'";
        $resultat = self::$monPdo->query($requete);
        $tacheC = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $tacheC;
    }
}
?>
