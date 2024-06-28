<?php
// ...
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Confirmation de suppression</title>
  <style>
    .custom-alert {
      max-width: 500px;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <?php if (isset($showConfirmationForm) && $showConfirmationForm): ?>
  <div class="containerAbsente">
    <h2>Confirmation de suppression</h2>
    <p>Êtes-vous sûr de vouloir supprimer la table des élèves ?</p>
    <form action="index.php?action=confirmationSuppr" method="post">
      <button type="submit" name="confirm" class="btnDanger">Confirmer</button>
      <br>
      <button type="submit" name="cancel" class="btnSucces">Annuler</button>
    </form>
  </div>
  <?php endif; ?>

</body>

</html>
