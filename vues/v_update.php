<!DOCTYPE html>
<html>
<head>
    <title>Liste des élèves</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form method="POST" action="index.php?uc=update">
    <div class="containerAbsente">
        <?php if (count($tableauEleve) > 0) { ?>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th >Nom</th>
                        <th>Prénom</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tableauEleve as $unEleve) {
                        $nom = $unEleve['nom'];
                        $prenom = $unEleve['prenom'];
                        $id = $unEleve['id'];
                    ?>           
                    <tr>
                        <td class="tdUpdate">        
                            <?php echo $nom ?>
                        </td>
                        <td class="tdUpdate">
                            <?php echo $prenom ?>
                        </td>
                        <td class="tdUpdate">
                            <a href="index.php?uc=update&action=supprimerEleve&id=<?php echo $id ?>" class="btnUpdate">Supprimer</a>
                        </td>
                    </tr>

                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucune élève trouvé.</p>
        <?php } ?>
            
            <a href="index.php?uc=accueil" type="submit" class="btn btn-primary">Terminer
            </a>
    </div>
    </form>
</body>
</html>
