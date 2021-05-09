<?php
session_start();
require '../src/bootstrap.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$errors = [];
if (!isset($_GET['id'])) {
    e404();
}
try {
    $event = $events->find($_GET['id']);
} catch (\Exception $e) {
    e404();
} catch (\Error $e) {
    e404();
}

$data = [
    'id'            => $event->getId(),
    'name'          => $event->getName(),
    'date'          => $event->getStart()->format('Y-m-d'),
    'start'         => $event->getStart()->format('H:i'),
    'end'           => $event->getEnd()->format('H:i'),
    'description'   => $event->getDescription()
];
render('header', ['title' => $event->getName()]);

?>

<div class="container">
    <h1>イベントの編集 : <small><?= h($event->getName()); ?></small></h1><br>
    <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
    <br>
    <form action="" method="post" class="form">
        <div class="form-group">
            <button class="btn btn-dark">
                イベントを削除する
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $events = new \Calendar\Events(get_pdo());
                    $events->delete($event);
                    header('Location: /');
                    exit();
                }
                ?>
            </button>
        </div>
    </form>
</div>

<?php render('footer'); ?>