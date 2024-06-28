<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un élève</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="containerAbsente">
        <h2>Ajouter une élève</h2>
        
        <form method="POST" action="index.php?uc=initialisation&action=ajouterEleve" class="choixRepas">
            <div>
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div>
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
