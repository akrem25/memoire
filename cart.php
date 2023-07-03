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

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Retrieve product information from the database using the product ID
    $sql = "SELECT * FROM livre WHERE id = $productID";
    $result = $conn->query($sql);

} else {
    echo "Invalid product ID.";
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $adresse = $_POST["adresse"];

    // Retrieve product information from the database using the product ID
    $sql = "SELECT * FROM livre WHERE id = $productID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $titreLivre = $row["titre"];
            $prixLivre = $row["prix"];
        }
    }

    // Insert the form data into the cart table
    $insertSql = "INSERT INTO cart (nom, prenom, email, numtel, adresse, titre_livre, prix_livre) 
                  VALUES ('$nom', '$prenom', '$email', '$telephone', '$adresse', '$titreLivre', '$prixLivre')";
                  
    if ($conn->query($insertSql) === true) {
        echo "merci votre Commande est prise en charge avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de la commande: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Commande</title>
        <link rel="stylesheet" href="css/cart.css">
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

  <div class="container">

    <div class="left"><ul>
        <?php
             // Afficher la liste des livres
            if ($result->num_rows > 0) {
                 while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="cadre" >
                        <img src="admincp/<?php echo $row["image"]; ?>" alt="Photo" height="300px" width="auto">
                        <div class="text">
                            <div class="contenu">
                                <h2>Titre : <?php echo $row["titre"]; ?></h2>
                                <h4>date : <?php echo $row["date"]; ?></h4>
                                <h4>Nom d'auteur(s) : <?php echo $row["nomauteur"]; ?></h4>
                                <h4>Catégorie : <?php echo $row["catlivre"]; ?></h4>
                                <p><?php  echo $row["description"]; ?></p><br>
                                <h4>langue disponible(s) : <?php echo $row["langue"]; ?></h4>
                            </div>
                        </div>
                    </div>
                <?php
            }
            } else {
                echo "No product found.";
            }

        ?>
    </ul></div>
  <div class="right">
    <h2>Formulaire pour la livraison</h2>
    <h4>veuillez entrer vos informations de livraison correct</h4>
    <form action="" method="POST">
      <div class="nomprenom">
      <input type="text" name="nom" placeholder="Nom de destinataire" required>
      <input type="text" name="prenom" placeholder="Prénom de destinataire" required>
      </div>
      <div class="nomprenom">
      <input type="email" name="email" placeholder="Adresse e-mail de destinataire" required>
      <input type="tel" name="telephone" placeholder="Numéro de téléphone de destinataire" required>
      </div>
      <input type="text" name="adresse" placeholder="Adresse de livraison" required>
      <button type="submit">Commander</button>
    </form>
    </div>
  </div>
</body>
</html>
