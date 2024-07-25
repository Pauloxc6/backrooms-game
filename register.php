<?php
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (registerUser($username, $password)) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Erro ao registrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/lr.css">
</head>
<body>
    <h1>Registro</h1>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Registrar</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <a href="login.php">Já tem uma conta? Faça login.</a>
</body>
</html>
