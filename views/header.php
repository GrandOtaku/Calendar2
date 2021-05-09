<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/calendar.css">
    <title><?= isset($title) ? h($title) : '私のカレンダー' ;?> </title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark mb-3">
        <a href="/" class="navbar-brand">私のカレンダー</a>
        <a href="/logout.php" class="navbar-brand">ログアウト</a>
        <a href="API.html" target="_blank" class="navbar-brand">ビデオ検索</a>
    </nav>