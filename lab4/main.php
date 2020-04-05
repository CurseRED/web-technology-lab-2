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
			// Выделяем все слова из запроса
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
				// Инициализируем окончания
				$endings = array('ь', 'а', 'я', 'и', 'ы', 'о', 'е', 'ов', 'ей', 'ам', 'ям', 'у', 'ю', 'ой', 'ами', 'ями', 'ах', 'ях', 'ий', 'ый', 'ая', 'яя', 'ое', 'ее', 'ого', 'его', 'их', 'ых', 'ие', 'ые', 'ому', 'ему', 'им', 'ым', 'ую', 'юю', 'ешь', 'ет', 'ут', 'ют', 'ете', 'ишь', 'ит', 'им', 'ите', 'ат', 'ят');
				function cmp($a, $b) {
					if (strlen($a) == strlen($b)) {
					return 0;
					}
					return (strlen($a) < strlen($b)) ? -1 : 1;
				}
				usort($endings, "cmp");
				$temp = array();
				// Удаление окончаний
				for ($i = count($endings) - 1; $i >= 0; $i--) {
					for ($j = 0; $j < count($words_to_find); $j++) {
						if (strlen($words_to_find[$j]) > strlen($endings[$i])) {
							if (preg_match('/'.$endings[$i].'$/u', $words_to_find[$j]) == 1) {
								$temp[] = mb_substr($words_to_find[$j], 0, -1*strlen($endings[$i]) + 1);
							}
						}
					}
				}
				// Считывание 8-ми килобайт текста
				$srctext = file_get_contents('text.txt', FALSE, NULL, 0, 8192);
				echo '<p>Исходный текст: '.$srctext.'</p>';
				// Добавление слов со всеми окончаниями в слова для поиска
				for ($i = 0; $i < count($temp); $i++) {
					for ($j = count($endings) - 1; $j >= 0; $j--) {
						$words_to_find[] = $temp[$i].$endings[$j];
					}
				}
				// Добавляем слова для строгого поиска в слова для поиска
				for ($i = 0; $i < count($words_to_find_raw); $i++) {
					$words_to_find[] = $words_to_find_raw[$i];
				}
				$word_regexp = $words_to_find;
				// Создание массива регулярных выражений и текста для замены
				for ($i = 0; $i < count($words_to_find); $i++) {
					$word_regexp[$i] = '/'.$words_to_find[$i].'/u';
					$words_to_find[$i] = '<mark>'.$words_to_find[$i].'</mark>';
				}
				ksort($word_regexp);
				ksort($words_to_find);
				// Замена нужного текста
				$srctext = preg_replace($word_regexp, $words_to_find, $srctext);
				echo '<p>Результат поиска: '.$srctext.'</p>';
			}
		?>
	</p>
	<a href="./lab4.php">Вернуться к форме</a>	
</body>
</html>