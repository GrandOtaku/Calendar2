<?php
session_start();
require '../src/bootstrap.php';

use Calendar\{
    Events,
    Month
};

if ($_SESSION['name'] === 'Enzo') {

    $pdo = get_pdo();
    $events = new Events($pdo);
    $month = new Month($_GET['month'], $_GET['year']);
    $start = $month->getFirstDay();
    $start = $start->format('N') === '1' ? $start : $month->getFirstDay()->modify('last monday');
    $weeks = $month->getWeeks();
    $end = (clone $start)->modify('+' . (6 + 7 * $weeks - 1) . ' days');
    $events = $events->getEventsBetweenByDay($start, $end);
    require '../views/header.php';
?>

    <div class="calendar">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <h1><?= $month->toString(); ?></h1>
            <div class="hour">
                <h1>
                    <div id="horloge"> </div>
                </h1>
                <script type="text/javascript">
                    function horloge() {
                        var div = document.getElementById("horloge");
                        var heure = new Date();
                        var hours = (heure.getHours() < 10) ? "0" + heure.getHours() : heure.getHours();
                        var minutes = (heure.getMinutes() < 10) ? "0" + heure.getMinutes() : heure.getMinutes();
                        var seconds = (heure.getSeconds() < 10) ? "0" + heure.getSeconds() : heure.getSeconds();
                        div.firstChild.nodeValue = hours + ":" + minutes + ":" + seconds;
                        window.setTimeout("horloge()", 1000);
                    }
                    horloge();
                </script>

            </div>
            <div>
                <a href="/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-dark">&lt;</a>
                <a href="/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-dark">&gt;</a>
            </div>
        </div>

        <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
            <?php for ($i = 0; $i < $weeks; $i++) : ?>
                <tr>
                    <?php foreach ($month->days as $k => $day) :
                        $date = (clone $start)->modify("+" . ($k + $i * 7) . "days");
                        $eventsForDays = $events[$date->format('Y-m-d')] ?? [];
                        $isToday = date('Y-m-d') === $date->format('Y-m-d');
                    ?>
                        <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?>">
                            <?php if ($i === 0) : ?>
                                <div class="calendar__weekday"><?= $day; ?></div>
                            <?php endif; ?>
                            <a class="calendar__day" href="add.php?date=<?= $date->format('Y-m-d'); ?>"><?= $date->format('d'); ?></a>
                            <?php foreach ($eventsForDays as $event) : ?>
                                <div class="calendar__event">
                                    <?= (new DateTime($event['start']))->format('H:i') ?> - <a href="/edit.php?id=<?= $event['id']; ?>"><?= h($event['name']); ?></a>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </table>
        <a href="/add.php" class="calendar__button">+</a>
    </div>
<?php
    require '../views/footer.php';
} else {
    require '../views/header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <form class="box" action="login.php" method="POST">
                        <h1>ログイン</h1>
                        <p class="text-muted">ログイン名とパスワードを入力してください。</p>
                        <input type="text" name="pseudo" placeholder="ユーザー名" required>
                        <input type="password" name="password" placeholder="パスワード" required>
                        <input type="submit" name="submit" value="ログイン">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>