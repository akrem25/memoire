<?php
  session_start(); // Start the session

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "booksto";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Fetch auteurs from the database
  $sql = "SELECT * FROM auteur";
  $result = $conn->query($sql);

  // Close the database connection
  $conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auteur</title>
    <link rel="stylesheet" href="css/auteur.css">
  </head>
  <header>
      <div class="logo">
        <img src="images-books/logo-full.png" alt="Logo Booky">
      </div>

      <ul class="nav-links">
        <li class="center"><a href="home.php">Accueil</a></li>
        <li class="center"><a href="livres.php">livres</a></li>
        <li class="center"><a href="auteur.php">Auteurs</a></li>
        
        <?php if (!isset($_SESSION['user_id'])) { ?>
        <li class="center"><a href="login.php">Se Connecter</a></li>
        <?php } else { ?>
        <li class="center"><a href="profile.php">Mon Profile</a></li>
        <li class="center"><a href="logout.php">Déconnexion</a></li>
        <?php } ?>

      </ul>
  </header>
  <body>
    <div class="auteur">
      <h1>En savoir plus sur notre auteur</h1>
    </div>
    <blockquote>
      <h5>quelqu'un d'entre eux a dit :</h3>
      “Job is an acronym for ‘Just Over Broke.’ ”
      <cite>Robert Kiyosaki</cite>
    </blockquote>
    <div class="afficher">
          <?php
              // Afficher la liste des livres
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) 
                  {
          ?>
         <div class="cadre">
          <img src="admincp/<?php echo $row["image"]; ?>" alt="Photo" height="300px" width="auto">
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
  </body>
  <footer>
    <p>Tous droits réservés &copy; Booksto 2023</p>
  </footer>
</html>