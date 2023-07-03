<?php
    // Démarrer la séance
  session_start();

      // Vérifiez si l'admin n'est pas connecté
    if (!isset($_SESSION['admin_id'])) {
      // Rediriger vers login.php si vous n'êtes pas connecté
      header("Location: login.php");
      exit;
    }

  //connexion à la base de donnée
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
      $titre = $_POST['titre'];
      $nomauteur = $_POST['nomauteur'];
      $date = $_POST['date'];
      $catlivre = $_POST['catlivre'];
      $description = $_POST['description'];
      $langue = $_POST['langue'];
      $prix = $_POST['prix'];

      // Récupérer le fichier image uploadé
      $image = $_FILES['image']['name']; 
      $image_tmp = $_FILES['image']['tmp_name']; // Emplacement temporaire du fichier

      // Déplacer l'image vers un dossier de stockage
      $image_path = "images-books/" . $image;
      move_uploaded_file($image_tmp, $image_path);

      // Préparer la requête SQL d'insertion
      $sql = "INSERT INTO livre (titre, nomauteur, date, catlivre, description, langue, prix, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

      //ça pour éviter les problèmes de sécurité
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssss", $titre, $nomauteur, $date, $catlivre, $description, $langue, $prix, $image_path);

      // Exécuter la requête avec les données fournies
      $stmt->execute();

      // Rediriger l'utilisateur vers une page de confirmation ou afficher un message de succès
      header("Location: livres.php");
      exit();
  }


  // Récupérer la liste des livres depuis la base de données
  $sql = "SELECT * FROM livre";
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
    <link rel="stylesheet" href="css/livres.css">
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
      <form method="post" action="livres.php" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre du livre" required>
        <input type="text" name="date" placeholder="date de livre" required>
        <input type="text" name="nomauteur" placeholder="Nom D'Auteur(s)" required>
        <input type="text" name="catlivre" placeholder="Catégorie Du livre" required>
        <textarea name="description" placeholder="Description du livre" required></textarea>
        <input type="text" name="langue" placeholder="Langue disponible (s)" required>
        <input type="text" name="prix" placeholder="Prix du livre" required>
        <input type="file" name="image" required>
        <button type="submit">Ajouter le livre</button>
      </form>
    </div>


    <div class="afficher">
      <?php
        // Afficher la liste des livres
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc())
          {
      ?>

      <div class="cadre" >
        <img src="../admincp/<?php echo $row["image"]; ?>" alt="Photo" height="300px" width="auto">
        <div class="text">
        <div class="contenu">
            <h2>Titre : <?php echo $row["titre"]; ?></h2>
            <h4>date : <?php echo $row["date"]; ?></h4>
            <h4>Nom d'auteur(s) : <?php echo $row["nomauteur"]; ?></h4>
            <h4>Catégorie : <?php echo $row["catlivre"]; ?></h4>
            <p><?php  echo $row["description"]; ?></p>
            <h4>langue disponible : <?php echo $row["langue"]; ?></h4>

          </div>
        </div>
      </div>
                
      <?php
        }
        } else {
            echo "Aucun livre trouvé.";
        }
      ?>
    </div>

  </body>
  <footer>
    <p>Tous droits réservés &copy; Booksto 2023</p>
  </footer>
</html>
