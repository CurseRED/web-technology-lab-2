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
			$date1 = '';
			$num = '';
			// Проверка запроса и получение аргументов
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				$date1 = $_GET["date"];
				$num = $_GET["number"];
			}
			$datetime1 = date_create(date('d-m-Y'));
			$datetime2 = date_create($date1);
			// Проверка ввода
			if (date('Y-m-d') < $date1) {
				header('Location: ./lab3.php?error=1&value='.$num);
				exit;
			}
			if ($num < 0) {
				header('Location: ./lab3.php?error=2&value='.$date1);
				exit;
			}
			$fp = fopen('log.txt', 'a');
			fwrite($fp, 'Введенные данные: '.$date1.' '.$num.PHP_EOL);
			// Находим разницу дат
			$interval = date_diff($datetime2, $datetime1);
			$string = $interval->format('Возраст: %d дня(ей) %m месяц(ев) %y лет(год)');
			fwrite($fp, 'Вывод: '.$string.' ');
			echo $string.'<br>';
			// Добавляем к дате рождения N дней
			date_add($datetime2, date_interval_create_from_date_string($num.' days'));
			$string = $datetime2->format('d-m-y вам будет '.$num.' дня(ей)');
			fwrite($fp, $string.' ');
			echo $string.' ';
			$arr = ['Обезьяны', 'Петуха', 'Собаки',
					'Свиньи', 'Крысы', 'Быка',
					'Тигра', 'Кролика', 'Дракона',
					'Змеи', 'Лошади', 'Козы'];
			// Определяем год человека
			$string = 'Вы родились в год '.$arr[(date_create($date1)->format('Y'))%12];
			fwrite($fp, $string.PHP_EOL);
			echo '<br>'.$string;
			fclose($fp);
		?>
	</p>
	<a href="./lab3.php">Вернуться к форме</a>	
</body>
</html>