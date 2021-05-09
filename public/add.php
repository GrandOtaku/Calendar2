<?php
session_start();
require '../src/bootstrap.php';

$data = [
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'start' => date('H:i'),
    'end' => date('H:i')
];
$validator = new \App\Validator($data);
if (!$validator->validate('date', 'date')) {
    $data['date'] = date('Y-m-d');
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($_POST);
    if (empty($errors)) {
        $events = new \Calendar\Events(get_pdo());
        $event = $events->hydrate(new \Calendar\Event(), $data);
        $events->create($event);
        header('Location: /');
        exit();
    }
}

render('header', ['title' => 'イベントを追加']);

?>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">間違いを訂正してください</div>
<?php endif; ?>

<div class="container">
    <h1>イベントを追加</h1><br>
    <form action="" method="post" class="form">
        <?php render('calendar/form', ['data' => $data, 'errors' => $erros]); ?>
        <br>
        <div class="form-group">
            <button class="btn btn-dark">
            イベントを追加
            
            </button>
        </div>
    </form>
</div>

<?php render('footer'); ?>