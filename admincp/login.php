<?php
        // Démarrer la séance
    session_start(); 

        // Check if the admin is already logged in
    if (isset($_SESSION['admin_id'])) {
        // Redirect to home.php if already logged in
        header("Location: home.php");
        exit;
    }

    $login_error = "";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booksto";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        // Login 
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['admin_id'] = $user['id']; // Store admin ID in session
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
        <title>Connexion Admin</title>
        <link rel="stylesheet" href="css/login.css" />
    </head>
    <body>
        <div class="form_login">
            <header>Connexion Admin</header>
            <form action="" method="POST">
                <input type="text" name="email" placeholder="Adresse E-mail" required />
                <input type="password" name="password" placeholder="Mot de passe" required />
                <a href="../login.php">Se connecter en tant que client</a>
                <input type="submit" name="login" value="Connecter" />
                <?php if (!empty($login_error)) {?>
                <p><?php echo $login_error; ?></p>
                <?php } ?>
            </form>

        </div>
    </body>
</html>
