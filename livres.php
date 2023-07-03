<?php
    // Démarrer la session
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booksto";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer des livres de la base de données
    $sql = "SELECT * FROM livre";
    $result = $conn->query($sql);

    // Handle the like action
    if (isset($_POST['product_id'])) {
        // Get the product ID from the form
        $product_id = $_POST['product_id'];

        // You would typically have user authentication and obtain the user ID here
        // For the sake of simplicity, let's assume the user ID is hardcoded
        $user_id = 1;

        // Check if the user has already liked the product
        $query = "SELECT * FROM likes WHERE user_id = $user_id AND product_id = $product_id";
        $like_result = mysqli_query($conn, $query);

        if (mysqli_num_rows($like_result) > 0) {
            // The user has already liked the product, you can either remove the like or show an error message
            // Code for removing the like or displaying an error message goes here
        } else {
            // Insert a new like record
            $insert_query = "INSERT INTO likes (user_id, product_id) VALUES ($user_id, $product_id)";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                // Update the product's like count
                $update_query = "UPDATE livre SET likes = likes + 1 WHERE id = $product_id";
                mysqli_query($conn, $update_query);
            } else {
                // Handle the case where the like couldn't be inserted
                // Code for handling the failure to insert the like goes here
            }
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>livres</title>
      <link rel="stylesheet" href="css/livres.css">
  </head>
  <header>
      <div class="logo">
          <img src="images-books/logo-full.png" alt="Logo Booky">
      </div>

      <ul class="nav-links">
        <li class="center"><a href="home.php">Accueil</a></li>
        <li class="center"><a href="livres.php">livres</a></li>
        <li class="center"><a href="auteur.php">Auteur</a></li>

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <li class="center"><a href="login.php">Se Connecter</a></li>
        <?php } else { ?>
            <li class="center"><a href="profile.php">Mon Profile</a></li>
            <li class="center"><a href="logout.php">Déconnexion</a></li>
        <?php } ?>

      </ul>
  </header>
  <body>
    <br><br><main>
      <div class="banner">
        <h2>Bienvenu dans notre librairie en ligne</h2>
        <p>Découvrez notre vaste sélection de livres dans tous les genres.</p>
      </div>
      <div class="afficher">
        <?php
          // Afficher la liste des livres
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
            {
        ?>

          <div class="cadre" >
            <img src="admincp/<?php echo $row["image"]; ?>" alt="Photo" height="300px" width="auto">
            <div class="text">
              <div class="contenu">
                <h2>Titre : <?php echo $row["titre"]; ?></h2>
                <h4>date : <?php echo $row["date"]; ?></h4>
                <h4>Nom d'auteur(s) : <?php echo $row["nomauteur"]; ?></h4>
                <h4>Catégorie : <?php echo $row["catlivre"]; ?></h4>
                <p><?php  echo $row["description"]; ?></p>
                <h4>langue disponible : <?php echo $row["langue"]; ?></h4>
              </div>
              <div class="acheter">
                <h3><?php echo $row["prix"]; ?></h3>
                <a href="cart.php?id=<?php echo $row["id"]; ?>">Commander</a>
              </div>

              <form method="POST" action="wishlist.php">
                    <input type="hidden" name="product_id" value="<?php echo $row["id"]; ?>">
                    <button type="submit">Like</button>
                </form>


            </div>
          </div>
                  
        <?php
          }
          } else {
              echo "Aucun livre trouvé.";
          }
        ?>
      </div>
      <section class="about-us">
        <div class="container">
          <h2>About Us</h2>
          <p>Bienvenue sur notre site de vente de livres en ligne ! Nous sommes deux amis passionné de littérature et nous vous proposons une large sélection de livres, des classiques aux nouveautés, pour une expérience de lecture enrichissante. Rejoignez notre univers littéraire et trouvez votre prochaine aventure parmi notre collection soigneusement choisie.</p>
        </div>
        <div class="contact-us">
          <div class="person">
            <img src="images-books/image/admin1.jpg" alt="Admin 1">
            <h3>Sid Akrem</h3>
            <p>CEO</p>
            <h5>Email: Akrem@gmail.com</h5>
            <h5>Phone: +213 796 795 666</h5>
          </div>
          <div class="person">
            <img src="images-books/image/admin2.jpg" alt="Admin 2">
            <h3>Idoughi A.Hamid</h3>
            <p>Marketing Manager</p>
            <h5>Email: hamid@gmail.com</h5>
            <h5>Phone: +213 663 230 706</h5>
          </div>
        </div>
      </section>
    </main>
  </body>
  <footer>
      <p>Tous droits réservés &copy; Booksto 2023</p>
  </footer>
</html>
