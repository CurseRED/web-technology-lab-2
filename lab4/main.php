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
			// Инициализация кодировок
			mb_internal_encoding("UTF-8");
			mb_regex_encoding("UTF-8");
			$string = '';
			// Проверка запроса и получение аргументов
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				$string = $_GET["comment"];
			}
			$words = array();
			// Выделяем все слова из запроса c помощью регулярного выражения
			preg_match_all('/(\".+\")|(\S+)/u', $string, $words, PREG_SET_ORDER);
			// Проверка не пустой ли запрос
			if (count($words) == 0) {
				echo 'Введите хоть одно слово или словосочетание для поиска';
			} else {
				$words_to_find = array();
				$words_to_find_raw = array();
				// Отделяем слова для обычного и для строгого поиска
				for ($i = 0; $i < count($words); $i++) {
					if (mb_substr($words[$i][0], 0, 1) == '"') {
						$words_to_find_raw[] = mb_substr($words[$i][0], 1, mb_strlen($words[$i][0])-2);
					} else
						$words_to_find[] = $words[$i][0];
				}
				// Удаление окончаний
				for ($i = 0; $i < count($words_to_find); $i++) {
					$matches = array();
					preg_match_all('/ого|ями|ите|ишь|ете|ому|ему|ешь|его|ами|их|ых|ие|ые|им|ят|ым|ую|ет|ут|ют|ит|им|ат|юю|ее|яя|ая|ый|ий|ях|ах|ой|ое|ям|ам|ей|ов|а|ы|я|и|у|о|е|ю|ь/ui', $words_to_find[$i], $matches, PREG_OFFSET_CAPTURE);
					for ($j = 0; $j < count($matches[0]); $j++) {
						// Проверка что найдено окончание
						if (mb_strlen($words_to_find[$i]) > mb_strlen($matches[0][$j][0]) && mb_strlen($words_to_find[$i]) == mb_strlen($matches[0][$j][0]) + intdiv($matches[0][$j][1], 2)) {
							$words_to_find[$i] = mb_substr($words_to_find[$i], 0, mb_strlen($words_to_find[$i]) - mb_strlen($matches[0][$j][0]));
						}
					}
				}
				// Считывание 8-ми килобайт текста
				$srctext = file_get_contents('text.txt', FALSE, NULL, 0, 8192);
				echo '<p>Исходный текст: '.$srctext.'</p>';
				$words_sum = array();
				// Создаем регулярные выражения для нестрогого поиска
				for ($i = 0; $i < count($words_to_find); $i++) {
					$words_sum[] = '/'.preg_quote($words_to_find[$i]).'(ого|ями|ите|ишь|ете|ому|ему|ешь|его|ами|их|ых|ие|ые|им|ят|ым|ую|ет|ут|ют|ит|им|ат|юю|ее|яя|ая|ый|ий|ях|ах|ой|ое|ям|ам|ей|ов|а|ы|я|и|у|о|е|ю|ь)/ui';
				}
				// Создаем регулярные выражения для строгого поиска
				for ($i = 0; $i < count($words_to_find_raw); $i++) {
					$words_sum[] = '/'.preg_quote($words_to_find_raw[$i]).'/ui';
				}
				function callback_f($matches) {
					return '<mark>'.$matches[0].'</mark>';
				}
				// Замена нужного текста с помощью массива регулярных выражений
				$srctext = preg_replace_callback($words_sum, "callback_f", $srctext);
				echo '<p>Результат поиска: '.$srctext.'</p>';
			}
		?>
	</p>
	<a href="./lab4.php">Вернуться к форме</a>	
</body>
</html>