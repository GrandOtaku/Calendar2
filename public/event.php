<?php
session_start();
require '../src/bootstrap.php';
$pdo = get_pdo();
$events = new Calendar\Events($pdo);
if (!isset($_GET['id'])) {
    header('location: /404.php');
}
try {
    $event = $events->find($_GET['id']);
} catch (\Exception $e) {
    e404();
}

render('header', ['title' => $event->getName()]);
?>

<h1><?= h($event->getName()); ?></h1>
<ul>
    <li>日取り : <?= $event->getStart()->format('d/m/Y'); ?> </li>
    <li>開始 : <?= $event->getStart()->format('H:i'); ?> </li>
    <li>終わり : <?= $event->getEnd()->format('H:i'); ?> </li>
    <li>説明 : <br>
        <?= h($event->getDescription()); ?> </li>
</ul>
<?php require '../views/footer.php'; ?>