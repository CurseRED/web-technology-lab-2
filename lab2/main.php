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
	<?php
		function test_input($data) {
			$data = trim($data);
			$data = stripcslashes($data);
			$data = strip_tags($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		// Проверка запроса
		$text = '';
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$text = test_input($_POST["comment"]);
		}
		if ($text == '') {
			echo '<p style="text-align:center">Введите текст.</p>';
		} else {
			$arr = explode(' ', $text);
			$count = 0;
			// Выполнение преобразований над каждым словом
			for ($i = 0; $i < count($arr); $i++) {
				if ($i%3 == 2) {
					$arr[$i] = mb_strtoupper($arr[$i]);
				}
				// Подсчет количества букв "о" и "О"
				for ($j = 0; $j < mb_strlen($arr[$i]); $j++) {
					if ($arr[$i][$j] == 'o' || $arr[$i][$j] == 'O' || mb_substr($arr[$i], $j, 1) == 'о' || mb_substr($arr[$i], $j, 1) == 'О') {
						$count++;
					}
				}
				// Оборачивание каждой третьей буквы в span
				$temp = '';
				for ($j = 0; $j < mb_strlen($arr[$i]); $j++) {
					if ($j%3 == 2) {
						$temp = $temp.'<span style="color:purple;">'.mb_substr($arr[$i], $j, 1).'</span>';
					} else {
						$temp = $temp.mb_substr($arr[$i], $j, 1);
					}
				}
				$arr[$i] = $temp;
			}

			echo '<p style="text-align:center">Результат преобразования:</p><p class="output" style="text-align:center">'.implode(' ', $arr).'</p>';
			echo '<p style="text-align:center">Количество букв "о" и "О": '.$count.'</p>';
		}
	?>
	<a href="./lab2.html">Вернуться к форме</a>	
</body>
</html>