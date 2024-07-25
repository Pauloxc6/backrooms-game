<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = loginUser($username, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: games.php");
        exit;
    } else {
        $error = "Credenciais inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/lr.css">
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Entrar</button><br>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <a id="register" href="register.php">Não tem uma conta? Registre-se.</a>
</body>
</html>
