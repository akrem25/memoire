<?php
    session_start(); // Start the session

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booksto";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $titre_livre = $_POST['titre_livre'];
        $prix_livre = $_POST['prix_livre'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $numtel = $_POST['numtel'];
        $adresse = $_POST['adresse'];

        // Insert the form data into the cart table
        $insertQuery = "INSERT INTO cart (nom, prenom, email, numtel, adresse, titre_livre, prix_livre) VALUES ('$nom', '$prenom', '$email', '$numtel', '$adresse', '$titre_livre', '$prix_livre')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Book added to cart successfully.";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
    ?>
