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

// Retrieve user data from the database
$userID = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $userID";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $user = $result->fetch_assoc();
  $fullName = $user['fullname'];
  $email = $user['email'];
} else {
  // Handle error if user data is not found
  echo "User data not found.";
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" href="css/profile.css">
  </head>
  <body>
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
  <li class="center"><a href="wishlist.php">Auteur</a></li>
  <div class="profile-container">
    <h1>Mon Profile</h1>
    <div class="profile-info">
      <p><strong>Nom :</strong> <?php echo $fullName; ?></p>
      <p><strong>Email :</strong> <?php echo $email; ?></p>
    </div>
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