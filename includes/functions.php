<?php

function registerUser($username, $password) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $hashed_password]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserData($user_id) {
    global $pdo;
    if (!$pdo){
	throw new Exception("Conexão ao banco de dados não estabelecida.");
    }
    $stmt = $pdo->prepare("SELECT * FROM data WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function saveExplorerData($user_id, $level, $info) {
    global $pdo;
    if (!$pdo) {
        throw new Exception("Conexão ao banco de dados não estabelecida.");
    }
    $stmt = $pdo->prepare("INSERT INTO data (user_id, level, info) VALUES (?, ?, ?)");
    return $stmt->execute([$user_id, $level, $info]);
}

