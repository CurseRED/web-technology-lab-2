<!DOCTYPE html>
<html lang="Russian">
<head>
	<title>PHP Laboratory</title>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width=device-width, initial-scale=1">
	<meta name="author" content="maksim">
	<meta name="description" content="Page with PHP algorithms">
	<meta name="keywords" content="php, algorithm, test, input">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<p><b>Результат преобразования:</b>
		<?php
			$text = '*Строка пуста*';
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$text = test_input($_POST["comment"]);
			}

			$arr = explode(' ', $text);
			$count = 0;
			// Выполнение преобразований над каждым словом
			for ($i = 0; $i < count($arr); $i++) {
				if ($i%3 == 2) {
					$arr[$i] = mb_strtoupper($arr[$i]);
				}
				// Подсчет количества букв "о" и "О"
				for ($j = 0; $j < strlen($arr[$i]); $j++) {
					if ($arr[$i][$j] == 'o' || $arr[$i][$j] == 'O') {
						$count++;
					}
				}
				$temp = '';
				for ($j = 0; $j < strlen($arr[$i]); $j++) {
					if ($j%3 == 2) {
						$temp = $temp.'<span style="color:purple;">'.$arr[$i][$j].'</span>';
					} else {
						$temp = $temp.$arr[$i][$j];
					}
				}
				$arr[$i] = $temp;
			}

			echo '<p class="output">'.implode(' ', $arr).'</p>';
			echo '<p>Количество букв "о" и "О": '.$count.'</p>';
			function test_input($data) {
				$data = trim($data);
				$data = stripcslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
		?>
	</p>
	<a href="/index.html">Вернуться к форме</a>	
</body>
</html>