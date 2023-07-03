<?php
    // Démarrer la séance
    session_start();

    // Vérifiez si l'admin n'est pas connecté
  if (!isset($_SESSION['admin_id'])) {
    // Rediriger vers login.php si vous n'êtes pas connecté
    header("Location: login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/home.css">
  </head>
  <header>
    <div class="logo">
      <img src="../images-books/logo-full.png" alt="Logo 1">
    </div>

    <ul class="nav-links">
      <li class="center"><a href="home.php">Accueil</a></li>
      <li class="center"><a href="livres.php">Livres</a></li>
      <li class="center"><a href="auteur.php">Auteurs</a></li>
      <li class="center"><a href="logout.php">Déconnexion</a></li>
    </ul>
  </header>
  <body>
    <main>
      <h1>Mes commandes :</h1>
      <form action="" method="post">
        <div class="table-wrapper">
          <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "booksto";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // delivery status
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveDeliveryStatus'])) {
              if (isset($_POST['deliveryStatus'])) {
                  $deliveryStatuses = $_POST['deliveryStatus'];
          
                  foreach ($deliveryStatuses as $key => $status) {
                      $cartId = $key + 1; // Assuming the cart ID starts from 1
          
                      // Update the delivery status in the database
                      $sql = "UPDATE cart SET delivery = $status WHERE id = $cartId";
                  }
              }
          }
          
            // Check if delete button is clicked
            if (isset($_POST['delete'])) {
                $selectedRows = $_POST['selectedRows'];
                foreach ($selectedRows as $rowId) {
                    // Delete the selected rows based on their IDs
                    $deleteSql = "DELETE FROM cart WHERE id = $rowId";
                    $conn->query($deleteSql);
                }
            }
              // selectionne de la table de commende "cart"
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse email</th>
            <th>Numéro de téléphone</th>
            <th>Adresse de livraison</th>
            <th>Titre du livre</th>
            <th>Prix</th>
            <th>Statut de livraison</th>
            <th>Select pour supprimer</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["id"] . '</td>';
        echo '<td>' . $row["nom"] . '</td>';
        echo '<td>' . $row["prenom"] . '</td>';
        echo '<td>' . $row["email"] . '</td>';
        echo '<td>' . $row["numtel"] . '</td>';
        echo '<td>' . $row["adresse"] . '</td>';
        echo '<td>' . $row["titre_livre"] . '</td>';
        echo '<td>' . $row["prix_livre"] . '</td>';

        // Assuming you have a column named "delivery" in your cart table
        $deliveryStatus = $row["delivery"];
        $deliveryValue = ($deliveryStatus == "delivered") ? 1 : 0; // Convert the status to boolean value

        echo '<td>';
        echo '<select name="deliveryStatus[]" style="width: 120px; padding: 5px; border-radius: 5px;">';
        echo '<option value=""' . ($deliveryStatus == "" ? ' selected' : '') . '>&nbsp;</option>';
        echo '<option value="1"' . ($deliveryStatus == "delivered" ? ' selected' : '') . '>Delivered</option>';
        echo '<option value="0"' . ($deliveryStatus == "not_delivered" ? ' selected' : '') . '>Not Delivered</option>';
        echo '</select>';
        echo '</td>';

        // Checkbox pour sélectionner les lignes à supprimer
        echo '<td>';
        echo '<input type="checkbox" name="selectedRows[]" value="' . $row["id"] . '">';
        echo '</td>';

        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No orders found.";
}
              // Update the database with the selected delivery status
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              if (isset($_POST['deliveryStatus'])) {
                  $deliveryStatuses = $_POST['deliveryStatus'];

                  foreach ($deliveryStatuses as $key => $status) {
                      $cartId = $key + 1; // Assuming the cart ID starts from 1

                      // Update the delivery status in the database
                      $sql = "UPDATE cart SET delivery = $status WHERE id = $cartId";
                  }
              }
            }

            $conn->close();
          ?>
        </div>
        <div class="button-container">
          <button type="submit" name="reset" class="reset-button">Reset</button>
          <button type="submit" name="delete" class="delete-button">Delete Selected</button>
        </div>
      </form>
    </main>

  </body>
  <footer>
    <p>Tous droits réservés &copy; Booksto 2023</p>
  </footer>
</html>
