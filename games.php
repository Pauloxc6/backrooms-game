<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Backrooms Game</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/games.css">
</head>
<body>
    <h1>Bem-vindo ao Backrooms Game</h1>
    <a href="logout.php" id="logout">Logout</a>
    <div class="cotainer">
        <div class="dados">
            <h2>Dados Coletados</h2>
            <ul>
                <?php foreach ($user_data as $data) {
                    echo "<li>Level {$data['level']}: {$data['info']}</li>";
                } ?>
            </ul>
        </div>
        <div class="navegar">
            <h2>Navegar</h2>
            <a href="rooms/room0/">Ir para o Level 0</a>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_data = getUserData($user_id);
?>
