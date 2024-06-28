<!DOCTYPE html>
<html>
<head>
  <title>Préparation du PDF</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <style>
    /* Ajoutez vos styles CSS ici */
  </style>
  <script>
    function hideDownloadButton() {
      var loadingContainer = document.querySelector('.loading-container');
      var spinner = document.querySelector('.spinner');
      var downloadButton = document.querySelector('.btn');
      var redirectButton = document.createElement('a');
      
      // Masquer le bouton de téléchargement et le spinner
      downloadButton.style.display = 'none';
      spinner.style.display = 'none';
      
     
      redirectButton.href = "index.php?"; 
      redirectButton.innerText = 'Retourner à la page d\'accueil';
      redirectButton.classList.add('btn');
      
      // Ajouter le bouton de redirection à la div loading-container
      loadingContainer.appendChild(redirectButton);
    }
  </script>
</head>
<body>
  <div class="loading-container">
    <div class="spinner"></div>
    <div>
      <a href="index.php?uc=attribution&action=telechargerPdf" class="btn" onclick="hideDownloadButton()">Télécharger</a>
    </div>
  </div>
</body>
</html>
