<!DOCTYPE html>
<html lang="Russian">
<head>
    <title>PHP Laboratory</title>
    <meta charset="utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <meta name="author" content="maksim">
    <meta name="description" content="Page with PHP algorithms">
    <meta name="keywords" content="php, algorithm, test, input">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<p><b>Вариант 4:</b> написать скрипт, собирающий статистику по времени посещения сайта. Выводить результаты в виде графиков активности посетителей за день, неделю, месяц, год. График представить в виде HTML.</p>
<?php
    include "stat.php";
    $type = "день";
    $count = 24;
    $max = 0;
    $a = array();
    // Выбираем все за нужное количество часов, дней или недель в цикле
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["day"])) {
        $type = "последние 24 часа";
        $x = "часов";
        $count = 24;
        for ($i = $count; $i > 0; $i--) {
            $j = $i - 1;
            $query = "SELECT * FROM visits WHERE visit_time < NOW() - INTERVAL $j HOUR AND visit_time >= NOW() - INTERVAL $i HOUR";
            $res = $connection->query($query);
            $n = $res->num_rows;
            if ($max < $n)
                $max = $n;
            array_push($a, $n);
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["week"])) {
        $type = "последнюю неделю";
        $count = 7;
        $x = "дней";
        for ($i = $count; $i > 0; $i--) {
            $j = $i - 1;
            $query = "SELECT * FROM visits WHERE visit_time < NOW() - INTERVAL $j DAY AND visit_time >= NOW() - INTERVAL $i DAY";
            $res = $connection->query($query);
            $n = $res->num_rows;
            if ($max < $n)
                $max = $n;
            array_push($a, $n);
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["month"])) {
        $type = "последний месяц";
        $count = 30;
        $x = "дней";
        for ($i = $count; $i > 0; $i--) {
            $j = $i - 1;
            $query = "SELECT * FROM visits WHERE visit_time < NOW() - INTERVAL $j DAY AND visit_time >= NOW() - INTERVAL $i DAY";
            $res = $connection->query($query);
            $n = $res->num_rows;
            if ($max < $n)
                $max = $n;
            array_push($a, $n);
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["year"])) {
        $type = "последний год";
        $count = 12;
        $x = "месяцев";
        for ($i = $count; $i > 0; $i--) {
            $j = $i - 1;
            $query = "SELECT * FROM visits WHERE visit_time < NOW() - INTERVAL $j MONTH AND visit_time >= NOW() - INTERVAL $i MONTH";
            $res = $connection->query($query);
            $n = $res->num_rows;
            if ($max < $n)
                $max = $n;
            array_push($a, $n);
        }
    }
?>
<div class="graph-container">
    <?php
        echo "<p>Количество посетителей за $type ($x назад)</p>";
    ?>
    <div class="graph">
        <?php
            for ($i = 0; $i < $count; $i++) {
                $n = $a[$i];
                $h = round(($n/$max)*100);
                if ($h < 15)
                    $h = 15;
                $r = $count - $i;
                echo "<div class='item-container'>$r";
                echo "<div class='item' style='height: $h%'>$n</div>";
                echo "</div>";
            }
        ?>
    </div>
</div>
<form action="./main.php" method="get" accept-charset="utf-8" class="stat-control">
    <label>Статистика за: </label>
    <button type="submit" name="day">День</button>
    <button type="submit" name="week">Неделя</button>
    <button type="submit" name="month">Месяц</button>
    <button type="submit" name="year">Год</button>
</form>
<a href="../index.html">На главную</a>
</body>
<footer>
    <script> </script>
</footer>
</html>