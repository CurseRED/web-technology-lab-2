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
	<p>
		<?php
			// Проверка запроса
			$date1 = '';
			$num = '';
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				$date1 = $_GET["date"];
				$num = $_GET["number"];
			}
			$datetime1 = date_create(date('d-m-Y'));
			$datetime2 = date_create($date1);
			if (date('Y-m-d') < $date1) {
				header('Location: ./lab3.php?error=1&value='.$num);
				exit;
			}
			if ($num < 0) {
				header('Location: ./lab3.php?error=2&value='.$date1);
				exit;
			}
			$interval = date_diff($datetime2, $datetime1);
			echo $interval->format('Возраст: %d дня(ей) %m месяц(ев) %y лет(год)<br>');
			date_add($datetime2, date_interval_create_from_date_string($num.' days'));
			echo $datetime2->format('d-m-y вам будет '.$num.' дня(ей)');
			$arr = ['Обезьяны', 'Петуха', 'Собаки',
					'Свиньи', 'Крысы', 'Быка',
					'Тигра', 'Кролика', 'Дракона',
					'Змеи', 'Лошади', 'Козы'];
			echo '<br>Вы родились в год '.$arr[(date_create($date1)->format('Y'))%12]
		?>
	</p>
	<a href="./lab3.php">Вернуться к форме</a>	
</body>
</html>