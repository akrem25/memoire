<?php
    // Démarrer la séance
  session_start();

      // Vérifiez si l'admin n'est pas connecté
    if (!isset($_SESSION['admin_id'])) {
      // Rediriger vers login.php si vous n'êtes pas connecté
      header("Location: login.php");
      exit;
    }

      // connexion à la base de donnée
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "booksto";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
      $nomauteur = $_POST['nomauteur'];
      $date = $_POST['date'];
      $pays = $_POST['pays'];
      $biographie = $_POST['biographie'];

        // Récupérer le fichier image uploadé
      $image = $_FILES['image']['name']; 
      $image_tmp = $_FILES['image']['tmp_name']; // Emplacement temporaire du fichier

        // Déplacer l'image vers un dossier de stockage
      $image_path = "images-books/auteur-img/" . $image;
      move_uploaded_file($image_tmp, $image_path);

        // Préparer la requête SQL d'insertion
      $sql = "INSERT INTO auteur (nomauteur, date, pays, biographie, image) VALUES (?, ?, ?, ?, ?)";

        // ça pour éviter les problèmes de sécurité
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssss", $nomauteur, $date, $pays, $biographie, $image_path);

        // Exécuter la requête avec les données fournies
      $stmt->execute();

        // Rediriger l'utilisateur vers une page de confirmation ou afficher un message de succès
      header("Location: auteur.php");
      exit();
  }


    // Récupérer la liste des auteurs depuis la base de données
  $sql = "SELECT * FROM auteur";
  $result = $conn->query($sql);

    // Fermer la connexion à la base de données
  $conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link rel="stylesheet" href="css/auteur.css">
  </head>
  <header>
    <div class="logo">
      <img src="../images-books/logo-full.png" alt="Logo Booky">
    </div>

    <ul class="nav-links">
      <li class="center"><a href="home.php">Accueil</a></li>
      <li class="center"><a href="livres.php">Livres</a></li>
      <li class="center"><a href="auteur.php">Auteurs</a></li>
      <li class="center"><a href="logout.php">Déconnexion</a></li>

    </ul>
  </header>
  <body>
    <!--formulaire ajouter livre -->
    <div class="form-container">
      <img src="../images-books/logo-two.png" alt="Logo 2">
      <form method="post" action="auteur.php" enctype="multipart/form-data">
        <input type="text" name="nomauteur" placeholder="Nom de l'auteur" required>
        <input type="text" name="date" placeholder="date de naissance" required>
        <input type="text" name="pays" placeholder="lieu d'origine" required>
        <textarea name="biographie" placeholder="Biographie de l'auteur" required></textarea>
        <input type="file" name="image" required>
        <button type="submit">Ajouter l'auteur</button>
      </form>
    </div>


    
    <div>
      <ul>
        <?php
          // Afficher la liste des auteurs
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
        ?>
        <div class="cadre">
          <img src="../admincp/<?php echo $row["image"]; ?>" alt="Photo" height="300px" width="auto">
          <div class="contenu">
            <h2>Nom : <?php echo $row["nomauteur"]; ?></h2>
            <h4>Date nss : <?php echo $row["date"]; ?></h4>
            <h4>lieu d'origine : <?php echo $row["pays"]; ?></h4>
            <p><?php echo $row["biographie"]; ?></p>
          </div>
        </div>
        <?php
              }
          } else {
              echo "Aucun auteur trouvé.";
          }
        ?>
      </ul>
    </div>



  </body>
  <footer>
    <p>Tous droits réservés &copy; Booksto 2023</p>
  </footer>
</html>
