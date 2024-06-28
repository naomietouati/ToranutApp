<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>
<!DOCTYPE html>
<html lang="fr">

<body>
    <link rel="stylesheet" href="style.css">
    <form method="POST" action="index.php?uc=nbPersTache&action=majNbPers">
    <div class="tableaucontainer">
        <h2>Tâches Repas du Soir</h2>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Tâche</th>
                        <th>Nombre de personnes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repasS as $uneTache) {
                        $nom = htmlspecialchars($uneTache['nom']);
                        $nbPersDefaut = htmlspecialchars($uneTache['nbPersDefaut']);
                        $id = htmlspecialchars($uneTache['id']);
                    ?>
                        <tr>
                            <td><?php echo $nom ?></td>
                            <td>
                                <input type="text" id="nbPersDefaut<?php echo $id ?>" 
                                    name="nbPersDefaut[<?php echo $id ?>]"
                                    class="form-control" 
                                    value="<?php echo $nbPersDefaut ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
        </div>

        <h2>Tâches Repas du Midi</h2>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Tâche</th>
                        <th>Nombre de personnes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repasM as $uneTache) {
                        $nom = htmlspecialchars($uneTache['nom']);
                        $nbPersDefaut = htmlspecialchars($uneTache['nbPersDefaut']);
                        $id = htmlspecialchars($uneTache['id']);
                    ?>
                        <tr>
                            <td><?php echo $nom ?></td>
                            <td>
                                <input type="text" id="nbPersDefaut<?php echo $id ?>" 
                                    name="nbPersDefaut[<?php echo $id ?>]"
                                    class="form-control" 
                                    value="<?php echo $nbPersDefaut ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
        </div>

        <h2>Tâches Séouda Chlichit / Néhilat Ah'ag</h2>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Tâche</th>
                        <th>Nombre de personnes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repasC as $uneTache) {
                        $nom = htmlspecialchars($uneTache['nom']);
                        $nbPersDefaut = htmlspecialchars($uneTache['nbPersDefaut']);
                        $id = htmlspecialchars($uneTache['id']);
                    ?>
                        <tr>
                            <td><?php echo $nom ?></td>
                            <td>
                                <input type="text" id="nbPersDefaut<?php echo $id ?>" 
                                    name="nbPersDefaut[<?php echo $id ?>]"
                                    class="form-control" 
                                    value="<?php echo $nbPersDefaut ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
            <button type="submit" class="btn btn-primary validate-btn">Valider</button>
        </div>
    </div>
    </form>
</body>

</html>
