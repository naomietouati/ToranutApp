<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<br>
<body>
  <div class="containerAbsente">
    <h2>Veuillez sélectionner les absentes de ce Chabbat !</h2>
    <br>

    <form action="index.php?uc=absente&action=validation_absente" method="post">
      <div>
        <?php foreach ($elevesAbsents as $eleve) { ?>
          <div class="list-group-item">
            <input type="checkbox" id="<?php echo $eleve['id']; ?>" name="eleves[]" value="<?php echo $eleve['id']; ?>">
            <label for="<?php echo $eleve['id']; ?>"><?php echo $eleve['prenom'] . ' ' . $eleve['nom']; ?></label>
          </div>
        <?php } ?>
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
  </div>
</body>

</html>
