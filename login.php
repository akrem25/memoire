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

if (isset($_SESSION['user_id'])) {
    // Redirect to home.php if already logged in
    header("Location: home.php");
    exit;
}

// Signup Logic
if (isset($_POST['signup'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform any necessary validation and sanitization on the input values

    // Check if the email already exists in the database
    $emailExists = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($emailExists->num_rows > 0) {
        $signup_error = "Email already exists.";
    } else {
        // Insert the new user record into the database
        $insertSql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        if ($conn->query($insertSql) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id; // Store user ID in session
            header("Location: home.php");
            exit;
        } else {
            $signup_error = "Error: " . $conn->error;
        }
    }
}

// Login 
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: home.php");
        exit;
    } else {
        $login_error = "Invalid email or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription</title>
    <link rel="stylesheet" href="css/login.css" />
    <script src="login.js"></script>
</head>
<body>
<section class="wrapper">
      <div class="form signup">
        <header>Inscription</header>
        <form action="" method="POST">
          <input type="text" name="fullname" placeholder="Nom et prénom" required />
          <input type="text" name="email" placeholder="Adresse E-mail" required />
          <input type="password" name="password" placeholder="Mot de passe" required />
          <div class="checkbox">
            <input type="checkbox" id="signupCheck" />
            <label for="signupCheck">J'accepte tous les termes et conditions</label>
          </div>
          <input type="submit" name="signup" value="signup" />
        </form>
      </div>

      <div class="form login">
        <header>Connexion</header>
        <form action="" method="POST">
          <input type="text" name="email" placeholder="Adresse E-mail" required />
          <input type="password" name="password" placeholder="Mot de passe" required />
          <a href="admincp/login.php">Se connecter en tant que Admin</a>
          <input type="submit" name="login" value="Login" />
        </form>
      </div>

      <script>
        const wrapper = document.querySelector(".wrapper"),
          signupHeader = document.querySelector(".signup header"),
          loginHeader = document.querySelector(".login header");

        loginHeader.addEventListener("click", () => {
          wrapper.classList.add("active");
        });
        signupHeader.addEventListener("click", () => {
          wrapper.classList.remove("active");
        });
      </script>
    </section>
</body>
</html>
