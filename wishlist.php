<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booksto";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id'])) {
        $productID = $_POST['product_id'];
        $userID = $_SESSION['user_id'];

        // Insert the liked product into the 'panier' table
        $sql = "INSERT INTO panier (user_id, product_id) VALUES ($userID, $productID)";
        $conn->query($sql);
    }
}

// Retrieve the liked products for the logged-in user from the 'panier' table
$userID = $_SESSION['user_id'];
$sql = "SELECT l.* FROM livre l INNER JOIN panier p ON l.id = p.product_id WHERE p.user_id = $userID";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="css/wishlist.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images-books/logo-full.png" alt="Logo Booky">
        </div>
        <ul class="nav-links">
            <li class="center"><a href="home.php">Accueil</a></li>
            <li class="center"><a href="livres.php">Livres</a></li>
            <li class="center"><a href="auteur.php">Auteurs</a></li>
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <li class="center"><a href="login.php">Se Connecter</a></li>
            <?php } else { ?>
                <li class="center"><a href="profile.php">Mon Profil</a></li>
                <li class="center"><a href="logout.php">Déconnexion</a></li>
            <?php } ?>
        </ul>
    </header>

    <div class="wishlist-container">
        <h1>My Wishlist</h1>
        <div class="product-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<img src="admincp/' . $row["image"] . '" alt="Product Image">';
                    echo '<h2>' . $row["titre"] . '</h2>';
                    echo '<h4>Date : ' . $row["date"] . '</h4>';
                    echo '<h4>Nom d\'auteur(s) : ' . $row["nomauteur"] . '</h4>';
                    echo '<h4>Catégorie : ' . $row["catlivre"] . '</h4>';
                    echo '<p>' . $row["description"] . '</p>';
                    echo '<h3>' . $row["prix"] . '</h3>';
                    echo '</div>';
                }
            } else {
                echo "No products found in your wishlist.";
            }
            ?>
        </div>
    </div>
</body>
</html>
