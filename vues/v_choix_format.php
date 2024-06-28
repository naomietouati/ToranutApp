<!DOCTYPE html>
<html>
<head>
  <title>Options de repas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    .hidden  {
      display: none;
    }
  </style>
</head>
<br>
<body>
  <div class="radioChoice">
    <h2>Options des repas</h2>
    <form method="POST" action="index.php?uc=choix_format&action=validation_choix">
      <div class="form-group">
        <div>
          <input class="form-check-input" type="checkbox" id="chabbat" name="chabbat" >
          <label class="form-check-label" for="option1">Chabbat</label>
        </div>
        <br>
        <div>
          <input type="checkbox" id="yom_tov" name="yom_tov" value="option2">
          <label  for="option2">Yom Tov</label>
        </div>
      </div>

      <div class="choixRepas" id="repas">
        <h4>Quantité de repas</h4>
        <div>
          <label for="repasSoir">Repas du soir:</label>
          <input type="number" class="form-control" id="repasSoir" name="repasSoir">
        </div>
        <div>
          <label for="repasMidi">Repas de midi:</label>
          <input type="number" class="form-control" id="repasMidi" name="repasMidi">
        </div>
        <div>
          <label for="repasHahag">Nehila Hah'ag:</label>
          <input type="number" class="form-control" id="nehilatHahag" name="nehilatHahag">
        </div>
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
  </div>


<script>
  const option2Checkbox = document.getElementById("yom_tov");
  const repasDiv = document.getElementById("repas");
  
  repasDiv.classList.add("hidden");

  option2Checkbox.addEventListener("click", function() {
    if (this.checked) {
      repasDiv.classList.remove("hidden");
      repasDiv.classList.add("shifted");
    } else {
      repasDiv.classList.add("hidden");
      repasDiv.classList.remove("shifted");
    }
  });
</script>

</body>
</html>







