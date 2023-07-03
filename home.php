<?php
    // Démarre la session
  session_start(); 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "booksto";

    // Établir la connexion à la base de données
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

    // Récupérer les trois derniers livres de la table "livre"
  $query = "SELECT * FROM livre ORDER BY prix LIMIT 3";
  $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bookstore</title>
    <link rel="stylesheet" href="css/home.css">
  </head>
  <header>
    <div class="logo">
      <img src="images-books/logo-full.png" alt="Logo 1">
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
    <main>
      <section class="banner">
        <img src="images-books/logo-two.png" alt="Logo 2">
        <h2>Bienvenu dans notre librairie en ligne</h2>
        <p>Découvrez notre vaste sélection de livres dans tous les genres.</p>
        <a href="livres.php" class="btn">Explorer</a><br><br>
        <a href="wishlist.php" class="btn">panier</a><br><br>

        <div class="quote">
          <h3>Quote of the Day</h3>
          <blockquote>
              “A room without books is like a body without a soul.”
            <cite>― Marcus Tullius Cicero</cite>
          </blockquote>
        </div>
        <div class="la-une">
          <h1>Voici notre livres les plus vendu</h1>
        </div>
        <div class="livre">
              <?php
                // Display the retrieved books
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                ?>
                <div class="cadre">
                  <img src="admincp/<?php echo $row["image"]; ?>" alt="Photo" height="300px" width="auto">
                  <div class="contenu">
                      <h2><?php echo $row["titre"]; ?></h2>
                      <p><?php echo $row["catlivre"]; ?></p>
                  </div>
                  <div class="acheter">
                      <h3><?php echo $row["prix"]; ?></h3>
                      <a href="cart.php?id=<?php echo $row["id"]; ?>">Commander</a>
                  </div>
                </div>
                <?php
                    }
                }
              ?>
          </div>
        
      </section><br><br>
      <section class="about-us">
        <div class="container">
          <h2>About Us</h2>
          <p>Bienvenue sur notre librairie en ligne ! Nous sommes deux amis passionné de littérature et nous vous proposons une large sélection de livres, des classiques aux nouveautés, pour une expérience de lecture enrichissante. Rejoignez notre univers littéraire et trouvez votre prochaine aventure parmi notre collection soigneusement choisie.</p>
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
