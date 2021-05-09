<?php
session_start();
require "../src/bootstrap.php";

if (isset($_POST['submit'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $db = get_pdo();

    $sql = "SELECT * FROM users WHERE pseudo = '$pseudo'";
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount() > 0) {
        $data = $result->fetchAll();
        if (password_verify($password, $data[0]['password'])) {
            $_SESSION['name'] = $pseudo;
            header('Location: /');
        }else {
            e404();
        }
    } else {
       $password = password_hash($password, PASSWORD_DEFAULT);
       $sql = "INSERT INTO users (pseudo, password) VALUES ('$pseudo', '$password')";
       $req = $db->prepare($sql);
       $req->execute();
    }
}
